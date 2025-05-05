<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|array',
            'assigned_to.*' => 'exists:interns,id',
        ];

    
        if ($this->isMethod('put') || $this->isMethod('patch')) {
           $rules['assigned_to.*'] = 'nullable|exists:interns,id'; 
        }

        return $rules;
    }
}
