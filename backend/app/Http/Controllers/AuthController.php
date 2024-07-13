<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseHelper;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected UserService $service;
    public function __construct()
    {
        $this->service = new UserService();
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $this->makeDataForRegisterFromRequest($request);

        try{
            $user = $this->service->createUser($data);
        } catch(\Exception $e) {
            return ResponseHelper::sendErrorJsonResponse($e->getMessage(), $e->getCode());
        }

        return ResponseHelper::sendSuccessJsonResponse(['id' => $user->id], 201);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return ResponseHelper::sendSuccessJsonResponse(['id' => Auth::id()]);
        }

        return ResponseHelper::sendErrorJsonResponse('invalid credentials', 401);
    }

    private function makeDataForRegisterFromRequest(UserRegisterRequest $request): array
    {
        $validated = $request->validated();
        return [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ];
    }
}
