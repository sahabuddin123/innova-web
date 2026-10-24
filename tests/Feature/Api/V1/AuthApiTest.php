<?php

namespace Tests\Feature\Api\V1;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Class AuthApiTest
 *
 * Comprehensive feature tests for Phase 2.2 Authentication API.
 * Uses an isolated in-memory SQLite database to guarantee zero mutation of configured MySQL database.
 *
 * @package Tests\Feature\Api\V1
 */
class AuthApiTest extends TestCase
{
    /**
     * Set up test environment with normalized root URL and isolated SQLite in-memory database.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // 1. Force root URL for WampServer environment compatibility
        $this->app['config']->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        // 2. Enforce SQLite in-memory test database isolation
        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        // 3. Confirm isolation: assert connection driver is sqlite and database is :memory:
        $connection = DB::connection();
        if ($connection->getDriverName() !== 'sqlite' || $connection->getDatabaseName() !== ':memory:') {
            $this->fail('CRITICAL SAFETY CHECK FAILED: Test is not running on an isolated in-memory SQLite database!');
        }

        // 4. Create necessary tables for auth testing in SQLite in-memory
        $this->createTestTables();
    }

    /**
     * Create isolated schema in SQLite in-memory database.
     */
    protected function createTestTables(): void
    {
        Schema::create('admins', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('personal_access_tokens', function ($table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });

        Schema::create('roles', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('permissions', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('model_has_roles', function ($table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type']);
        });

        Schema::create('model_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type']);
        });

        Schema::create('role_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
        });
    }

    /**
     * Tear down test schema in SQLite in-memory database.
     */
    protected function tearDown(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::dropIfExists('role_has_permissions');
            Schema::dropIfExists('model_has_permissions');
            Schema::dropIfExists('model_has_roles');
            Schema::dropIfExists('permissions');
            Schema::dropIfExists('roles');
            Schema::dropIfExists('personal_access_tokens');
            Schema::dropIfExists('users');
            Schema::dropIfExists('admins');
        }

        parent::tearDown();
    }

    /**
     * 1. Test successful admin login returns token, profile, roles, and permissions.
     */
    public function test_successful_admin_login_returns_token_and_profile()
    {
        $admin = Admin::create([
            'name'     => 'System Administrator',
            'email'    => 'admin@innovacomputersbd.com',
            'password' => Hash::make('secret123'),
        ]);

        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'manage-courses', 'guard_name' => 'admin']);
        $admin->assignRole($role);
        $admin->givePermissionTo($permission);

        $response = $this->postJson('/api/v1/admin/auth/login', [
            'email'       => 'admin@innovacomputersbd.com',
            'password'    => 'secret123',
            'device_name' => 'test-device',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Admin authentication successful',
                'data'    => [
                    'token_type' => 'Bearer',
                    'user'       => [
                        'id'          => $admin->id,
                        'name'        => 'System Administrator',
                        'email'       => 'admin@innovacomputersbd.com',
                        'is_admin'    => true,
                        'roles'       => ['super-admin'],
                        'permissions' => ['manage-courses'],
                    ],
                ],
            ]);

        $this->assertNotEmpty($response->json('data.access_token'));
    }

    /**
     * 2. Test failed admin login with invalid password returns generic 401 error.
     */
    public function test_failed_admin_login_returns_generic_401()
    {
        Admin::create([
            'name'     => 'Admin User',
            'email'    => 'admin@test.com',
            'password' => Hash::make('correct-password'),
        ]);

        $response = $this->postJson('/api/v1/admin/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials',
            ]);
    }

    /**
     * 3. Test successful user/student login returns token and student profile.
     */
    public function test_successful_user_login_returns_token_and_profile()
    {
        $user = User::create([
            'name'     => 'Student Learner',
            'email'    => 'student@test.com',
            'password' => Hash::make('student123'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email'       => 'student@test.com',
            'password'    => 'student123',
            'device_name' => 'mobile-app',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User authentication successful',
                'data'    => [
                    'token_type' => 'Bearer',
                    'user'       => [
                        'id'       => $user->id,
                        'name'     => 'Student Learner',
                        'email'    => 'student@test.com',
                        'is_admin' => false,
                    ],
                ],
            ]);

        $this->assertNotEmpty($response->json('data.access_token'));
    }

    /**
     * 4. Test failed user login with non-existent email returns generic 401 error.
     */
    public function test_failed_user_login_returns_generic_401()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => 'nonexistent@test.com',
            'password' => 'any-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials',
            ]);
    }

    /**
     * 5. Test admin `me` endpoint with a valid admin token.
     */
    public function test_admin_me_endpoint_with_valid_admin_token()
    {
        $admin = Admin::create([
            'name'     => 'Admin Examiner',
            'email'    => 'examiner@test.com',
            'password' => Hash::make('password123'),
        ]);

        $token = $admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/admin/auth/me');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Admin profile retrieved successfully',
                'data'    => [
                    'id'       => $admin->id,
                    'name'     => 'Admin Examiner',
                    'email'    => 'examiner@test.com',
                    'is_admin' => true,
                ],
            ]);
    }

    /**
     * 6. Test user `me` endpoint with a valid user token.
     */
    public function test_user_me_endpoint_with_valid_user_token()
    {
        $user = User::create([
            'name'     => 'Enrolled Student',
            'email'    => 'enrolled@test.com',
            'password' => Hash::make('password123'),
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User profile retrieved successfully',
                'data'    => [
                    'id'       => $user->id,
                    'name'     => 'Enrolled Student',
                    'email'    => 'enrolled@test.com',
                    'is_admin' => false,
                ],
            ]);
    }

    /**
     * 7. Test unauthenticated access to protected endpoints returns HTTP 401.
     */
    public function test_unauthenticated_access_to_protected_endpoints_returns_401()
    {
        $adminMeResponse = $this->getJson('/api/v1/admin/auth/me');
        $adminMeResponse->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);

        $userMeResponse = $this->getJson('/api/v1/auth/me');
        $userMeResponse->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * 8. Test admin token is rejected by user-only endpoints with HTTP 403 Forbidden.
     */
    public function test_admin_token_rejected_by_user_only_endpoints()
    {
        $admin = Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'super@test.com',
            'password' => Hash::make('password123'),
        ]);

        $adminToken = $admin->createToken('admin-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $adminToken)
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Forbidden: User access required',
            ]);
    }

    /**
     * 9. Test user token is rejected by admin-only endpoints with HTTP 403 Forbidden.
     */
    public function test_user_token_rejected_by_admin_only_endpoints()
    {
        $user = User::create([
            'name'     => 'Standard User',
            'email'    => 'standard@test.com',
            'password' => Hash::make('password123'),
        ]);

        $userToken = $user->createToken('user-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $userToken)
            ->getJson('/api/v1/admin/auth/me');

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Forbidden: Admin access required',
            ]);
    }

    /**
     * 10. Test logout revokes the current token and makes subsequent requests 401.
     */
    public function test_logout_revokes_current_token()
    {
        $admin = Admin::create([
            'name'     => 'Logout Admin',
            'email'    => 'logout@test.com',
            'password' => Hash::make('password123'),
        ]);

        $token = $admin->createToken('active-token')->plainTextToken;

        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/admin/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Successfully logged out',
            ]);

        // Verify token was deleted from database
        $this->assertEquals(0, DB::table('personal_access_tokens')->count());

        // Reset auth guard cache between simulated requests in same test process
        app('auth')->forgetGuards();

        // Subsequent access with revoked token must fail with 401
        $meResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/admin/auth/me');

        $meResponse->assertStatus(401);
    }

    /**
     * 11. Test login rate limiting triggers HTTP 429 Too Many Attempts.
     */
    public function test_login_rate_limiting_triggers_429()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/v1/admin/auth/login', [
                'email'    => 'attacker@test.com',
                'password' => 'wrong-pass',
            ]);
        }

        // 6th attempt should be blocked by throttle:5,1
        $response = $this->postJson('/api/v1/admin/auth/login', [
            'email'    => 'attacker@test.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertStatus(429);
    }

    /**
     * 12. Test baseline ping endpoint regression.
     */
    public function test_ping_endpoint_regression()
    {
        $response = $this->getJson('/api/v1/ping');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'API v1 foundation operational',
            ]);
    }

    /**
     * 13. Test validation errors return HTTP 422 with standardized JSON envelope.
     */
    public function test_validation_errors_return_standard_422_envelope()
    {
        $response = $this->postJson('/api/v1/admin/auth/login', [
            'email' => 'invalid-email',
            // missing password
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'The given data was invalid.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'errors' => [
                    'email',
                    'password',
                ],
            ]);
    }
}
