<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected UserService $service;
    public function __construct()
    {
        $this->service = new UserService();
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dataForCreatingUser = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['email']),
        ];

        $user = $this->service->createUser($dataForCreatingUser);

        return response()->json([
            'status' => 'success',
            'data' => ['id' => $user->id],
        ], 201);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try{
            $token = $this->service->authenticateByEmailAndPassword($validated['email'], $validated['password']);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'errorMessage' => $e->getMessage()
            ], $e->getCode());
        }

        return response()->json([
            'status' => 'success',
            'data' => ['token' => $token]
        ]);
    }
}
