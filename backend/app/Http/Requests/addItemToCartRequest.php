<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addItemToCartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'productId' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'unitPrice' => 'required|numeric|min:0'
        ];
    }
}
