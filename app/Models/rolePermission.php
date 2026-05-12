<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rolePermission extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'role_permissions';

    protected $fillable =[
        'role_id',
        'permission_id',
        'created_by',
        'updated_by'
    ]

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function role()
    {
        return $this->belongsTo(role::class, 'role_id');
    }
    public function permission()
    {
        return $this->belongsTo(permission::class, 'permission_id');
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
