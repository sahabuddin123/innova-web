<?php

namespace Tests\Feature\Api\V1;

use App\Models\Admin;
use App\Models\BankLoan;
use App\Models\DividendWithdraw;
use App\Models\Invesments;
use App\Models\InvestmentWithdraw;
use App\Models\Shareholder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Class ShareholderCapitalApiTest
 *
 * Automated regression suite for Phase 2.7.1 Shareholders & Capital Ledger APIs.
 * Validates CRUD operations, validation schemas, comma-amount sanitization,
 * running statement calculations, soft-deletes, and financial integrity safeguards.
 *
 * Runs exclusively in isolated in-memory SQLite (:memory:).
 *
 * @package Tests\Feature\Api\V1
 */
class ShareholderCapitalApiTest extends TestCase
{
    protected Admin $superAdmin;
    protected Admin $regularAdmin;
    protected User $studentUser;

    protected string $superAdminToken;
    protected string $regularAdminToken;
    protected string $studentUserToken;

    protected Shareholder $shareholder1;
    protected Shareholder $shareholder2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $connection = DB::connection();
        if ($connection->getDriverName() !== 'sqlite' || $connection->getDatabaseName() !== ':memory:') {
            $this->fail('CRITICAL SAFETY CHECK: Test is not running on an isolated SQLite database!');
        }

        $this->createTestTables();
        $this->seedTestData();
    }

    protected function resetAuthGuards(): void
    {
        app('auth')->forgetGuards();
    }

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

        Schema::create('shareholders', function ($table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('shareType')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->string('nid')->nullable();
            $table->unsignedInteger('isActive')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('invesments', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shareholder_id');
            $table->string('amount')->nullable();
            $table->string('recevedBy')->nullable();
            $table->date('recevedDate')->nullable();
            $table->text('paidremark')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('isActive')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('investment_withdraws', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shareholder_id');
            $table->string('amount')->nullable();
            $table->date('withdraw_date')->nullable();
            $table->string('method')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('requested_by')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->string('attachment')->nullable();
            $table->string('pay_by')->nullable();
            $table->text('processed_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bank_loans', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shareholder_id');
            $table->string('bank_name');
            $table->decimal('loan_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->integer('loan_term_months');
            $table->date('loan_date');
            $table->date('maturity_date');
            $table->integer('installment_count');
            $table->decimal('savings_amount', 15, 2)->default(0);
            $table->string('status')->default('active');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('dividend_withdraws', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shareholder_id');
            $table->string('amount')->nullable();
            $table->date('withdraw_date')->nullable();
            $table->string('method')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('requested_by')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->string('attachment')->nullable();
            $table->string('pay_by')->nullable();
            $table->text('processed_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    protected function seedTestData(): void
    {
        $superRole = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'admin']);

        $this->superAdmin = Admin::create([
            'name'     => 'Executive Director',
            'email'    => 'super@innova.com',
            'password' => Hash::make('secret123'),
        ]);
        $this->superAdmin->assignRole($superRole);
        $this->superAdminToken = $this->superAdmin->createToken('super-token')->plainTextToken;

        $this->regularAdmin = Admin::create([
            'name'     => 'Finance Officer',
            'email'    => 'finance@innova.com',
            'password' => Hash::make('secret123'),
        ]);
        $this->regularAdmin->assignRole($adminRole);
        $this->regularAdminToken = $this->regularAdmin->createToken('finance-token')->plainTextToken;

        $this->studentUser = User::create([
            'name'     => 'Enrolled Trainee',
            'email'    => 'student@innova.com',
            'password' => Hash::make('secret123'),
        ]);
        $this->studentUserToken = $this->studentUser->createToken('student-token')->plainTextToken;

        // Seed 2 shareholders
        $this->shareholder1 = Shareholder::create([
            'name'        => 'Engr. Sahabuddin',
            'designation' => 'Managing Director',
            'email'       => 'md@innova.com',
            'phone'       => '01711000001',
            'address'     => 'Dhaka, Bangladesh',
            'shareType'   => 1,
            'isActive'    => 1,
        ]);

        $this->shareholder2 = Shareholder::create([
            'name'        => 'Kamrul Islam',
            'designation' => 'Director',
            'email'       => 'director@innova.com',
            'phone'       => '01711000002',
            'address'     => 'Gazipur, Bangladesh',
            'shareType'   => 2,
            'isActive'    => 1,
        ]);
    }

    /**
     * Test 1: Unauthenticated requests are rejected with 401 Unauthorized.
     */
    public function test_unauthenticated_request_is_rejected_with_401(): void
    {
        $res = $this->json('GET', '/api/v1/shareholders');
        $res->assertStatus(401);

        $res2 = $this->json('GET', '/api/v1/investments');
        $res2->assertStatus(401);
    }

    /**
     * Test 2: Student/User tokens are rejected with 403 Forbidden.
     */
    public function test_student_user_token_is_rejected_with_403(): void
    {
        $this->resetAuthGuards();

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->studentUserToken)
                    ->json('GET', '/api/v1/shareholders');
        $res->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Forbidden: Admin access required',
            ]);

        $this->resetAuthGuards();

        $res2 = $this->withHeader('Authorization', 'Bearer ' . $this->studentUserToken)
                     ->json('GET', '/api/v1/investments');
        $res2->assertStatus(403)
             ->assertJson([
                 'success' => false,
                 'message' => 'Forbidden: Admin access required',
             ]);
    }

    /**
     * Test 3: Admin can list shareholders with financial metrics.
     */
    public function test_admin_can_list_shareholders_with_financial_summaries(): void
    {
        $this->resetAuthGuards();

        // Seed investments for shareholder 1
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100000.00',
            'recevedBy'      => 'Finance Desk',
            'recevedDate'    => '2026-01-15',
            'isActive'       => 1,
        ]);
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50000.00',
            'recevedBy'      => 'Finance Desk',
            'recevedDate'    => '2026-02-15',
            'isActive'       => 1,
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', '/api/v1/shareholders');

        $res->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'id', 'name', 'designation', 'email', 'phone', 'address',
                            'total_investment', 'total_withdrawn', 'outstanding_balance', 'investment_count'
                        ]
                    ]
                ]
            ]);

        $data = $res->json('data.data');
        $sh1 = collect($data)->firstWhere('id', $this->shareholder1->id);
        $this->assertEquals(150000.00, $sh1['total_investment']);
        $this->assertEquals(0.00, $sh1['total_withdrawn']);
        $this->assertEquals(150000.00, $sh1['outstanding_balance']);
        $this->assertEquals(2, $sh1['investment_count']);
    }

    /**
     * Test 4: Admin can create a shareholder with validation.
     */
    public function test_admin_can_create_shareholder_with_validation(): void
    {
        $this->resetAuthGuards();

        // Validation failure
        $badRes = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                       ->json('POST', '/api/v1/shareholders', []);
        $badRes->assertStatus(422)
               ->assertJsonValidationErrors(['name', 'designation', 'address', 'shareType', 'isActive']);

        $this->resetAuthGuards();

        // Successful creation
        $payload = [
            'name'        => 'Farhana Rahman',
            'designation' => 'Executive Director',
            'email'       => 'farhana@innova.com',
            'phone'       => '01811000003',
            'address'     => 'Gulshan, Dhaka',
            'shareType'   => 1,
            'isActive'    => 1,
            'nid'         => '19901234567890123',
        ];

        $goodRes = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                        ->json('POST', '/api/v1/shareholders', $payload);

        $goodRes->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Shareholder created successfully',
                    'data'    => [
                        'name'        => 'Farhana Rahman',
                        'designation' => 'Executive Director',
                    ]
                ]);

        $this->assertDatabaseHas('shareholders', [
            'name'  => 'Farhana Rahman',
            'email' => 'farhana@innova.com',
        ]);
    }

    /**
     * Test 5: Admin can view single shareholder details with investment history.
     */
    public function test_admin_can_view_single_shareholder_with_investments(): void
    {
        $this->resetAuthGuards();

        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '200000.00',
            'recevedBy'      => 'Director Finance',
            'recevedDate'    => '2026-03-01',
            'isActive'       => 1,
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}");

        $res->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'id'               => $this->shareholder1->id,
                    'name'             => $this->shareholder1->name,
                    'total_investment' => 200000.00,
                ]
            ])
            ->assertJsonCount(1, 'data.investments');
    }

    /**
     * Test 6: Admin can update shareholder profile.
     */
    public function test_admin_can_update_shareholder(): void
    {
        $this->resetAuthGuards();

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('PUT', "/api/v1/shareholders/{$this->shareholder2->id}", [
                        'designation' => 'Senior Vice President',
                        'phone'       => '01999888777',
                    ]);

        $res->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'id'          => $this->shareholder2->id,
                    'designation' => 'Senior Vice President',
                    'phone'       => '01999888777',
                ]
            ]);

        $this->assertDatabaseHas('shareholders', [
            'id'          => $this->shareholder2->id,
            'designation' => 'Senior Vice President',
        ]);
    }

    /**
     * Test 7: Admin can soft delete a shareholder without dependent financial records.
     */
    public function test_admin_can_soft_delete_shareholder_without_financial_records(): void
    {
        $this->resetAuthGuards();

        $emptyShareholder = Shareholder::create([
            'name'        => 'Temporary Partner',
            'designation' => 'Advisor',
            'address'     => 'Banani, Dhaka',
            'shareType'   => 3,
            'isActive'    => 1,
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('DELETE', "/api/v1/shareholders/{$emptyShareholder->id}");

        $res->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Shareholder deleted successfully',
            ]);

        $this->assertSoftDeleted('shareholders', ['id' => $emptyShareholder->id]);
    }

    /**
     * Test 8: Safeguard — Cannot delete shareholder with active investments.
     */
    public function test_cannot_delete_shareholder_with_active_investments(): void
    {
        $this->resetAuthGuards();

        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50000.00',
            'recevedBy'      => 'Finance',
            'recevedDate'    => '2026-01-10',
            'isActive'       => 1,
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('DELETE', "/api/v1/shareholders/{$this->shareholder1->id}");

        $res->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot delete shareholder: Active or historical capital investments are associated with this shareholder.',
            ]);

        $this->assertDatabaseHas('shareholders', [
            'id'         => $this->shareholder1->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * Test 9: Safeguard — Cannot delete shareholder with bank loans or withdrawals.
     */
    public function test_cannot_delete_shareholder_with_bank_loans_or_withdrawals(): void
    {
        $this->resetAuthGuards();

        // Attach bank loan to shareholder 2
        BankLoan::create([
            'shareholder_id'    => $this->shareholder2->id,
            'bank_name'         => 'Prime Bank Ltd',
            'loan_amount'       => 500000.00,
            'interest_rate'     => 9.5,
            'loan_term_months'  => 36,
            'loan_date'         => '2026-01-01',
            'maturity_date'     => '2029-01-01',
            'installment_count' => 36,
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('DELETE', "/api/v1/shareholders/{$this->shareholder2->id}");

        $res->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot delete shareholder: Bank loans are associated with this shareholder.',
            ]);
    }

    /**
     * Test 10: Admin can list investments with shareholder relation and filters.
     */
    public function test_admin_can_list_investments_with_filters(): void
    {
        $this->resetAuthGuards();

        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100000.00',
            'recevedBy'      => 'Desk 1',
            'recevedDate'    => '2026-01-10',
            'isActive'       => 1,
        ]);

        Invesments::create([
            'shareholder_id' => $this->shareholder2->id,
            'amount'         => '80000.00',
            'recevedBy'      => 'Desk 2',
            'recevedDate'    => '2026-02-10',
            'isActive'       => 0,
        ]);

        // Filter by shareholder_id
        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/investments?shareholder_id={$this->shareholder1->id}");

        $res->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonPath('data.data.0.shareholder_id', $this->shareholder1->id)
            ->assertJsonPath('data.data.0.numeric_amount', 100000);

        // Filter by isActive
        $resActive = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                          ->json('GET', '/api/v1/investments?isActive=1');
        $resActive->assertStatus(200)
                  ->assertJsonCount(1, 'data.data');
    }

    /**
     * Test 11: Admin can create capital investment with comma-formatted amount sanitization.
     */
    public function test_admin_can_create_investment_with_comma_sanitization(): void
    {
        $this->resetAuthGuards();

        $payload = [
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '150,000.00', // Formatted with comma
            'recevedBy'      => 'Accounts Department',
            'recevedDate'    => '2026-03-15',
            'paidremark'     => 'Initial Equity Expansion tranche',
            'isActive'       => 1,
        ];

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('POST', '/api/v1/investments', $payload);

        $res->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'shareholder_id' => $this->shareholder1->id,
                    'amount'         => '150000.00',
                    'numeric_amount' => 150000.00,
                ]
            ]);

        $this->assertDatabaseHas('invesments', [
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '150000.00',
        ]);
    }

    /**
     * Test 12: Investment validation rejects non-numeric amounts and non-existent shareholders.
     */
    public function test_investment_validation_rejects_non_numeric_and_invalid_shareholder(): void
    {
        $this->resetAuthGuards();

        $badPayload = [
            'shareholder_id' => 99999, // Non-existent
            'amount'         => 'invalid-amount',
            'recevedBy'      => 'Finance',
            'recevedDate'    => 'not-a-date',
            'isActive'       => 5, // Invalid in:0,1
        ];

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('POST', '/api/v1/investments', $badPayload);

        $res->assertStatus(422)
            ->assertJsonValidationErrors(['shareholder_id', 'amount', 'recevedDate', 'isActive']);
    }

    /**
     * Test 13: Admin can update investment record with comma sanitization.
     */
    public function test_admin_can_update_investment(): void
    {
        $this->resetAuthGuards();

        $inv = Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50000.00',
            'recevedBy'      => 'Original Officer',
            'recevedDate'    => '2026-01-01',
            'isActive'       => 1,
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('PUT', "/api/v1/investments/{$inv->id}", [
                        'amount'    => '75,500.00',
                        'recevedBy' => 'Updated Officer',
                    ]);

        $res->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'id'             => $inv->id,
                    'amount'         => '75500.00',
                    'numeric_amount' => 75500.00,
                    'recevedBy'      => 'Updated Officer',
                ]
            ]);
    }

    /**
     * Test 14: Safeguard — Cannot delete investment if shareholder balance would become negative.
     */
    public function test_cannot_delete_investment_if_outstanding_balance_becomes_negative(): void
    {
        $this->resetAuthGuards();

        // Shareholder 1 has 100,000 investment
        $inv = Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100000.00',
            'recevedBy'      => 'Desk',
            'recevedDate'    => '2026-01-01',
            'isActive'       => 1,
        ]);

        // Shareholder has 80,000 approved withdrawal
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '80000.00',
            'withdraw_date'  => '2026-02-01',
            'status'         => 'approved',
        ]);

        // Deleting this 100k investment would drop total investments to 0, leaving balance at -80k
        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('DELETE', "/api/v1/investments/{$inv->id}");

        $res->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
        $this->assertStringContainsString('would become negative', $res->json('message'));

        $this->assertDatabaseHas('invesments', [
            'id'         => $inv->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * Test 15: Admin can delete investment safely when balance remains positive.
     */
    public function test_admin_can_delete_investment_safely(): void
    {
        $this->resetAuthGuards();

        $inv1 = Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '200000.00',
            'recevedBy'      => 'Desk',
            'recevedDate'    => '2026-01-01',
            'isActive'       => 1,
        ]);

        $inv2 = Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50000.00',
            'recevedBy'      => 'Desk',
            'recevedDate'    => '2026-02-01',
            'isActive'       => 1,
        ]);

        // Delete inv2 (50k) - balance stays at 200k (positive)
        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('DELETE', "/api/v1/investments/{$inv2->id}");

        $res->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Investment record deleted successfully',
            ]);

        $this->assertSoftDeleted('invesments', ['id' => $inv2->id]);
    }

    /**
     * Test 16: Chronological Shareholder Statement calculates running balance with deterministic tie-breaker.
     */
    public function test_shareholder_statement_calculates_chronological_running_balance_with_tie_breaker(): void
    {
        $this->resetAuthGuards();

        // 1. Initial Deposit on Jan 10: 100,000
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100,000.00',
            'recevedBy'      => 'Cashier 1',
            'recevedDate'    => '2026-01-10',
            'paidremark'     => 'First Tranche',
            'isActive'       => 1,
        ]);

        // 2. Second Deposit on Feb 01: 50,000
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50,000.00',
            'recevedBy'      => 'Cashier 2',
            'recevedDate'    => '2026-02-01',
            'paidremark'     => 'Second Tranche',
            'isActive'       => 1,
        ]);

        // 3. Approved Withdrawal on Feb 01 (Same date as deposit! Tests deterministic tie-breaker): 30,000
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '30,000.00',
            'withdraw_date'  => '2026-02-01',
            'receiver_name'  => 'Sahabuddin Personal',
            'status'         => 'approved',
        ]);

        // 4. Third Deposit on March 01: 25,000
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '25,000.00',
            'recevedBy'      => 'Cashier 1',
            'recevedDate'    => '2026-03-01',
            'paidremark'     => 'Third Tranche',
            'isActive'       => 1,
        ]);

        // 5. Pending Withdrawal on March 15: 10,000 (Should NOT be included in statement!)
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '10,000.00',
            'withdraw_date'  => '2026-03-15',
            'receiver_name'  => 'Pending Request',
            'status'         => 'pending',
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'summary' => [
                        'total_investment'  => 175000.00,
                        'total_withdrawn'   => 30000.00,
                        'current_balance'   => 145000.00,
                        'transaction_count' => 4,
                    ]
                ]
            ]);

        $txns = $res->json('data.transactions');
        $this->assertCount(4, $txns);

        // Txn 1: Jan 10 deposit +100k => balance 100k
        $this->assertEquals('Deposit', $txns[0]['type']);
        $this->assertEquals('2026-01-10', $txns[0]['date']);
        $this->assertEquals(100000.00, $txns[0]['debit']);
        $this->assertEquals(100000.00, $txns[0]['balance']);

        // Txn 2: Feb 01 deposit (tie-breaker ensures deposit is credited before withdrawal on same date)
        $this->assertEquals('Deposit', $txns[1]['type']);
        $this->assertEquals('2026-02-01', $txns[1]['date']);
        $this->assertEquals(50000.00, $txns[1]['debit']);
        $this->assertEquals(150000.00, $txns[1]['balance']);

        // Txn 3: Feb 01 withdrawal -30k => balance 120k
        $this->assertEquals('Withdrawal', $txns[2]['type']);
        $this->assertEquals('2026-02-01', $txns[2]['date']);
        $this->assertEquals(30000.00, $txns[2]['credit']);
        $this->assertEquals(120000.00, $txns[2]['balance']);

        // Txn 4: March 01 deposit +25k => balance 145k
        $this->assertEquals('Deposit', $txns[3]['type']);
        $this->assertEquals('2026-03-01', $txns[3]['date']);
        $this->assertEquals(25000.00, $txns[3]['debit']);
        $this->assertEquals(145000.00, $txns[3]['balance']);
    }

    /**
     * Test 17: Super Admin has full unrestricted access.
     */
    public function test_super_admin_has_full_access(): void
    {
        $this->resetAuthGuards();

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                    ->json('GET', '/api/v1/shareholders');
        $res->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->resetAuthGuards();

        $res2 = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                     ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");
        $res2->assertStatus(200)
             ->assertJson(['success' => true]);
    }

    /**
     * Test 18: Admin cannot update investment if it would cause shareholder outstanding balance to become negative.
     */
    public function test_admin_cannot_update_investment_if_outstanding_balance_would_become_negative(): void
    {
        $this->resetAuthGuards();

        // Create an initial active investment of 50k for shareholder 2
        $inv2 = Invesments::create([
            'shareholder_id' => $this->shareholder2->id,
            'amount'         => '50,000.00',
            'recevedBy'      => 'Bank',
            'recevedDate'    => '2026-01-15',
            'isActive'       => 1,
        ]);

        // Add an approved withdrawal of 40k
        DB::table('investment_withdraws')->insert([
            'shareholder_id' => $this->shareholder2->id,
            'amount'         => '40,000.00',
            'withdraw_date'  => '2026-03-01',
            'status'         => 'approved',
        ]);

        // Attempt 1: Reduce amount to 30k (40k withdrawn > 30k remaining => negative -10k)
        $res1 = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                     ->json('PUT', "/api/v1/investments/{$inv2->id}", [
                         'amount' => 30000,
                     ]);
        $res1->assertStatus(422)
             ->assertJson([
                 'success' => false,
                 'message' => 'Cannot update investment: Shareholder outstanding balance would become negative (-10000) due to existing approved withdrawals.',
             ]);

        // Attempt 2: Deactivate investment (isActive = 0)
        $res2 = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                     ->json('PUT', "/api/v1/investments/{$inv2->id}", [
                         'isActive' => 0,
                     ]);
        $res2->assertStatus(422)
             ->assertJson([
                 'success' => false,
                 'message' => 'Cannot update investment: Shareholder outstanding balance would become negative (-40000) due to existing approved withdrawals.',
             ]);

        // Attempt 3: Transfer to another shareholder
        $res3 = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                     ->json('PUT', "/api/v1/investments/{$inv2->id}", [
                         'shareholder_id' => $this->shareholder1->id,
                     ]);
        $res3->assertStatus(422)
             ->assertJson([
                 'success' => false,
                 'message' => 'Cannot update investment: Shareholder outstanding balance would become negative (-40000) due to existing approved withdrawals.',
             ]);

        // Attempt 4: Safe update to 45k (45k - 40k = 5k >= 0)
        $res4 = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                     ->json('PUT', "/api/v1/investments/{$inv2->id}", [
                         'amount' => 45000,
                     ]);
        $res4->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'data'    => [
                     'numeric_amount' => 45000,
                 ]
             ]);
    }

    /**
     * Test 19: Statement running balance perfectly reconciles with summary aggregates.
     */
    public function test_shareholder_statement_and_summary_reconcile_identically(): void
    {
        $this->resetAuthGuards();

        // 1. First active deposit: 100k
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100,000.00',
            'recevedBy'      => 'Bank Transfer',
            'recevedDate'    => '2026-01-10',
            'isActive'       => 1,
        ]);

        // 2. Second active deposit: 50k
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50,000.00',
            'recevedBy'      => 'Cheque',
            'recevedDate'    => '2026-02-01',
            'isActive'       => 1,
        ]);

        // 3. Inactive deposit: 25k (must NOT be counted in summary or statement)
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '25,000.00',
            'recevedBy'      => 'Draft',
            'recevedDate'    => '2026-02-15',
            'isActive'       => 0,
        ]);

        // 4. Approved withdrawal: 40k
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '40,000.00',
            'withdraw_date'  => '2026-03-01',
            'receiver_name'  => 'Engr Sahabuddin',
            'status'         => 'approved',
        ]);

        // 5. Pending withdrawal: 15k (must NOT be counted in summary or statement)
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '15,000.00',
            'withdraw_date'  => '2026-03-10',
            'receiver_name'  => 'Pending Claim',
            'status'         => 'pending',
        ]);

        // Fetch statement
        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200);

        $summary = $res->json('data.summary');
        $txns = $res->json('data.transactions');

        // Only 3 eligible transactions (2 active deposits, 1 approved withdrawal)
        $this->assertCount(3, $txns);

        $computedDebit = 0.0;
        $computedCredit = 0.0;
        foreach ($txns as $t) {
            $computedDebit += (float) $t['debit'];
            $computedCredit += (float) $t['credit'];
        }

        $this->assertEquals(150000.00, $computedDebit);
        $this->assertEquals(40000.00, $computedCredit);
        $this->assertEquals(110000.00, $computedDebit - $computedCredit);

        // Summary must reconcile identically
        $this->assertEquals($summary['total_investment'], $computedDebit);
        $this->assertEquals($summary['total_withdrawn'], $computedCredit);
        $this->assertEquals($summary['current_balance'], $computedDebit - $computedCredit);
        $this->assertEquals(3, $summary['transaction_count']);

        // Final running balance of the statement must match summary current_balance exactly
        $lastTxn = end($txns);
        $this->assertEquals($summary['current_balance'], (float) $lastTxn['balance']);
    }

    /**
     * Precision Case 1: Sub-integer monetary amounts (0.10, 0.20, 0.30) without binary float distortion.
     */
    public function test_financial_precision_with_sub_integer_and_cents_amounts(): void
    {
        $this->resetAuthGuards();

        // Deposit 1: 0.10
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '0.10',
            'recevedBy'      => 'Cash',
            'recevedDate'    => '2026-04-01',
            'isActive'       => 1,
        ]);

        // Deposit 2: 0.20
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '0.20',
            'recevedBy'      => 'Cash',
            'recevedDate'    => '2026-04-02',
            'isActive'       => 1,
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200);
        $summary = $res->json('data.summary');
        $txns = $res->json('data.transactions');

        $this->assertEquals(0.30, $summary['total_investment']);
        $this->assertEquals(0.00, $summary['total_withdrawn']);
        $this->assertEquals(0.30, $summary['current_balance']);
        $this->assertEquals(0.30, $txns[1]['balance']);
    }

    /**
     * Precision Case 2: Comma-formatted fractional amounts (e.g. 100,000.25).
     */
    public function test_financial_precision_comma_formatted_fractional_amounts(): void
    {
        $this->resetAuthGuards();

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('POST', '/api/v1/investments', [
                        'shareholder_id' => $this->shareholder1->id,
                        'amount'         => '100,000.25',
                        'recevedBy'      => 'Bank Wire',
                        'recevedDate'    => '2026-04-05',
                        'isActive'       => 1,
                    ]);

        $res->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'amount'         => '100000.25',
                    'numeric_amount' => 100000.25,
                ]
            ]);

        $invId = $res->json('data.id');

        // Update with another comma-formatted fractional amount: 50,000.75
        $resUpdate = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                          ->json('PUT', "/api/v1/investments/{$invId}", [
                              'amount' => '50,000.75',
                          ]);

        $resUpdate->assertStatus(200)
                  ->assertJson([
                      'success' => true,
                      'data'    => [
                          'amount'         => '50000.75',
                          'numeric_amount' => 50000.75,
                      ]
                  ]);
    }

    /**
     * Precision Case 3: Fractional aggregation across multiple investments and approved withdrawals.
     */
    public function test_financial_precision_fractional_aggregation_totals(): void
    {
        $this->resetAuthGuards();

        // Deposit 1: 100.25
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100.25',
            'recevedBy'      => 'Wire 1',
            'recevedDate'    => '2026-04-01',
            'isActive'       => 1,
        ]);

        // Deposit 2: 200.50
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '200.50',
            'recevedBy'      => 'Wire 2',
            'recevedDate'    => '2026-04-02',
            'isActive'       => 1,
        ]);

        // Withdrawal: 150.75
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '150.75',
            'withdraw_date'  => '2026-04-03',
            'receiver_name'  => 'Sahabuddin',
            'status'         => 'approved',
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}");

        $res->assertStatus(200);
        $data = $res->json('data');

        $this->assertEquals(300.75, $data['total_investment']);
        $this->assertEquals(150.75, $data['total_withdrawn']);
        $this->assertEquals(150.00, $data['outstanding_balance']);
    }

    /**
     * Precision Case 4: Projected balance checks on updating, deactivating, reassigning, and deleting.
     */
    public function test_financial_precision_projected_balance_guards_all_operations(): void
    {
        $this->resetAuthGuards();

        $inv = Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '500.00',
            'recevedBy'      => 'Cash',
            'recevedDate'    => '2026-04-01',
            'isActive'       => 1,
        ]);

        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '450.00',
            'withdraw_date'  => '2026-04-02',
            'receiver_name'  => 'Director',
            'status'         => 'approved',
        ]);

        // Guard 1: Cannot reduce amount below 450.00 (e.g. 400.00 => -50.00)
        $resReduce = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                          ->json('PUT', "/api/v1/investments/{$inv->id}", ['amount' => 400.00]);
        $resReduce->assertStatus(422);

        // Guard 2: Cannot deactivate (isActive = 0 => 0 - 450 = -450)
        $resDeact = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                         ->json('PUT', "/api/v1/investments/{$inv->id}", ['isActive' => 0]);
        $resDeact->assertStatus(422);

        // Guard 3: Cannot reassign to shareholder 2 (shareholder 1 balance => -450)
        $resReassign = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                            ->json('PUT', "/api/v1/investments/{$inv->id}", ['shareholder_id' => $this->shareholder2->id]);
        $resReassign->assertStatus(422);

        // Guard 4: Cannot delete (shareholder 1 balance => -450)
        $resDelete = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                          ->json('DELETE', "/api/v1/investments/{$inv->id}");
        $resDelete->assertStatus(422);
    }

    /**
     * Precision Case 5: Withdrawal leaving balance at exactly 0.00 (floating point hazard boundary).
     */
    public function test_financial_precision_exact_zero_balance_boundary(): void
    {
        $this->resetAuthGuards();

        // 0.10 + 0.70 = 0.80 (In float: 0.1 + 0.7 - 0.8 < 0 evaluates to true in naive float!)
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '0.10',
            'recevedBy'      => 'Desk',
            'recevedDate'    => '2026-04-01',
            'isActive'       => 1,
        ]);
        $inv2 = Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '0.70',
            'recevedBy'      => 'Desk',
            'recevedDate'    => '2026-04-02',
            'isActive'       => 1,
        ]);

        // Approved withdrawal of exactly 0.80
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '0.80',
            'withdraw_date'  => '2026-04-03',
            'receiver_name'  => 'Exact Settlement',
            'status'         => 'approved',
        ]);

        // Verifying statement reports exact 0.00 balance
        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200);
        $summary = $res->json('data.summary');
        $this->assertEquals(0.80, $summary['total_investment']);
        $this->assertEquals(0.80, $summary['total_withdrawn']);
        $this->assertEquals(0.00, $summary['current_balance']);

        // Safe update: increasing inv2 from 0.70 to 0.75 leaves positive balance 0.05
        $resUpdate = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                          ->json('PUT', "/api/v1/investments/{$inv2->id}", ['amount' => 0.75]);
        $resUpdate->assertStatus(200);
    }

    /**
     * Precision Case 6: Balance check blocks negative balance by the smallest unit (-0.01).
     */
    public function test_financial_precision_blocks_negative_balance_by_smallest_unit(): void
    {
        $this->resetAuthGuards();

        $inv = Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100.00',
            'recevedBy'      => 'Bank',
            'recevedDate'    => '2026-04-01',
            'isActive'       => 1,
        ]);

        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100.00',
            'withdraw_date'  => '2026-04-02',
            'receiver_name'  => 'Full Withdrawal',
            'status'         => 'approved',
        ]);

        // Updating investment to 99.99 leaves balance -0.01
        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('PUT', "/api/v1/investments/{$inv->id}", ['amount' => 99.99]);

        $res->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot update investment: Shareholder outstanding balance would become negative (-0.01) due to existing approved withdrawals.',
            ]);
    }

    /**
     * Precision Case 7: Multiple same-day deposits and withdrawals with deterministic ordering.
     */
    public function test_financial_precision_same_day_multiple_deposits_and_withdrawals(): void
    {
        $this->resetAuthGuards();

        $sameDate = '2026-04-10';

        // Same-day Deposit 1: 50.00
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50.00',
            'recevedDate'    => $sameDate,
            'isActive'       => 1,
        ]);

        // Same-day Withdrawal 1: 30.00
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '30.00',
            'withdraw_date'  => $sameDate,
            'status'         => 'approved',
        ]);

        // Same-day Deposit 2: 70.00
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '70.00',
            'recevedDate'    => $sameDate,
            'isActive'       => 1,
        ]);

        // Same-day Withdrawal 2: 40.00
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '40.00',
            'withdraw_date'  => $sameDate,
            'status'         => 'approved',
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200);
        $txns = $res->json('data.transactions');
        $this->assertCount(4, $txns);

        // Deterministic ordering: All deposits must precede all withdrawals for the same date
        $this->assertEquals('Deposit', $txns[0]['type']);
        $this->assertEquals(50.00, $txns[0]['debit']);
        $this->assertEquals(50.00, $txns[0]['balance']);

        $this->assertEquals('Deposit', $txns[1]['type']);
        $this->assertEquals(70.00, $txns[1]['debit']);
        $this->assertEquals(120.00, $txns[1]['balance']);

        $this->assertEquals('Withdrawal', $txns[2]['type']);
        $this->assertEquals(30.00, $txns[2]['credit']);
        $this->assertEquals(90.00, $txns[2]['balance']);

        $this->assertEquals('Withdrawal', $txns[3]['type']);
        $this->assertEquals(40.00, $txns[3]['credit']);
        $this->assertEquals(50.00, $txns[3]['balance']);

        $this->assertEquals(50.00, $res->json('data.summary.current_balance'));
    }

    /**
     * Precision Case 8: Summary outstanding_balance matches final statement running balance across fractional values.
     */
    public function test_financial_precision_fractional_summary_and_statement_match(): void
    {
        $this->resetAuthGuards();

        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '12345.67',
            'recevedDate'    => '2026-04-01',
            'isActive'       => 1,
        ]);
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '9876.54',
            'recevedDate'    => '2026-04-02',
            'isActive'       => 1,
        ]);
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '5432.10',
            'withdraw_date'  => '2026-04-03',
            'status'         => 'approved',
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200);
        $summary = $res->json('data.summary');
        $txns = $res->json('data.transactions');

        // 12345.67 + 9876.54 = 22222.21
        // 22222.21 - 5432.10 = 16790.11
        $this->assertEquals(22222.21, $summary['total_investment']);
        $this->assertEquals(5432.10, $summary['total_withdrawn']);
        $this->assertEquals(16790.11, $summary['current_balance']);

        $lastTxn = end($txns);
        $this->assertEquals(16790.11, $lastTxn['balance']);
    }

    /**
     * Precision Case 9: Pending and rejected withdrawals remain excluded from balance.
     */
    public function test_financial_precision_pending_and_rejected_withdrawals_excluded(): void
    {
        $this->resetAuthGuards();

        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '500.00',
            'recevedDate'    => '2026-04-01',
            'isActive'       => 1,
        ]);

        // Approved: 100.00 (must be included)
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100.00',
            'withdraw_date'  => '2026-04-02',
            'status'         => 'approved',
        ]);

        // Pending: 50.00 (must be excluded)
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '50.00',
            'withdraw_date'  => '2026-04-03',
            'status'         => 'pending',
        ]);

        // Rejected: 75.00 (must be excluded)
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '75.00',
            'withdraw_date'  => '2026-04-04',
            'status'         => 'rejected',
        ]);

        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200);
        $summary = $res->json('data.summary');
        $txns = $res->json('data.transactions');

        // Only 2 transactions (deposit 500, approved withdrawal 100)
        $this->assertCount(2, $txns);
        $this->assertEquals(500.00, $summary['total_investment']);
        $this->assertEquals(100.00, $summary['total_withdrawn']);
        $this->assertEquals(400.00, $summary['current_balance']);
    }

    /**
     * Precision Case 10: Invalid, negative, zero, and malformed monetary input rejection.
     */
    public function test_financial_precision_invalid_zero_negative_and_malformed_input(): void
    {
        $this->resetAuthGuards();

        // 1. Zero amount
        $resZero = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                        ->json('POST', '/api/v1/investments', [
                            'shareholder_id' => $this->shareholder1->id,
                            'amount'         => '0.00',
                            'recevedBy'      => 'Desk',
                            'recevedDate'    => '2026-04-01',
                            'isActive'       => 1,
                        ]);
        $resZero->assertStatus(422)->assertJsonValidationErrors(['amount']);

        // 2. Negative amount
        $resNeg = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                       ->json('POST', '/api/v1/investments', [
                           'shareholder_id' => $this->shareholder1->id,
                           'amount'         => '-50.00',
                           'recevedBy'      => 'Desk',
                           'recevedDate'    => '2026-04-01',
                           'isActive'       => 1,
                       ]);
        $resNeg->assertStatus(422)->assertJsonValidationErrors(['amount']);

        // 3. Alphabetical / non-numeric amount
        $resAlpha = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                         ->json('POST', '/api/v1/investments', [
                             'shareholder_id' => $this->shareholder1->id,
                             'amount'         => 'not_a_number',
                             'recevedBy'      => 'Desk',
                             'recevedDate'    => '2026-04-01',
                             'isActive'       => 1,
                         ]);
        $resAlpha->assertStatus(422)->assertJsonValidationErrors(['amount']);

        // 4. Malformed amount
        $resMalformed = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                             ->json('POST', '/api/v1/investments', [
                                 'shareholder_id' => $this->shareholder1->id,
                                 'amount'         => '--100.50',
                                 'recevedBy'      => 'Desk',
                                 'recevedDate'    => '2026-04-01',
                                 'isActive'       => 1,
                             ]);
        $resMalformed->assertStatus(422)->assertJsonValidationErrors(['amount']);
    }

    /**
     * Test 30: Canonical string 'approved' and legacy numeric '1' are both recognized as approved withdrawals,
     * while 'pending', 'rejected', and '0' are strictly excluded.
     */
    public function test_withdrawal_status_canonical_approved_and_legacy_numeric_one_compatibility(): void
    {
        $this->resetAuthGuards();

        // 1. Deposit: 1,000.00
        Invesments::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '1000.00',
            'recevedDate'    => '2026-05-01',
            'isActive'       => 1,
        ]);

        // 2. Canonical approved withdrawal: 200.00 (status = 'approved')
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '200.00',
            'withdraw_date'  => '2026-05-02',
            'status'         => 'approved',
        ]);

        // 3. Legacy numeric approved withdrawal: 300.00 (status = '1')
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '300.00',
            'withdraw_date'  => '2026-05-03',
            'status'         => '1',
        ]);

        // 4. Pending withdrawal: 150.00 (status = 'pending') - MUST BE EXCLUDED
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '150.00',
            'withdraw_date'  => '2026-05-04',
            'status'         => 'pending',
        ]);

        // 5. Rejected withdrawal: 250.00 (status = 'rejected') - MUST BE EXCLUDED
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '250.00',
            'withdraw_date'  => '2026-05-05',
            'status'         => 'rejected',
        ]);

        // 6. Non-approved numeric withdrawal: 100.00 (status = '0') - MUST BE EXCLUDED
        InvestmentWithdraw::create([
            'shareholder_id' => $this->shareholder1->id,
            'amount'         => '100.00',
            'withdraw_date'  => '2026-05-06',
            'status'         => '0',
        ]);

        // Fetch statement
        $res = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                    ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}/statement");

        $res->assertStatus(200);
        $summary = $res->json('data.summary');
        $txns = $res->json('data.transactions');

        // Total investment: 1,000.00
        // Total withdrawn: 200.00 ('approved') + 300.00 ('1') = 500.00
        // Current balance: 1,000.00 - 500.00 = 500.00
        $this->assertEquals(1000.00, $summary['total_investment']);
        $this->assertEquals(500.00, $summary['total_withdrawn']);
        $this->assertEquals(500.00, $summary['current_balance']);
        $this->assertEquals(3, $summary['transaction_count']); // 1 deposit + 2 withdrawals

        // Fetch shareholder show endpoint
        $resShow = $this->withHeader('Authorization', 'Bearer ' . $this->regularAdminToken)
                        ->json('GET', "/api/v1/shareholders/{$this->shareholder1->id}");

        $resShow->assertStatus(200);
        $sh = $resShow->json('data');
        $this->assertEquals(1000.00, $sh['total_investment']);
        $this->assertEquals(500.00, $sh['total_withdrawn']);
        $this->assertEquals(500.00, $sh['outstanding_balance']);
    }
}
