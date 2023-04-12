<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tithe\Enums\PeriodicityTypeEnum;

/**
 * Tithe\SubscriptionInvoice
 *
 * @property string $status
 * @property mixed $paid_at
 * @property mixed $meta
 * @property mixed $expired_at
 * @property mixed $plan
 */
abstract class SubscriptionInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'subscriber_id',
        'subscriber_type',
        'subscription_id',
        'paid_at',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'paid_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * Returns the model's table name
     *
     * @return string
     */
    public function getTable()
    {
        return Tithe::$subscriptionInvoiceTableName;
    }

    /**
     * Get the subscription of the invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Tithe::subscriptionModel());
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
     * The amount attribute.
     */
    public function amount(): Attribute
    {
        $subscription = $this->subscription()
            ->withExpired()
            ->withSuppressed()
            ->first();

        $amount = data_get($this->meta, 'amount');

        return Attribute::make(fn () => $amount ? $subscription?->plan->currency . ($amount/100) : '');
    }

    /**
     * The description attribute.
     */
    public function description(): Attribute
    {
        $subscription = $this->subscription()
            ->withExpired()
            ->withSuppressed()
            ->first();

        if (is_null($subscription)) {
            return Attribute::make(fn () => '');
        }

        $action = data_get($this->meta, 'action');

        return Attribute::make(fn () => match ($action) {
            'upgrade' => 'upgrade to '.data_get($this->meta, 'to'),
            'renewal' => match ($subscription->plan->periodicity_type) {
                PeriodicityTypeEnum::YEAR->value => $subscription->expired_at->subYear()->format('Y').'-'.$subscription->expired_at->format('Y'),
                PeriodicityTypeEnum::MONTH->value => $subscription->expired_at->subMonth()->format('M d').'-'.$subscription->expired_at->format('M d'),
                PeriodicityTypeEnum::WEEK->value => $subscription->expired_at->subWeek()->format('W').'-'.$subscription->expired_at->format('W'),
                PeriodicityTypeEnum::DAY->value => $subscription->expired_at->subYear()->format('d').'-'.$subscription->expired_at->format('d'),
            },
        });
    }
}
