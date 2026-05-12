<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'actions';

    protected $fillable = [
        'name',
        'code',
        'description',
        'created_by',
        'updated_by'
    ];

    protected $attributes = [
        'description' => ''
    ];

    protected $casts = [
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
