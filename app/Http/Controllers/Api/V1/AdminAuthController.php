<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminAuthController
 *
 * Handles authentication, profile retrieval, and token revocation for administrative users.
 *
 * @package App\Http\Controllers\Api\V1
 */
class AdminAuthController extends ApiController
{
    /**
     * Authenticate admin credentials and issue a new Sanctum bearer token.
     *
     * @param AdminLoginRequest $request
     * @return JsonResponse
     */
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $admin = Admin::where('email', $request->input('email'))->first();

        if (!$admin || !Hash::check($request->input('password'), $admin->password)) {
            return $this->error('Invalid credentials', 401);
        }

        $deviceName = $request->input('device_name', 'admin-api-token');
        $token = $admin->createToken($deviceName)->plainTextToken;

        $roles = method_exists($admin, 'roles') && $admin->roles
            ? $admin->roles->pluck('name')->values()->toArray()
            : [];

        $permissions = method_exists($admin, 'getAllPermissions')
            ? $admin->getAllPermissions()->pluck('name')->values()->toArray()
            : [];

        return $this->success([
            'token_type'   => 'Bearer',
            'access_token' => $token,
            'user'         => [
                'id'          => $admin->id,
                'name'        => $admin->name,
                'email'       => $admin->email,
                'is_admin'    => true,
                'roles'       => $roles,
                'permissions' => $permissions,
            ],
        ], 'Admin authentication successful');
    }

    /**
     * Return the authenticated admin profile, roles, and permissions.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $admin = $request->user();

        $roles = method_exists($admin, 'roles') && $admin->roles
            ? $admin->roles->pluck('name')->values()->toArray()
            : [];

        $permissions = method_exists($admin, 'getAllPermissions')
            ? $admin->getAllPermissions()->pluck('name')->values()->toArray()
            : [];

        return $this->success([
            'id'          => $admin->id,
            'name'        => $admin->name,
            'email'       => $admin->email,
            'is_admin'    => true,
            'roles'       => $roles,
            'permissions' => $permissions,
        ], 'Admin profile retrieved successfully');
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
