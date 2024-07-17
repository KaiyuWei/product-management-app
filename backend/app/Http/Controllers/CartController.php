<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHelper;
use App\Http\Requests\addItemToCartRequest;
use App\Services\CartService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        $this->service->addItemInCartForUser(
            $user,
            $validated['productId'],
            $validated['quantity'],
            $validated['price']
        );

        return ResponseHelper::sendSuccessJsonResponse(['status' => 'success']);
    }

    public function getAllProductsInCart(): JsonResponse
    {
        $user = Auth::user();
        $items = $this->service->getAllCartItemsForUser($user);

        return ResponseHelper::sendSuccessJsonResponse($items->toArray());
    }
}
