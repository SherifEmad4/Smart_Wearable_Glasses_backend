<?php

namespace App\Traits;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

trait TokenValidation
{
    /**
     * Validate the token and return the user if valid.
     *
     * @return \Illuminate\Http\JsonResponse|\App\Models\User
     */
    public function validateToken()
    {
        try {
            // محاولة التحقق من التوكن
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        return $user; // إرجاع المستخدم إذا كان التوكن صالحًا
    }
}
