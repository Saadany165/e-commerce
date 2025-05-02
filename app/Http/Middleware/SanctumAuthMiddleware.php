<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class SanctumAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // جلب التوكن من الكوكي
        $token = urldecode($request->cookie('auth_token'));

        // التحقق إذا كان التوكن موجودًا
        if (!$token) {
            return response()->json(['error' => 'Unauthorized - No Token'], 401);
        }

        // التحقق من صحة التوكن
        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken || !$accessToken->tokenable) {
            return response()->json(['error' => 'Unauthorized - Invalid Token'], 401);
        }

        // تسجيل دخول المستخدم بناءً على التوكن
        auth()->login($accessToken->tokenable);

        return $next($request);
    }
}
