<?php

namespace Tithe\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tithe\Models\Concerns\HandlesRecurrence;

class Feature extends Model
{
    use HandlesRecurrence;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'consumable',
        'name',
        'periodicity_type',
        'periodicity',
        'quota',
        'postpaid',
    ];

    public function plans()
    {
        return $this->belongsToMany(config('soulbscription.models.plan'))
            ->using(config('soulbscription.models.feature_plan'));
    }

    public function tickets()
    {
        return $this->hasMany(config('soulbscription.models.feature_ticket'));
    }
}
