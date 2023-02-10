<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Relations\Pivot;

abstract class FeaturePlan extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'charges',
    ];

    /**
     * Returns the model's table name
     * 
     * @return string
     */
    public function getTable()
    {
        return Tithe::$featurePlanTableName;
    }

    /**
     * The feature
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feature()
    {
        return $this->belongsTo(Tithe::featureModel());
    }

    /**
     * The plan
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Tithe::planModel());
    }
}
