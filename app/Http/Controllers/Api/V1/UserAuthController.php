<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserAuthController
 *
 * Handles authentication, profile retrieval, and token revocation for student/user accounts.
 *
 * @package App\Http\Controllers\Api\V1
 */
class UserAuthController extends ApiController
{
    /**
     * Authenticate user credentials and issue a new Sanctum bearer token.
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return $this->error('Invalid credentials', 401);
        }

        $deviceName = $request->input('device_name', 'user-api-token');
        $token = $user->createToken($deviceName)->plainTextToken;

        return $this->success([
            'token_type'   => 'Bearer',
            'access_token' => $token,
            'user'         => [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'is_admin' => false,
            ],
        ], 'User authentication successful');
    }

    /**
     * Return the authenticated student/user profile.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->success([
            'id'       => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'is_admin' => false,
        ], 'User profile retrieved successfully');
    }

    /**
     * Revoke the current access token used for this request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return $this->success(null, 'Successfully logged out');
    }
}
