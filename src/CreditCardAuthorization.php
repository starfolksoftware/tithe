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
        'subscriber_type',
        'email',
        'code',
        'default',
        'credit_card_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
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

    /**
     * Mark as default.
     * 
     * @param bool $value
     * @return void
     */
    public function markDefault(bool $value = true): void
    {
        $this->update([
            'default' => $value,
        ]);
    }
}
