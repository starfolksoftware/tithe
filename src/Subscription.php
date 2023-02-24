<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Tithe\Scopes\ExpiringWithGraceDaysScope;
use Tithe\Scopes\StartingScope;
use Tithe\Scopes\SuppressingScope;

abstract class Subscription extends Model
{
    use ExpiresAndHasGraceDays;
    use HasFactory;
    use Starts;
    use Suppresses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'subscriber_id',
        'subscriber_type',
        'plan_id',
        'started_at',
        'canceled_at',
        'expired_at',
        'grace_days_ended_at',
        'suppressed_at',
        'was_switched',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'canceled_at' => 'datetime',
        'expired_at' => 'datetime',
        'grace_days_ended_at' => 'datetime',
        'suppressed_at' => 'datetime',
        'was_switched' => 'bool',
        'meta' => 'array',
    ];

    /**
     * Returns the table name.
     *
     * @return string
     */
    public function getTable(): string
    {
        return Tithe::$subscriptionTableName;
    }

    /**
     * The subscription plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Tithe::planModel());
    }

    /**
     * The subscription renewals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function renewals()
    {
        return $this->hasMany(Tithe::subscriptionRenewalModel());
    }

    /**
     * Get the subscription invoices
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptionInvoices()
    {
        return $this->hasMany(Tithe::subscriptionInvoiceModel());
    }

    /**
     * The subscriber.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subscriber()
    {
        return $this->morphTo('subscriber');
    }

    /**
     * Scope the records to subscriptions that are not active
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotActive(Builder $query)
    {
        return $query->withoutGlobalScopes([
            ExpiringWithGraceDaysScope::class,
            StartingScope::class,
            SuppressingScope::class,
        ])->where(function (Builder $query) {
            $query->where(fn (Builder $query) => $query->onlyExpired())
                ->orWhere(fn (Builder $query) => $query->onlyNotStarted())
                ->orWhere(fn (Builder $query) => $query->onlySuppressed());
        });
    }

    /**
     * Scope the records to subscriptions that are canceled
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCanceled(Builder $query)
    {
        return $query->whereNotNull('canceled_at');
    }

    /**
     * Scope the records to subscriptions that are not canceled
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotCanceled(Builder $query)
    {
        return $query->whereNull('canceled_at');
    }

    /**
     * Marks the subscription as switched.
     *
     * @return $this
     */
    public function markSwitched(): self
    {
        return $this->fill([
            'was_switched' => true,
        ]);
    }

    /**
     * Starts a subscription immediately or at a provided date.
     *
     * @param  \Illuminate\Support\Carbon|null  $startDate
     * @return $this
     */
    public function start(?Carbon $startDate = null): self
    {
        $startDate = $startDate ?: today();

        $this->fill(['started_at' => $startDate])
            ->save();

        if ($startDate->isToday()) {
            event(new Events\SubscriptionStarted($this));
        } elseif ($startDate->isFuture()) {
            event(new Events\SubscriptionScheduled($this));
        }

        return $this;
    }

    /**
     * Renews a subscription immediately or at a provided date.
     *
     * @param  \Illuminate\Support\Carbon|null  $startDate
     * @return $this
     */
    public function renew(?Carbon $expirationDate = null): self
    {
        $this->renewals()->create([
            'renewal' => true,
            'overdue' => $this->isOverdue,
        ]);

        $expirationDate = $this->getRenewedExpiration($expirationDate);

        $this->update([
            'expired_at' => $expirationDate,
        ]);

        event(new Events\SubscriptionRenewed($this));

        return $this;
    }

    /**
     * Cancels a subscription immediately or at a provided date.
     *
     * @param  \Illuminate\Support\Carbon|null  $startDate
     * @return $this
     */
    public function cancel(?Carbon $cancelDate = null): self
    {
        $cancelDate = $cancelDate ?: now();

        $this->fill(['canceled_at' => $cancelDate])
            ->save();

        event(new Events\SubscriptionCanceled($this));

        return $this;
    }

    /**
     * Suppresses a subscription immediately or at a provided date.
     *
     * @param  \Illuminate\Support\Carbon|null  $suppressAt
     * @return $this
     */
    public function suppress(?Carbon $suppressAt = null)
    {
        $date = $suppressAt ?: now();

        $this->fill(['suppressed_at' => $date])
            ->save();

        event(new Events\SubscriptionSuppressed($this));

        return $this;
    }

    /**
     * Get the is_overdue attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isOverdue(): Attribute
    {
        if ($this->grace_days_ended_at) {
            return Attribute::make(fn () => $this->expired_at->isPast() &&
                $this->grace_days_ended_at->isPast());
        }

        return Attribute::make(fn () => $this->expired_at->isPast());
    }

    /**
     * Returns the expiration date of a recently renewed subscription
     *
     * @param  \Illuminate\Support\Carbon|null  $expirationDate
     * @return \Illuminate\Support\Carbon
     */
    private function getRenewedExpiration(?Carbon $expirationDate = null)
    {
        if (! empty($expirationDate)) {
            return $expirationDate;
        }

        if ($this->isOverdue) {
            return $this->plan->calculateNextRecurrenceEnd();
        }

        return $this->plan->calculateNextRecurrenceEnd($this->expired_at);
    }
}
