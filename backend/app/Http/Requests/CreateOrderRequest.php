<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            '*.productId' => 'required|numeric',
            '*.supplierId' => 'required|numeric',
            '*.quantity' => 'required|numeric|min:0',
            '*.totalPrice' => 'required|numeric|min:0'
        ];
    }
}
