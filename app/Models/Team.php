<?php

namespace App\Models;


namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use MongoDB\Laravel\Eloquent\Model;


class Team extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'teams';

    
    protected $fillable = [
    'name',
    'code',
    'team_lead_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'team_lead_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function creator()
    { 
    return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
