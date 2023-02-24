<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'quota' => 'bool',
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
     * The feature tickets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Tithe::featureTicketModel());
    }
}
