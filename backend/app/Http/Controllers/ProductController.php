<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Helpers\ResponseHelper;

class ProductController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function index(): JsonResponse
    {
        try {
            $products = $this->service->getAllProductsForSupplier();
        } catch (\Exception $e) {
            return ResponseHelper::sendErrorJsonResponse($e->getMessage(), $e->getCode());
        }

        return ResponseHelper::sendSuccessJsonResponse($products->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
