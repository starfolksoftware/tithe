<?php

namespace Tithe\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRenewal extends Model
{
    use HasFactory;

    protected $casts = [
        'overdue' => 'boolean',
        'renewal' => 'boolean',
    ];

    protected $fillable = [
        'overdue',
        'renewal',
    ];

    public function subscription()
    {
        return $this->belongsTo(config('soulbscription.models.subscription'));
    }
}
