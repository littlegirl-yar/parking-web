<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->uncompromised()]
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'User name',
                'example' => 'yaromiradmin@gmail.com',
            ],
            'email' => [
                'description' => 'User email',
                'example' => 'yaromiradmin@gmail.com',
            ],
            'password' => [
                'description' => 'User password',
                'example' => 'yaromir228322',
            ],
        ];
    }
}
