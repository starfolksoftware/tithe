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
        return Attribute::make(fn () => data_get($this->meta, 'amount'));
    }

    /**
     * The description attribute.
     */
    public function description(): Attribute
    {
        $action = data_get($this->meta, 'action');

        return Attribute::make(fn () => match ($action) {
            'upgrade' => 'upgrade to '.data_get($this->meta, 'to'),
            'renewal' => match ($this->subscription->plan->periodicity_type) {
                PeriodicityTypeEnum::YEAR->value => $this->subscription->expired_at->subYear()->format('Y').'-'.$this->subscription->expired_at->format('Y'),
                PeriodicityTypeEnum::MONTH->value => $this->subscription->expired_at->subMonth()->format('M d').'-'.$this->subscription->expired_at->format('M d'),
                PeriodicityTypeEnum::WEEK->value => $this->subscription->expired_at->subWeek()->format('W').'-'.$this->subscription->expired_at->format('W'),
                PeriodicityTypeEnum::DAY->value => $this->subscription->expired_at->subYear()->format('d').'-'.$this->subscription->expired_at->format('d'),
            },
        });
    }
}
