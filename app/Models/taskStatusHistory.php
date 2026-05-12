<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class TaskStatusHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'task_status_histories';

    protected $fillable = [
        'task_id',
        'from_status',
        'to_status',
        'hold_duration_seconds',
        'remark',    
        'changed_by',
        'created_by'
    ];

    protected $casts = [
        'hold_duration_seconds' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }
    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }
}
