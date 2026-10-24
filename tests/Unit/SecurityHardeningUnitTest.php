<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\BkashController;
use App\Models\FeesTransections;

class SecurityHardeningUnitTest extends TestCase
{
    use UploadAble;

    /**
     * Verify hardcoded production database credentials were removed.
     */
    public function test_mysql_configuration_does_not_contain_hardcoded_production_credentials()
    {
        $rawConfig = file_get_contents(config_path('database.php'));
        
        // Ensure default fallback values are safe non-production values in config/database.php
        $this->assertStringContainsString("'database' => env('DB_DATABASE', 'forge')", $rawConfig);
        $this->assertStringContainsString("'username' => env('DB_USERNAME', 'forge')", $rawConfig);
        $this->assertStringContainsString("'password' => env('DB_PASSWORD', '')", $rawConfig);
        $this->assertStringNotContainsString('satebwwt_icbdpayments', $rawConfig);
    }

    /**
     * Verify services.php contains bkash and sms configuration blocks.
     */
    public function test_services_configuration_contains_bkash_and_sms()
    {
        $this->assertArrayHasKey('bkash', config('services'));
        $this->assertArrayHasKey('sms', config('services'));
        $this->assertArrayHasKey('app_key', config('services.bkash'));
        $this->assertArrayHasKey('app_secret', config('services.bkash'));
        $this->assertArrayHasKey('user_name', config('services.bkash'));
        $this->assertArrayHasKey('password', config('services.bkash'));
        $this->assertArrayHasKey('base_url', config('services.bkash'));
        $this->assertArrayHasKey('url', config('services.sms'));
        $this->assertArrayHasKey('api_key', config('services.sms'));
        $this->assertArrayHasKey('sender_id', config('services.sms'));
    }

    /**
     * Verify UploadAble trait blocks dangerous executable file uploads.
     */
    public function test_uploadable_blocks_executable_file_extensions()
    {
        Storage::fake('public');

        $dangerousFiles = [
            UploadedFile::fake()->create('shell.php', 10, 'text/plain'),
            UploadedFile::fake()->create('exploit.phtml', 10, 'text/plain'),
            UploadedFile::fake()->create('script.phar', 10, 'text/plain'),
            UploadedFile::fake()->create('malware.exe', 10, 'application/octet-stream'),
            UploadedFile::fake()->create('payload.sh', 10, 'text/x-shellscript'),
            UploadedFile::fake()->create('script.bat', 10, 'application/x-bat'),
            UploadedFile::fake()->create('script.js', 10, 'application/javascript'),
            UploadedFile::fake()->create('page.html', 10, 'text/html'),
        ];

        foreach ($dangerousFiles as $file) {
            $blocked = false;
            try {
                $this->uploadOne($file, 'test_uploads');
            } catch (\InvalidArgumentException $e) {
                $blocked = true;
            }

            $this->assertTrue($blocked, "Failed asserting that dangerous file {$file->getClientOriginalName()} was blocked.");
        }
    }

    /**
     * Verify UploadAble trait blocks SVG uploads to eliminate stored XSS risks.
     */
    public function test_uploadable_blocks_svg_to_prevent_stored_xss()
    {
        Storage::fake('public');

        $svgPayload = '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>';
        $svgFile = UploadedFile::fake()->createWithContent('malicious.svg', $svgPayload);

        $blocked = false;
        try {
            $this->uploadOne($svgFile, 'test_uploads');
        } catch (\InvalidArgumentException $e) {
            $blocked = true;
        }

        $this->assertTrue($blocked, 'SVG upload must be blocked by UploadAble trait to prevent stored XSS.');
    }

    /**
     * Verify UploadAble accepts safe image files.
     */
    public function test_uploadable_accepts_valid_image()
    {
        Storage::fake('public');

        $validFile = UploadedFile::fake()->image('logo.png', 100, 100);
        $path = $this->uploadOne($validFile, 'test_uploads');

        $this->assertNotEmpty($path);
        Storage::disk('public')->assertExists($path);
    }

    /**
     * Verify Exception Handler redirects to 'login' and not undefined 'auth.login'.
     */
    public function test_unauthenticated_handler_redirects_to_login_route()
    {
        $handler = app(Handler::class);
        $request = Request::create('/user/dashboard', 'GET');
        $exception = new AuthenticationException('Unauthenticated.', ['web']);

        $reflection = new \ReflectionClass($handler);
        $method = $reflection->getMethod('unauthenticated');
        $method->setAccessible(true);

        $response = $method->invoke($handler, $request, $exception);

        $this->assertTrue($response->isRedirection());
        $this->assertEquals(route('login'), $response->getTargetUrl());
    }

    /**
     * Verify Admin LoginController has throttling methods available.
     */
    public function test_admin_login_controller_has_throttling_capabilities()
    {
        $controller = new LoginController();

        $this->assertTrue(method_exists($controller, 'hasTooManyLoginAttempts'));
        $this->assertTrue(method_exists($controller, 'incrementLoginAttempts'));
        $this->assertTrue(method_exists($controller, 'clearLoginAttempts'));
    }

    /**
     * Verify admin login POST route enforces rate limiting middleware.
     */
    public function test_admin_login_route_has_throttle_middleware()
    {
        $routes = app('router')->getRoutes();
        $route = $routes->getByName('admin.login.post');

        $this->assertNotNull($route, 'admin.login.post route must exist');
        $this->assertContains('throttle:5,1', $route->gatherMiddleware(), 'admin.login.post must have throttle:5,1 middleware');
    }

    /**
     * Verify maintenance routes only accept POST and reject GET methods.
     */
    public function test_maintenance_routes_are_post_only()
    {
        $routes = app('router')->getRoutes();
        $maintenanceRouteNames = [
            'admin.maintenance.storagelink',
            'admin.maintenance.optimize',
            'admin.maintenance.configcatche',
            'admin.maintenance.configclear',
            'admin.maintenance.viewclear',
            'admin.maintenance.cacheclear',
            'admin.maintenance.vendorpublish',
        ];

        foreach ($maintenanceRouteNames as $name) {
            $route = $routes->getByName($name);
            $this->assertNotNull($route, "Maintenance route [{$name}] must exist.");
            $this->assertEquals(['POST'], $route->methods(), "Route [{$name}] must only accept POST method.");
            $this->assertNotContains('GET', $route->methods(), "Route [{$name}] must not accept GET method.");
        }
    }

    /**
     * Verify SMS dispatch routes only accept POST and reject GET methods.
     */
    public function test_sms_routes_are_post_only()
    {
        $routes = app('router')->getRoutes();
        $smsRouteNames = [
            'admin.students.sms-due',
            'admin.students.sms-schedule',
            'admin.students.sms-remainder',
            'admin.students.sms-todaypostpond',
            'admin.students.sms-tomorrowpostpond',
            'admin.students.groupDueSMS',
            'admin.students.groupTdyPSMS',
            'admin.students.groupTomPSMS',
            'admin.students.groupTCR',
            'admin.students.groupNCS',
        ];

        foreach ($smsRouteNames as $name) {
            $route = $routes->getByName($name);
            $this->assertNotNull($route, "SMS route [{$name}] must exist.");
            $this->assertEquals(['POST'], $route->methods(), "Route [{$name}] must only accept POST method.");
            $this->assertNotContains('GET', $route->methods(), "Route [{$name}] must not accept GET method.");
        }
    }

    /**
     * Setup isolated SQLite in-memory database for testing database operations.
     */
    private function setupInMemoryDatabase()
    {
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]]);

        DB::purge('sqlite');
        DB::reconnect('sqlite');

        if (!Schema::connection('sqlite')->hasTable('fees_transections')) {
            Schema::connection('sqlite')->create('fees_transections', function ($table) {
                $table->increments('id');
                $table->unsignedBigInteger('student_id');
                $table->decimal('paidamount', 10, 2)->default(0);
                $table->integer('paymentType')->default(1);
                $table->date('paiddate');
                $table->string('paidremark')->nullable();
                $table->integer('channel')->default(2);
                $table->integer('status')->default(1);
                $table->string('trxID')->nullable();
                $table->string('paymentID')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Verify bKash callback rejects uncompleted payment statuses.
     */
    public function test_bkash_callback_rejects_uncompleted_status()
    {
        $controller = new BkashController();
        Session::put('student_id', 99);
        Session::put('arr', [
            'trxID' => 'FAILED_TRX_999',
            'transactionStatus' => 'Failed',
            'amount' => 1000,
        ]);

        $request = Request::create('/user/success', 'GET');
        $response = $controller->success($request);

        $this->assertTrue($response->isRedirection());
        $this->assertEquals(route('user.payment.history'), $response->getTargetUrl());
    }

    /**
     * Verify bKash callback idempotency prevents duplicate records on concurrent/duplicate requests.
     */
    public function test_bkash_callback_idempotency_prevents_duplicate_records()
    {
        $this->setupInMemoryDatabase();

        $controller = new BkashController();
        $trxId = 'BKASH_IDEMPOTENT_TRX_12345';
        $paymentSessionData = [
            'trxID' => $trxId,
            'paymentID' => 'PID_12345',
            'transactionStatus' => 'Completed',
            'amount' => 2500,
        ];

        // 1. First execution simulates initial successful callback
        Session::put('student_id', 42);
        Session::put('arr', $paymentSessionData);
        Session::put('response', json_encode($paymentSessionData));

        $request = Request::create('/user/success', 'GET');
        $response1 = $controller->success($request);
        $this->assertInstanceOf(\Illuminate\View\View::class, $response1);
        $this->assertEquals('users.profile.success', $response1->name());

        // Verify exactly 1 database row exists
        $this->assertEquals(1, FeesTransections::where('trxID', $trxId)->count());

        // 2. Second execution simulates duplicate/concurrent re-execution with identical trxID
        Session::put('student_id', 42);
        Session::put('arr', $paymentSessionData);
        Session::put('response', json_encode($paymentSessionData));

        $response2 = $controller->success($request);
        $this->assertInstanceOf(\Illuminate\View\View::class, $response2);
        $this->assertEquals('users.profile.success', $response2->name());

        // Verify still exactly 1 database row exists (no duplicate created!)
        $this->assertEquals(1, FeesTransections::where('trxID', $trxId)->count());
    }

    /**
     * Verify UploadAble trait blocks double-extension files (e.g. shell.php.jpg).
     */
    public function test_uploadable_blocks_double_extension_files()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('shell.php.jpg', 10, 'image/jpeg');

        $blocked = false;
        try {
            $this->uploadOne($file, 'test_uploads');
        } catch (\InvalidArgumentException $e) {
            $blocked = true;
        }

        $this->assertTrue($blocked, 'Double extension files like shell.php.jpg must be rejected.');
    }

    /**
     * Verify UploadAble trait rejects MIME and extension mismatches.
     */
    public function test_uploadable_blocks_mime_extension_mismatch()
    {
        Storage::fake('public');
        // File claims to be png but content MIME is text/plain
        $file = UploadedFile::fake()->create('fake_image.png', 10, 'text/plain');

        $blocked = false;
        try {
            $this->uploadOne($file, 'test_uploads');
        } catch (\InvalidArgumentException $e) {
            $blocked = true;
        }

        $this->assertTrue($blocked, 'MIME mismatch (text/plain with .png extension) must be rejected.');
    }

    /**
     * Verify user-controlled filename path traversal characters are sanitized.
     */
    public function test_uploadable_sanitizes_filename_path_traversal()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('valid.png', 100, 100);
        $path = $this->uploadOne($file, 'test_uploads', 'public', '../../malicious_name');

        $this->assertNotEmpty($path);
        $this->assertStringNotContainsString('..', $path);
        $this->assertStringContainsString('test_uploads/malicious_name.png', $path);
        Storage::disk('public')->assertExists($path);
    }

    /**
     * Verify admin login rate limiting lockout execution and reset behavior.
     */
    public function test_admin_login_lockout_behavior()
    {
        $controller = new LoginController();
        $request = Request::create('/admin/login', 'POST', [
            'email' => 'attacker@test.com',
            'password' => 'wrong-pass',
        ]);

        $reflection = new \ReflectionClass($controller);
        $incrementMethod = $reflection->getMethod('incrementLoginAttempts');
        $incrementMethod->setAccessible(true);
        $hasTooManyMethod = $reflection->getMethod('hasTooManyLoginAttempts');
        $hasTooManyMethod->setAccessible(true);
        $clearMethod = $reflection->getMethod('clearLoginAttempts');
        $clearMethod->setAccessible(true);

        // Simulate 5 failed attempts
        for ($i = 0; $i < 5; $i++) {
            $incrementMethod->invoke($controller, $request);
        }

        $this->assertTrue($hasTooManyMethod->invoke($controller, $request), 'Admin login should trigger lockout after 5 failed attempts.');

        // Verify successful login resets the counter
        $clearMethod->invoke($controller, $request);
        $this->assertFalse($hasTooManyMethod->invoke($controller, $request), 'Successful login / clear must reset failed attempt counter.');
    }

    /**
     * Verify GET request to POST-only maintenance route throws MethodNotAllowedHttpException.
     */
    public function test_get_request_to_post_only_route_throws_method_not_allowed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class);

        $request = Request::create('/admin/storagelink', 'GET');
        app('router')->dispatch($request);
    }

    /**
     * Verify UniSharp Laravel Filemanager routes are explicitly guarded by auth:admin middleware (SEC-04).
     */
    public function test_filemanager_routes_are_strictly_guarded_by_admin_middleware()
    {
        $routes = app('router')->getRoutes();
        $route = $routes->getByName('unisharp.lfm.show');
        $this->assertNotNull($route, "Route [unisharp.lfm.show] must be registered.");
        $this->assertEquals('laravel-filemanager', $route->uri());
        $this->assertContains('auth:admin', $route->middleware(), "LFM show route must require auth:admin guard.");

        $uploadRoute = $routes->getByName('unisharp.lfm.upload');
        $this->assertNotNull($uploadRoute, "Route [unisharp.lfm.upload] must be registered.");
        $this->assertEquals('laravel-filemanager/upload', $uploadRoute->uri());
        $this->assertContains('auth:admin', $uploadRoute->middleware(), "LFM upload route must require auth:admin guard.");
    }

    /**
     * Verify UniSharp Laravel Filemanager configuration has strict validation and prohibits SVG (SEC-04).
     */
    public function test_filemanager_configuration_has_strict_validation_and_no_svg()
    {
        $this->assertFalse(config('lfm.use_package_routes'), 'Package auto-routes must be disabled in favor of explicit auth:admin routes.');
        $this->assertTrue(config('lfm.should_validate_mime'), 'MIME validation must be enabled in lfm config.');
        $this->assertTrue(config('lfm.should_validate_size'), 'Size validation must be enabled in lfm config.');
        $this->assertTrue(config('lfm.rename_file'), 'File renaming must be enabled to prevent path traversal and arbitrary filenames.');
        $this->assertTrue(config('lfm.alphanumeric_filename'), 'Filename sanitization must enforce alphanumeric characters.');
        $this->assertNotContains('image/svg+xml', config('lfm.valid_image_mimetypes'), 'SVG must be prohibited in lfm valid image mimetypes.');
        $this->assertNotContains('image/svg+xml', config('lfm.valid_file_mimetypes'), 'SVG must be prohibited in lfm valid file mimetypes.');
    }

    /**
     * Verify bKash callback rejects missing paymentID or trxID (SEC-08).
     */
    public function test_bkash_callback_rejects_missing_payment_id_or_trx_id()
    {
        $controller = new BkashController();
        Session::put('student_id', 99);

        // Missing paymentID
        Session::put('arr', [
            'trxID' => 'TRX_123',
            'transactionStatus' => 'Completed',
            'amount' => 1000,
        ]);
        $request = Request::create('/user/success', 'GET');
        $response = $controller->success($request);
        $this->assertTrue($response->isRedirection());
        $this->assertEquals(route('user.payment.history'), $response->getTargetUrl());

        // Missing trxID
        Session::put('arr', [
            'paymentID' => 'PID_123',
            'transactionStatus' => 'Completed',
            'amount' => 1000,
        ]);
        $response2 = $controller->success($request);
        $this->assertTrue($response2->isRedirection());
        $this->assertEquals(route('user.payment.history'), $response2->getTargetUrl());
    }

    /**
     * Verify bKash execute rejects execution when session paymentID is missing (SEC-08).
     */
    public function test_bkash_execute_rejects_missing_session_payment_id()
    {
        Session::forget('paymentID');
        $controller = new BkashController();
        $response = $controller->execute();

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
    }
}
