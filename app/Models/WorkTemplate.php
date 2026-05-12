<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkTemplate extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'workflow_templates';
   protected $fillables = [
        'name',
        'code',
        'description',
        'is_active',
        'is_default',
        'created_by',
        'updated_by'
   ];

    public $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function workflow_stages()
    {
        return $this->hasMany(WorkflowStage::class, 'workflow_template_id');
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'workflow_template_id');
    }

    public function transitions()
    {
        return $this->hasMany(WorkFlowTransition::class, 'workflow_template_id');
    }

}
