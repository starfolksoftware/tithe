<?php

namespace Tithe;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class CreditCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'signature',
        'type',
        'last4',
        'exp_month',
        'exp_year',
        'bin',
        'bank',
        'account_name',
        'country_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getTable()
    {
        return Tithe::$creditCardTableName;
    }

    /**
     * Get authorizations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authorizations()
    {
        return $this->hasMany(
            Tithe::creditCardAuthorizationModel(),
            Tithe::newCreditCardModel()->getForeignKey(),
        );
    }

    /**
     * Check if card has expired
     *
     * @return bool
     */
    public function expired()
    {
        $date = Carbon::create($this->exp_year, $this->exp_month);

        return now()->isAfter($date);
    }

    /**
     * Get the is expired attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isExpired(): Attribute
    {
        return Attribute::make(fn () => $this->expired());
    }
}
