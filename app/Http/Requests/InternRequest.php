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

        // Update case: ignore unique validation for current intern
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $internId = $this->route('id'); // or $this->intern if using route model binding
            $rules['email'] = 'required|email|unique:interns,email,' . $internId;
            $rules['password'] = 'nullable|string|min:6';
        } else {
            // Store case
            $rules['task_title'] = 'required|array';
            $rules['task_title.*'] = 'required|string|max:255';
            $rules['task_description'] = 'required|array';
            $rules['task_description.*'] = 'required|string|max:1000';
        }

        return $rules;
    }
}
