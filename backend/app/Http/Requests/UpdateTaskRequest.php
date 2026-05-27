<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('execution_status')) {

            $this->merge([
                'execution_status' =>
                    strtolower($this->execution_status)
            ]);
        }
    }

    public function rules(): array
    {
        return [

            'title' => 'sometimes|string|max:200',

            'description' => 'nullable|string',

            'project_id' => 'nullable|string',

            'current_department_id' => 'sometimes|string',

            'current_assignee_id' => 'sometimes|string',

            'workflow_template_id' => 'sometimes|string',

            'current_workflow_stage_id' => 'sometimes|string',

            'execution_status' => [
                'sometimes',
                'in:opened,in_progress,on_hold,completed,cancelled,closed'
            ]
        ];
    }
}
