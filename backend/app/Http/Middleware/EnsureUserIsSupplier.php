<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSupplier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->roleInstance->getRole() === 'supplier') {
            return $next($request);
        }

        return ResponseHelper::sendErrorJsonResponse("Supplier authentication required", 401);
    }
}
