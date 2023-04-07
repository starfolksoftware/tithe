<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Tithe\SubscriptionInvoice
 *
 * @property string $status
 * @property mixed $paid_at
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
}
