<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:interns,email',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $internId = $this->route('id'); 
            $rules['email'] = 'required|email|unique:interns,email,' . $internId;
            $rules['password'] = 'nullable|string|min:6';
        } else {
            // Store case
            $rules['task_title'] = 'nullable|array';
            $rules['task_title.*'] = 'nullable|string|max:255';
            $rules['task_description'] = 'nullable|array';
            $rules['task_description.*'] = 'nullable|string|max:1000';
        }

        return $rules;
    }
}
