<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class SubscriptionInvoicePayment extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'subscription_id',
        'line_items',
        'total',
        'due_date',
        'status',
        'paid_at',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'line_items' => 'array',
        'total' => 'integer',
        'due_date' => 'datetime',
        'paid_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * Returns the table name.
     */
    public function getTable(): string
    {
        return Tithe::$subscriptionInvoicePaymentTableName;
    }

    /**
     * Get the invoice of the payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Tithe::subscriptionInvoicePaymentModel(), Tithe::newSubscriptionInvoiceModel()->getForeignKey());
    }

    /**
     * Get the invoice payment authorization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function authorization()
    {
        return $this->belongsTo(Tithe::creditCardAuthorizationModel(), Tithe::newCreditCardAuthorizationModel()->getForeignKey());
    }

    /**
     * Get the subscription of the payment
     *
     * @return \Znck\Eloquent\Relations\BelongsToThrough
     */
    public function subscription()
    {
        return $this->belongsToThrough(
            Tithe::subscriptionModel(),
            Tithe::subscriptionInvoiceModel(),
            null,
            '',
            [
                Tithe::subscriptionModel() => Tithe::newSubscriptionModel()->getForeignKey(),
                Tithe::subscriptionInvoiceModel() => Tithe::newSubscriptionInvoiceModel()->getForeignKey(),
            ]
        );
    }
}
