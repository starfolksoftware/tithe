<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Tithe\Plan
 *
 * @property mixed $grace_days
 */
abstract class Plan extends Model
{
    use HandlesRecurrence;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'grace_days',
        'name',
        'display_name',
        'periodicity_type',
        'periodicity',
        'description',
        'currency',
        'amount',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * Returns the table name.
     */
    public function getTable(): string
    {
        return Tithe::$planTableName;
    }

    /**
     * The plan features.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function features()
    {
        return $this->belongsToMany(Tithe::featureModel())
            ->using(Tithe::featurePlanModel())
            ->withPivot(['charges']);
    }

    /**
     * The subscriptions of the plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Tithe::subscriptionModel());
    }

    /**
     * Calculate grace days ending date
     *
     * @return \Illuminate\Support\Carbon
     */
    public function calculateGraceDaysEnd(Carbon $subscriptionExpiresAt)
    {
        return $subscriptionExpiresAt->copy()->addDays($this->grace_days);
    }

    /**
     * The has_grace_days attribute
     */
    public function hasGraceDays(): Attribute
    {
        return Attribute::make(fn () => ! empty($this->grace_days));
    }
}
