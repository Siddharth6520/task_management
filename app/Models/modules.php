<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modules extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'modules';

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $attributes = [
        'description' => '',
        'is_active' => true
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
