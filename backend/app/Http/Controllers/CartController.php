<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHelper;
use App\Http\Requests\addItemToCartRequest;
use App\Services\CartService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new CartService();
    }


    public function addItemInCartForCurrentUser(addItemToCartRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->service->addItemInCartForCurrentUser(
            $validated['productId'],
            $validated['quantity'],
            $validated['unitPrice']
        );

        return ResponseHelper::sendSuccessJsonResponse(['status' => 'success']);
    }
}
