<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        $roles = implode(',', User::ROLE_OPTIONS);
        return [
            'name' => 'required|max:20|min:3',
            'email' => 'required|email|max:50',
            'password' => 'required|min:5|max:50',
            'role' => 'required|in:' . $roles,
        ];
    }
}
