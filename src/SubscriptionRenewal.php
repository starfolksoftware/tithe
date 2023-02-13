<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class SubscriptionRenewal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'overdue',
        'renewal',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'overdue' => 'boolean',
        'renewal' => 'boolean',
    ];

    /**
     * Returns the model's table name
     *
     * @return string
     */
    public function getTable()
    {
        return Tithe::$subscriptionRenewalTableName;
    }

    /**
     * The subscription that owns the renewal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Tithe::subscriptionModel());
    }
}
