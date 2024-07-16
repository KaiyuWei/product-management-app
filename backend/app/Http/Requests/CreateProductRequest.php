<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:50',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => '',
        ];
    }
}
