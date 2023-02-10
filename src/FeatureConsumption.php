<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class FeatureConsumption extends Model
{
    use Expires;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'consumption',
        'expired_at',
    ];

    /**
     * The feature the consumption belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function feature()
    {
        return $this->belongsTo(Tithe::featureModel());
    }

    /**
     * The subscriber making the consumption.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subscriber()
    {
        return $this->morphTo('subscriber');
    }
}
