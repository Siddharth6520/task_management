<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attachment extends Model
{
    protected $connection = 'mongodb';
    protected $collction = 'attachments';

    protected $fillable = [
        'task_id',
        'workspace_id',
        'file_name',
        'file_path',
        'mime_type',
        'context',
        'file_size_bytes',
        'uploaded_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function task()
    {
        return $this->belongsTo(task::class, 'task_id');
    }
    public function workspace()
    {
        return $this->belongsTo(workspace::class, 'workspace_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
