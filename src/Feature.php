<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Tithe\Feature
 *
 * @property mixed $name
 */
abstract class Feature extends Model
{
    use HandlesRecurrence;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'consumable',
        'name',
        'periodicity_type',
        'periodicity',
        'quota',
        'postpaid',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'consumable' => 'boolean',
        'quota' => 'boolean',
        'postpaid' => 'boolean',
        'meta' => 'array',
    ];

    /**
     * Returns the table name.
     */
    public function getTable(): string
    {
        return Tithe::$featureTableName;
    }

    /**
     * The feature's plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plans()
    {
        return $this->belongsToMany(Tithe::planModel())
            ->using(Tithe::featurePlanModel())
            ->withPivot(['charges']);
    }

    /**
     * Returns a nice display for UI
     */
    public function displayLabel(?float $charge = null): string
    {
        return match ($this->name) {
            'users' => ++$charge.' user(s)',
            'activity-history' => "{$charge} day(s) activity history",
            'flocks' => "{$charge} flock(s)",
            'stock-counts' => "{$charge} stock counts per month",
            'consumptions' => "{$charge} consumption records per month",
            'productions' => "{$charge} production records per month",
            'recurring-reminders' => 'Recurring reminders',
            'reports' => 'Reports',
        };
    }
}
