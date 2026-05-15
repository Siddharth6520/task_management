<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'execution_status' =>
                strtolower($this->execution_status)
        ]);
    }

    public function rules(): array
    {
        return [

            'task_code' => 'required|string',

            'title' => 'required|string|max:200',

            'description' => 'nullable|string',

            'project_id' => 'nullable|string',

            'current_department_id' => 'required|string',

            'current_assignee_id' => 'required|string',

            'workflow_template_id' => 'required|string',

            'current_workflow_stage_id' => 'required|string',

            'execution_status' => [
                'required',
                'in:opened,in_progress,on_hold,completed,cancelled,closed'
            ]
        ];
    }   
    
}