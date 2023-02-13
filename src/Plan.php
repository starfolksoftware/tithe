<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'periodicity_type',
        'periodicity',
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
     *
     * @return string
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
            ->using(FeaturePlan::class)
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
     * @param  \Illuminate\Support\Carbon  $subscriptionExpiresAt
     * @return \Illuminate\Support\Carbon
     */
    public function calculateGraceDaysEnd(Carbon $subscriptionExpiresAt)
    {
        return $subscriptionExpiresAt->copy()->addDays($this->grace_days);
    }

    /**
     * The has_grace_days attribute
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function hasGraceDays(): Attribute
    {
        return Attribute::make(fn () => ! empty($this->grace_days));
    }
}