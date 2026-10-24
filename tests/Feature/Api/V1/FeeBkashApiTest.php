<?php

namespace Tests\Feature\Api\V1;

use App\Models\Admin;
use App\Models\Batchs;
use App\Models\CourseCategory;
use App\Models\Courses;
use App\Models\FeesTransections;
use App\Models\Students;
use App\Models\User;
use App\Services\BkashService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Class FeeBkashApiTest
 *
 * Feature tests for Phase 2.5 — Fees Collection, Transactions & bKash Reconciliation APIs.
 * Runs strictly against an isolated in-memory SQLite database (:memory:) to guarantee zero MySQL writes.
 * Mocks the external bKash payment gateway to ensure zero live calls are made.
 *
 * @package Tests\Feature\Api\V1
 */
class FeeBkashApiTest extends TestCase
{
    /**
     * @var Admin
     */
    protected $superAdmin;

    /**
     * @var string
     */
    protected $superAdminToken;

    /**
     * @var Admin
     */
    protected $limitedAdmin;

    /**
     * @var string
     */
    protected $limitedAdminToken;

    /**
     * @var User
     */
    protected $studentUserA;

    /**
     * @var Students
     */
    protected $studentA;

    /**
     * @var string
     */
    protected $studentTokenA;

    /**
     * @var User
     */
    protected $studentUserB;

    /**
     * @var Students
     */
    protected $studentB;

    /**
     * @var string
     */
    protected $studentTokenB;

    /**
     * @var Courses
     */
    protected $testCourse;

    /**
     * @var Batchs
     */
    protected $testBatch;

    /**
     * Set up isolated test environment with in-memory SQLite database and test fixtures.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $connection = DB::connection();
        if ($connection->getDriverName() !== 'sqlite' || $connection->getDatabaseName() !== ':memory:') {
            $this->fail('CRITICAL SAFETY CHECK: FeeBkashApiTest is not running on an isolated SQLite database!');
        }

        $this->createTestTables();
        $this->seedTestData();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Create isolated schema in SQLite memory.
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
        });

        Schema::create('model_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
        });

        Schema::create('role_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
        });

        Schema::create('course_categories', function ($table) {
            $table->id();
            $table->string('CourseCategoris');
            $table->string('icon')->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('courses', function ($table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('shortTitle')->nullable();
            $table->string('name');
            $table->string('coursefee');
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('batchs', function ($table) {
            $table->id();
            $table->string('batchnum');
            $table->string('totalseat');
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('students', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('batch_id');
            $table->string('sname');
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('phone')->nullable();
            $table->string('g_name')->nullable();
            $table->string('g_phone')->nullable();
            $table->string('rel_g')->nullable();
            $table->string('course_fee')->default('0');
            $table->string('discount')->default('0');
            $table->string('balance')->default('0');
            $table->date('admission_date')->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('fees_transections', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->string('paidamount');
            $table->string('paymentType')->default('1');
            $table->date('paiddate');
            $table->text('paidremark')->nullable();
            $table->unsignedInteger('channel')->default(1)->nullable();
            $table->string('trxID')->nullable();
            $table->string('paymentID')->nullable();
            $table->unsignedInteger('status')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Seed initial auth principals, roles, permissions, and student entities.
     */
    protected function seedTestData(): void
    {
        $superRole = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        Role::create(['name' => 'User', 'guard_name' => 'web']);

        $permFeeList   = Permission::create(['name' => 'fees-list', 'guard_name' => 'admin']);
        $permFeeLog    = Permission::create(['name' => 'fees-log', 'guard_name' => 'admin']);
        $permFeeCreate = Permission::create(['name' => 'fees-create', 'guard_name' => 'admin']);
        $permFeeEdit   = Permission::create(['name' => 'fees-edit', 'guard_name' => 'admin']);
        $permFeeDelete = Permission::create(['name' => 'fees-delete', 'guard_name' => 'admin']);

        // Super Admin
        $this->superAdmin = Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@innova.com',
            'password' => Hash::make('password123'),
        ]);
        $this->superAdmin->assignRole($superRole);
        $this->superAdminToken = $this->superAdmin->createToken('admin-token')->plainTextToken;

        // Limited Admin without fees-create or fees-delete permissions
        $this->limitedAdmin = Admin::create([
            'name'     => 'Viewer Admin',
            'email'    => 'viewer@innova.com',
            'password' => Hash::make('password123'),
        ]);
        $this->limitedAdmin->givePermissionTo($permFeeList);
        $this->limitedAdminToken = $this->limitedAdmin->createToken('viewer-token')->plainTextToken;

        // Academic Course & Batch
        $cat = CourseCategory::create(['CourseCategoris' => 'IT Professional', 'IsActive' => 1]);
        $this->testCourse = Courses::create([
            'category_id' => $cat->id,
            'name'        => 'Web Development',
            'shortTitle'  => 'WD',
            'coursefee'   => '20000',
            'IsActive'    => 1,
        ]);
        $this->testBatch = Batchs::create([
            'batchnum'  => 'WD-2026-01',
            'totalseat' => '30',
            'IsActive'  => 1,
        ]);

        // Student A ($20000 course fee, $5000 discount, balance/net payable = $15000)
        $this->studentUserA = User::create([
            'name'     => 'Student Alpha',
            'email'    => 'alpha@test.com',
            'password' => Hash::make('secret123'),
        ]);
        $this->studentA = Students::create([
            'user_id'        => $this->studentUserA->id,
            'course_id'      => $this->testCourse->id,
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Student Alpha',
            'phone'          => '01711111111',
            'course_fee'     => '20000',
            'discount'       => '5000',
            'balance'        => '15000', // net payable
            'admission_date' => '2026-01-10',
            'IsActive'       => 1,
        ]);
        $this->studentTokenA = $this->studentUserA->createToken('student-a-token')->plainTextToken;

        // Student B ($20000 course fee, $0 discount, balance = $20000)
        $this->studentUserB = User::create([
            'name'     => 'Student Beta',
            'email'    => 'beta@test.com',
            'password' => Hash::make('secret123'),
        ]);
        $this->studentB = Students::create([
            'user_id'        => $this->studentUserB->id,
            'course_id'      => $this->testCourse->id,
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Student Beta',
            'phone'          => '01722222222',
            'course_fee'     => '20000',
            'discount'       => '0',
            'balance'        => '20000',
            'admission_date' => '2026-01-15',
            'IsActive'       => 1,
        ]);
        $this->studentTokenB = $this->studentUserB->createToken('student-b-token')->plainTextToken;
    }

    public function test_public_user_cannot_access_fee_endpoints()
    {
        $this->getJson('/api/v1/fees/transactions')->assertStatus(401);
        $this->getJson('/api/v1/fees/my-balance')->assertStatus(401);
        $this->getJson('/api/v1/fees/students/' . $this->studentA->id . '/balance')->assertStatus(401);
        $this->postJson('/api/v1/fees/transactions', [])->assertStatus(401);
        $this->postJson('/api/v1/fees/bkash/create', [])->assertStatus(401);
        $this->postJson('/api/v1/fees/bkash/callback', [])->assertStatus(401);
    }

    public function test_student_token_rejected_on_admin_fee_routes()
    {
        // Student attempting to list all fee transactions -> 403 Forbidden
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->getJson('/api/v1/fees/transactions');
        $response->assertStatus(403);

        // Student attempting to record a manual counter transaction -> 403 Forbidden
        $storeResponse = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/transactions', [
                'student_id'  => $this->studentA->id,
                'paidamount'  => 5000,
                'paymentType' => 1,
                'paiddate'    => '2026-02-01',
                'paidremark'  => 'Attempted self-credit',
            ]);
        $storeResponse->assertStatus(403);
    }

    public function test_admin_without_fees_create_permission_cannot_record_payment()
    {
        // Limited admin only has fees-list, not fees-create
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->limitedAdminToken)
            ->postJson('/api/v1/fees/transactions', [
                'student_id'  => $this->studentA->id,
                'paidamount'  => 5000,
                'paymentType' => 1,
                'paiddate'    => '2026-02-01',
                'paidremark'  => 'Counter payment',
            ]);

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_admin_can_record_fee_payment_and_verifies_balance_calculation()
    {
        // Student A has net payable 15000. Collect 5000 payment.
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/fees/transactions', [
                'student_id'  => $this->studentA->id,
                'paidamount'  => 5000,
                'paymentType' => 1,
                'paiddate'    => '2026-02-01',
                'paidremark'  => 'First Installment Cash',
                'channel'     => 1,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.transaction.student_id', $this->studentA->id)
            ->assertJsonPath('data.transaction.paidamount', '5000.00')
            ->assertJsonPath('data.transaction.status', 0)
            ->assertJsonPath('data.financial_summary.total_paid', 5000)
            ->assertJsonPath('data.financial_summary.due_amount', 10000);

        // Record second payment of 3000
        $response2 = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/fees/transactions', [
                'student_id'  => $this->studentA->id,
                'paidamount'  => 3000,
                'paymentType' => 1,
                'paiddate'    => '2026-02-15',
                'paidremark'  => 'Second Installment Cash',
            ]);

        $response2->assertStatus(201)
            ->assertJsonPath('data.financial_summary.total_paid', 8000)
            ->assertJsonPath('data.financial_summary.due_amount', 7000);
    }

    public function test_fee_recording_validation_errors()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/fees/transactions', [
                'student_id'  => 999999, // non-existent student
                'paidamount'  => -50,   // negative amount
                'paymentType' => 99,    // invalid type
                'paiddate'    => 'not-a-date',
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['student_id', 'paidamount', 'paymentType', 'paiddate', 'paidremark']]);
    }

    public function test_student_can_view_own_balance_and_history_via_my_balance()
    {
        // Pre-create 1 approved payment of 4000 for Student A
        FeesTransections::create([
            'student_id'  => $this->studentA->id,
            'user_id'     => $this->studentUserA->id,
            'paidamount'  => '4000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-01',
            'paidremark'  => 'Cash Counter',
            'channel'     => 1,
            'status'      => 0,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->getJson('/api/v1/fees/my-balance');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.student.id', $this->studentA->id)
            ->assertJsonPath('data.account_summary.total_course_fee', 20000)
            ->assertJsonPath('data.account_summary.discount', 5000)
            ->assertJsonPath('data.account_summary.net_payable', 15000)
            ->assertJsonPath('data.account_summary.total_paid_course', 4000)
            ->assertJsonPath('data.account_summary.due_course_fee', 11000)
            ->assertJsonCount(1, 'data.transactions');
    }

    public function test_student_cannot_view_another_students_balance_via_id_tampering()
    {
        // Student A attempting to query Student B's balance -> 403 Forbidden
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->getJson('/api/v1/fees/students/' . $this->studentB->id . '/balance');

        $response->assertStatus(403)
            ->assertJson(['success' => false]);
    }

    public function test_student_cannot_view_another_students_transaction_or_receipt()
    {
        // Transaction belonging to Student B
        $trxB = FeesTransections::create([
            'student_id'  => $this->studentB->id,
            'user_id'     => $this->studentUserB->id,
            'paidamount'  => '6000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-10',
            'paidremark'  => 'Cash',
            'channel'     => 1,
            'status'      => 0,
        ]);

        // Student A trying to view Student B's transaction details -> 403 Forbidden
        $detailResponse = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->getJson('/api/v1/fees/transactions/' . $trxB->id);
        $detailResponse->assertStatus(403);

        // Student A trying to view Student B's receipt -> 403 Forbidden
        $receiptResponse = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->getJson('/api/v1/fees/transactions/' . $trxB->id . '/receipt');
        $receiptResponse->assertStatus(403);

        // Clear cached guard before authenticating with Student B token
        app('auth')->forgetGuards();

        // Student B can view their own receipt -> 200 OK
        $ownReceiptResponse = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenB)
            ->getJson('/api/v1/fees/transactions/' . $trxB->id . '/receipt');
        $ownReceiptResponse->assertStatus(200)
            ->assertJsonPath('data.student.id', $this->studentB->id)
            ->assertJsonPath('data.paid_amount', 6000);
    }

    public function test_admin_cannot_delete_fee_transaction_to_protect_audit_trails()
    {
        $trx = FeesTransections::create([
            'student_id'  => $this->studentA->id,
            'paidamount'  => '5000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-01',
            'paidremark'  => 'Cash',
            'channel'     => 1,
            'status'      => 0,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->deleteJson('/api/v1/fees/transactions/' . $trx->id);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);

        $this->assertDatabaseHas('fees_transections', ['id' => $trx->id]);
    }

    public function test_admin_can_update_transaction_status()
    {
        // Pending transaction (status = 1)
        $trx = FeesTransections::create([
            'student_id'  => $this->studentA->id,
            'paidamount'  => '5000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-01',
            'paidremark'  => 'Pending bKash payment',
            'channel'     => 2,
            'status'      => 1,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->putJson('/api/v1/fees/transactions/' . $trx->id . '/status', [
                'status' => 0, // Approve
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.transaction.status', 0)
            ->assertJsonPath('data.financial_summary.total_paid', 5000)
            ->assertJsonPath('data.financial_summary.due_amount', 10000);
    }

    public function test_admin_can_filter_and_paginate_transactions()
    {
        FeesTransections::create([
            'student_id'  => $this->studentA->id,
            'paidamount'  => '2000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-01',
            'paidremark'  => 'Counter 1',
            'channel'     => 1,
            'status'      => 0,
        ]);
        FeesTransections::create([
            'student_id'  => $this->studentB->id,
            'paidamount'  => '4000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-05',
            'paidremark'  => 'bKash 1',
            'channel'     => 2,
            'trxID'       => 'BKASH_TEST_TRX_999',
            'status'      => 1,
        ]);

        // Filter by channel 2 (bKash)
        $channelResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/fees/transactions?channel=2');
        $channelResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.trxID', 'BKASH_TEST_TRX_999');

        // Filter by student_id
        $studentResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/fees/transactions?student_id=' . $this->studentA->id);
        $studentResponse->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.student_id', $this->studentA->id);
    }

    public function test_bkash_payment_initiation_with_mocked_gateway()
    {
        $mockService = Mockery::mock(BkashService::class);
        $mockService->shouldReceive('createPayment')
            ->once()
            ->with(5000.0)
            ->andReturn([
                'paymentID'             => 'BKASH_PAYMENT_12345',
                'createTime'            => '2026-10-24T12:00:00Z',
                'orgLogo'               => 'https://example.com/logo.png',
                'orgName'               => 'INNOVA Computers BD',
                'transactionStatus'     => 'Initiated',
                'amount'                => '5000',
                'currency'              => 'BDT',
                'merchantInvoiceNumber' => 'Inv_ABCDEF12',
                'bkashURL'              => 'https://checkout.pay.bka.sh/checkout?paymentID=BKASH_PAYMENT_12345',
            ]);

        $this->app->instance(BkashService::class, $mockService);

        // Student A initiates payment of 5000 for their own account
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/bkash/create', [
                'amount' => 5000,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.paymentID', 'BKASH_PAYMENT_12345')
            ->assertJsonPath('data.amount', '5000')
            ->assertJsonPath('data.student_id', $this->studentA->id);
    }

    public function test_bkash_payment_initiation_rejects_amount_exceeding_due_balance()
    {
        // Student A net payable is 15000, attempts to initiate 25000
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/bkash/create', [
                'amount' => 25000,
            ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_bkash_callback_verifies_payment_and_enforces_idempotency()
    {
        $paymentID = 'BKASH_PAY_CONFIRMED_777';
        $trxID     = 'TRX_BKASH_MOCK_SUCCESS_888';

        // Pre-seed payment intent as generated during createPayment
        \Illuminate\Support\Facades\Cache::put('bkash_intent_' . $paymentID, [
            'payment_id'      => $paymentID,
            'student_id'      => (int) $this->studentA->id,
            'user_id'         => (int) $this->studentUserA->id,
            'initiator_id'    => (int) $this->studentUserA->id,
            'initiator_type'  => get_class($this->studentUserA),
            'expected_amount' => '5000',
            'payment_type'    => 1,
            'created_at'      => now()->toIso8601String(),
        ], now()->addMinutes(30));

        $mockService = Mockery::mock(BkashService::class);
        // Gateway execution returns completed transaction
        $mockService->shouldReceive('executePayment')
            ->once()
            ->with($paymentID)
            ->andReturn([
                'paymentID'         => $paymentID,
                'trxID'             => $trxID,
                'transactionStatus' => 'Completed',
                'amount'            => '5000.00',
                'currency'          => 'BDT',
                'errorCode'         => '0000',
            ]);

        $this->app->instance(BkashService::class, $mockService);

        // First execution request -> 201 Created and persists transaction
        $response1 = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/bkash/callback', [
                'payment_id' => $paymentID,
            ]);

        $response1->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_duplicate', false)
            ->assertJsonPath('data.transaction.trxID', $trxID)
            ->assertJsonPath('data.transaction.paidamount', '5000.00')
            ->assertJsonPath('data.transaction.channel', 2)
            ->assertJsonPath('data.transaction.status', 1); // Pending admin approval

        $this->assertDatabaseHas('fees_transections', [
            'paymentID' => $paymentID,
            'trxID'     => $trxID,
        ]);

        // Second replayed execution request -> Idempotent 200 OK without double insertion!
        $response2 = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/bkash/callback', [
                'payment_id' => $paymentID,
            ]);

        $response2->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_duplicate', true)
            ->assertJsonPath('data.transaction.trxID', $trxID);

        // Confirm database contains exactly ONE transaction record
        $this->assertEquals(1, FeesTransections::where('paymentID', $paymentID)->count());
    }

    public function test_bkash_callback_rejects_unsuccessful_gateway_status()
    {
        $paymentID = 'BKASH_PAY_FAILED_999';

        \Illuminate\Support\Facades\Cache::put('bkash_intent_' . $paymentID, [
            'payment_id'      => $paymentID,
            'student_id'      => (int) $this->studentA->id,
            'user_id'         => (int) $this->studentUserA->id,
            'initiator_id'    => (int) $this->studentUserA->id,
            'initiator_type'  => get_class($this->studentUserA),
            'expected_amount' => '5000',
            'payment_type'    => 1,
            'created_at'      => now()->toIso8601String(),
        ], now()->addMinutes(30));

        $mockService = Mockery::mock(BkashService::class);
        $mockService->shouldReceive('executePayment')
            ->once()
            ->with($paymentID)
            ->andReturn([
                'paymentID'         => $paymentID,
                'transactionStatus' => 'Failed',
                'errorCode'         => '2023',
                'errorMessage'      => 'Insufficient balance in customer account',
            ]);

        $this->app->instance(BkashService::class, $mockService);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/bkash/callback', [
                'payment_id' => $paymentID,
            ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);

        $this->assertDatabaseMissing('fees_transections', ['paymentID' => $paymentID]);
    }

    public function test_bkash_callback_rejects_uninitiated_or_expired_payment_session()
    {
        // Calling callback with a paymentID that has no valid intent in cache
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/bkash/callback', [
                'payment_id' => 'FORGED_OR_EXPIRED_PAYMENT_999',
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Payment session not found, expired, or was not initiated by this system.',
            ]);
    }

    public function test_bkash_callback_rejects_cross_student_payment_hijacking()
    {
        $paymentID = 'BKASH_PAY_STUDENT_A_INTENT';

        // Payment intent initiated by Student A
        \Illuminate\Support\Facades\Cache::put('bkash_intent_' . $paymentID, [
            'payment_id'      => $paymentID,
            'student_id'      => (int) $this->studentA->id,
            'user_id'         => (int) $this->studentUserA->id,
            'initiator_id'    => (int) $this->studentUserA->id,
            'initiator_type'  => get_class($this->studentUserA),
            'expected_amount' => '5000',
            'payment_type'    => 1,
            'created_at'      => now()->toIso8601String(),
        ], now()->addMinutes(30));

        // Student B attempts to execute callback with Student A's paymentID
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenB)
            ->postJson('/api/v1/fees/bkash/callback', [
                'payment_id' => $paymentID,
            ]);

        // Must be rejected with 403 Forbidden!
        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Forbidden: This payment session belongs to a different student account',
            ]);

        // Student B's account must NOT receive any credit
        $this->assertDatabaseMissing('fees_transections', [
            'paymentID'  => $paymentID,
            'student_id' => $this->studentB->id,
        ]);
    }

    public function test_bkash_callback_rejects_amount_tampering_mismatch()
    {
        $paymentID = 'BKASH_PAY_AMOUNT_CHECK';

        // Payment intent initiated for 5000 BDT
        \Illuminate\Support\Facades\Cache::put('bkash_intent_' . $paymentID, [
            'payment_id'      => $paymentID,
            'student_id'      => (int) $this->studentA->id,
            'user_id'         => (int) $this->studentUserA->id,
            'initiator_id'    => (int) $this->studentUserA->id,
            'initiator_type'  => get_class($this->studentUserA),
            'expected_amount' => '5000',
            'payment_type'    => 1,
            'created_at'      => now()->toIso8601String(),
        ], now()->addMinutes(30));

        $mockService = Mockery::mock(BkashService::class);
        // Gateway returns captured amount of only 10 BDT (tampering attempt)
        $mockService->shouldReceive('executePayment')
            ->once()
            ->with($paymentID)
            ->andReturn([
                'paymentID'         => $paymentID,
                'trxID'             => 'TRX_TAMPERED_123',
                'transactionStatus' => 'Completed',
                'amount'            => '10.00',
                'currency'          => 'BDT',
                'errorCode'         => '0000',
            ]);

        $this->app->instance(BkashService::class, $mockService);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenA)
            ->postJson('/api/v1/fees/bkash/callback', [
                'payment_id' => $paymentID,
            ]);

        // Must be rejected with 422 Unprocessable Content!
        $response->assertStatus(422)
            ->assertJson(['success' => false]);

        $this->assertDatabaseMissing('fees_transections', ['paymentID' => $paymentID]);
    }

    public function test_replayed_callback_by_another_student_is_blocked_with_403()
    {
        $paymentID = 'BKASH_PAY_ALREADY_DONE';

        // Pre-existing completed transaction belonging to Student A
        FeesTransections::create([
            'student_id'  => $this->studentA->id,
            'user_id'     => $this->studentUserA->id,
            'paidamount'  => '5000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-01',
            'paidremark'  => 'Pay by Bkash',
            'channel'     => 2,
            'status'      => 1,
            'trxID'       => 'TRX_EXISTING_888',
            'paymentID'   => $paymentID,
        ]);

        // Student B tries to replay Student A's completed paymentID -> 403 Forbidden!
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentTokenB)
            ->postJson('/api/v1/fees/bkash/callback', [
                'payment_id' => $paymentID,
            ]);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Forbidden: You can only view your own payment transactions',
            ]);
    }

    public function test_admin_can_reconcile_bkash_payment_via_query_and_search()
    {
        $paymentID = 'BKASH_PAY_REC_101';
        $trxID     = 'TRX_REC_202';

        FeesTransections::create([
            'student_id'  => $this->studentA->id,
            'paidamount'  => '5000.00',
            'paymentType' => 1,
            'paiddate'    => '2026-02-01',
            'paidremark'  => 'Pay by Bkash',
            'channel'     => 2,
            'status'      => 1,
            'trxID'       => $trxID,
            'paymentID'   => $paymentID,
        ]);

        $mockService = Mockery::mock(BkashService::class);
        $mockService->shouldReceive('queryPayment')
            ->once()
            ->with($paymentID)
            ->andReturn([
                'paymentID'         => $paymentID,
                'trxID'             => $trxID,
                'transactionStatus' => 'Completed',
                'amount'            => '5000.00',
            ]);

        $mockService->shouldReceive('searchTransaction')
            ->once()
            ->with($trxID)
            ->andReturn([
                'trxID'             => $trxID,
                'transactionStatus' => 'Completed',
                'amount'            => '5000.00',
            ]);

        $this->app->instance(BkashService::class, $mockService);

        // Query by paymentID
        $queryResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/fees/bkash/query/' . $paymentID);

        $queryResponse->assertStatus(200)
            ->assertJsonPath('data.is_recorded', true)
            ->assertJsonPath('data.is_reconciled', true)
            ->assertJsonPath('data.local_record.trxID', $trxID);

        // Search by trxID
        $searchResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/fees/bkash/search/' . $trxID);

        $searchResponse->assertStatus(200)
            ->assertJsonPath('data.is_recorded', true)
            ->assertJsonPath('data.is_reconciled', true);
    }
}
