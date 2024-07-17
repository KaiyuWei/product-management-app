<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function indexProductsOfCurrentSupplierUser(): JsonResponse
    {
        try {
            $user = Auth::user();
            $products = $this->service->getAllProductsForSupplier($user);
        } catch (\Exception $e) {
            return ResponseHelper::sendErrorJsonResponse($e->getMessage(), $e->getCode());
        }

        return ResponseHelper::sendSuccessJsonResponse($products->toArray());
    }

    public function indexForCustomer(): JsonResponse
    {
        try {
            $products = $this->service->getAllProductsWithSupplierData();
        } catch (\Exception $e) {
            return ResponseHelper::sendErrorJsonResponse($e->getMessage(), $e->getCode());
        }

        return ResponseHelper::sendSuccessJsonResponse($products->toArray());
    }

    public function create(CreateProductRequest $request): JsonResponse
    {
        try {
            $supplierUser = Auth::user();
            $validated = $request->validated();

            $product = $this->service->createProductForSupplier($validated, $supplierUser);
        } catch (\Exception $e) {
            return ResponseHelper::sendErrorJsonResponse($e->getMessage(), $e->getCode());
        }

        return ResponseHelper::sendSuccessJsonResponse($product->toArray(), 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
