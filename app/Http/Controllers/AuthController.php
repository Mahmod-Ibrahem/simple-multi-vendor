<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * مصادقة المستخدم - Authentication Controller
 */
class AuthController extends Controller
{
    /**
     * Login user and create token.
     * تسجيل دخول المستخدم وإنشاء رمز المصادقة
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Find user
        $user = User::where('email', $request->email)->first();

        // Check credentials
        if (!$user || !Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات الدخول غير صحيحة',
            ], 401);
        }

        // Check if user is active
        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'تم تعطيل هذا الحساب. يرجى التواصل مع المسؤول',
            ], 403);
        }

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ],
        ]);
    }

    /**
     * Logout user (revoke token).
     * تسجيل خروج المستخدم
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }

    /**
     * Get current authenticated user.
     * الحصول على بيانات المستخدم الحالي
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ]);
    }
}
