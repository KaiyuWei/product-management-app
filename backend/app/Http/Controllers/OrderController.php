<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHelper;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    public function placeOrder(CreateOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = Auth::user()->load('customer');

        $order = $this->service->createOrderForUser($user, $validated);
        return ResponseHelper::sendSuccessJsonResponse(['orderId' => $order->id]);
    }
}
