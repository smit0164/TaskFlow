<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    public function rules(): array
    {
       
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:interns,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ];
    }
}
