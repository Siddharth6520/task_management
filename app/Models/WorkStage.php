<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class WorkStage extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'workflow_stages';

    protected $fillable = [
        'workflow_template_id',
        'stage_name',
        'stage_order',
        'department_id',
        'role_id',
        'can_skip',
        'can_rework',
        'is_mandatory',
        'is_final_stage',
        'sla_hours',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public $casts = [
        'can_skip' => 'boolean',
        'can_rework' => 'boolean',
        'is_mandatory' => 'boolean',
        'is_final_stage' => 'boolean',
        'sla_hours' => 'double',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function workflow_template()
    {
        return $this->belongsTo(WorkTemplate::class, 'workflow_template_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }
}


