<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'current_department_id',
        'current_assignee_id',
        'workflow_template_id',
        'current_workflow_stage_id',
        'execution_status',
        'created_by'
    ];

    public $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function current_department()
    {
        return $this->belongsTo(Department::class, 'current_department_id');
    }

    public function current_assignee()
    {
        return $this->belongsTo(User::class, 'current_assignee_id');
    }

    public function workflow_template()
    {
        return $this->belongsTo(WorkflowTemplate::class, 'workflow_template_id');
    }

    public function current_workflow_stage()
    {
        return $this->belongsTo(WorkflowStage::class, 'current_workflow_stage_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class, 'task_id');
    // }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'task_id');
    }

    public function history()
    {
        return $this->hasMany(TaskHistory::class, 'task_id');
    }
 
}
