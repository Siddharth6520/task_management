<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;


class WorkFlowTransition extends Model
{
    public $collection = 'workflow_transitions';

    protected $cast = [
        'transitioned_at' => 'datetime'
    ];

    protected $fillable = [
        'task_id',
        'from_department_id',
        'to_department_id',
        'trasition_type',
        'from_workflow_stage_id',
        'to_workflow_stage_id',
        'from_assignee_id',
        'to_assignee_id',
        'transitioned_by'
    ];

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }

    public function from_department()
    {
        return $this->belongsTo(Department::class, 'from_department_id');
    }

    public function to_department()
    {
        return $this->belongsTo(Department::class, 'to_department_id');
    }

    public function from_assignee()
    {
        return $this->belongsTo(User::class, 'from_assignee_id');
    }

    public function to_assignee()
    {
        return $this->belongsTo(User::class, 'to_assignee_id');
    }

    public function from_workflow_stage()
    {
        return $this->belongsTo(WorkStage::class, 'from_workflow_stage_id');
    }

    public function to_workflow_stage()
    {
        return $this->belongsTo(WorkStage::class, 'to_workflow_stage_id');
    }

    public function transitioned_by()
    {
        return $this->belongsTo(User::class, 'transitioned_by');
    }
}
