<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'permissions';

    protected $fillable = [
        'module_id',
        'action_id',
        'code',
        'name',
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

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }
    public function creator()
    { 
        return $this->belongsTo(User::class, 'created_by'); 
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
