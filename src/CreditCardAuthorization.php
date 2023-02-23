<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class CreditCardAuthorization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'subscriber_id',
        'email',
        'auth',
        'code',
        'default',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'auth' => 'array',
        'default' => 'bool',
    ];

    /**
     * The attributes that should be appended
     */
    protected $appends = [];

    public function getTable()
    {
        return Tithe::$creditCardAuthorizationTableName;
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
     * Get payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(
            Tithe::subscriptionInvoiceModel(),
            Tithe::newSubscriptionInvoiceModel()->getForeignKey()
        );
    }

    /**
     * Get Credit Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creditCard()
    {
        return $this->belongsTo(
            Tithe::creditCardModel(),
            Tithe::newCreditCardModel()->getForeignKey()
        );
    }
}
