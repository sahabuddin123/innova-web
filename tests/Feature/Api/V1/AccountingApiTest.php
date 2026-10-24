<?php

namespace Tests\Feature\Api\V1;

use App\Models\Admin;
use App\Models\Batchs;
use App\Models\Branch;
use App\Models\CourseCategory;
use App\Models\Courses;
use App\Models\Expanse;
use App\Models\ExpanseCategoris;
use App\Models\FeesTransections;
use App\Models\Income;
use App\Models\IncomeCategoris;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Class AccountingApiTest
 *
 * Feature tests for Phase 2.6 — Institutional Accounting & Reporting APIs.
 * Runs strictly against an isolated in-memory SQLite database (:memory:)
 * to guarantee zero MySQL writes or schema modifications.
 *
 * @package Tests\Feature\Api\V1
 */
class AccountingApiTest extends TestCase
{
    protected $superAdmin;
    protected $superAdminToken;

    protected $limitedAdmin;
    protected $limitedAdminToken;

    protected $expenseAdmin;
    protected $expenseAdminToken;

    protected $studentUser;
    protected $studentToken;

    protected $mainBranch;
    protected $subBranch;

    protected $incomeCategoryMain;
    protected $incomeCategorySub;

    protected $expenseCategoryMain;
    protected $expenseCategorySub;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $connection = DB::connection();
        if ($connection->getDriverName() !== 'sqlite' || $connection->getDatabaseName() !== ':memory:') {
            $this->fail('CRITICAL SAFETY CHECK: AccountingApiTest is not running on an isolated SQLite database!');
        }

        $this->createTestTables();
        $this->seedTestData();
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

        Schema::create('branches', function ($table) {
            $table->bigIncrements('id');
            $table->string('bname');
            $table->string('baddress');
            $table->date('startdate')->nullable();
            $table->unsignedInteger('btype')->default(1)->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('income_categoris', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('categoris');
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('expanse_categoris', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('categoris');
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('incomes', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('categoris_id')->nullable();
            $table->string('bookNO')->nullable();
            $table->string('invoiceID')->nullable();
            $table->date('invoiceDate');
            $table->string('title')->nullable();
            $table->string('seller')->nullable();
            $table->string('recever')->nullable();
            $table->text('description')->nullable();
            $table->string('amount');
            $table->date('createDate');
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('expanses', function ($table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('categoris_id')->nullable();
            $table->string('invoiceID')->nullable();
            $table->date('invoiceDate');
            $table->string('title')->nullable();
            $table->string('seller')->nullable();
            $table->string('recever')->nullable();
            $table->text('description')->nullable();
            $table->string('amount');
            $table->date('createDate');
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('students', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('sname');
            $table->string('phone')->nullable();
            $table->string('course_fee')->default('0');
            $table->string('balance')->default('0');
            $table->unsignedInteger('IsActive')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('fees_transections', function ($table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('paymentType');
            $table->decimal('paidamount', 10, 2);
            $table->date('paiddate');
            $table->string('paidremark');
            $table->string('trxID')->nullable();
            $table->unsignedInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function seedTestData(): void
    {
        // 1. Roles & Permissions
        $adminGuard = 'admin';
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => $adminGuard]);
        $limitedRole = Role::create(['name' => 'Limited-Staff', 'guard_name' => $adminGuard]);
        $expenseRole = Role::create(['name' => 'Expense-Manager', 'guard_name' => $adminGuard]);

        $expensePermissions = [
            'expanse-list',
            'expanse-create',
            'expanse-edit',
            'expanse-delete',
            'expanse-categoris-list',
            'expanse-categoris-create',
            'expanse-categoris-edit',
            'expanse-categoris-delete',
        ];

        foreach ($expensePermissions as $permName) {
            $perm = Permission::create(['name' => $permName, 'guard_name' => $adminGuard]);
            $expenseRole->givePermissionTo($perm);
        }

        // 2. Administrators
        $this->superAdmin = Admin::create([
            'name'     => 'Super Administrator',
            'email'    => 'super@admin.com',
            'password' => Hash::make('password123'),
        ]);
        $this->superAdmin->assignRole($superAdminRole);
        $this->superAdminToken = $this->superAdmin->createToken('super-token')->plainTextToken;

        $this->limitedAdmin = Admin::create([
            'name'     => 'Limited Staff Admin',
            'email'    => 'limited@admin.com',
            'password' => Hash::make('password123'),
        ]);
        $this->limitedAdmin->assignRole($limitedRole);
        $this->limitedAdminToken = $this->limitedAdmin->createToken('limited-token')->plainTextToken;

        $this->expenseAdmin = Admin::create([
            'name'     => 'Expense Manager Admin',
            'email'    => 'expense@admin.com',
            'password' => Hash::make('password123'),
        ]);
        $this->expenseAdmin->assignRole($expenseRole);
        $this->expenseAdminToken = $this->expenseAdmin->createToken('expense-token')->plainTextToken;

        // 3. Web User (Student)
        $this->studentUser = User::create([
            'name'     => 'Student User',
            'email'    => 'student@test.com',
            'password' => Hash::make('password123'),
        ]);
        $this->studentToken = $this->studentUser->createToken('student-token')->plainTextToken;

        // 4. Branches
        $this->mainBranch = Branch::create([
            'bname'     => 'Main Campus Branch',
            'baddress'  => '123 Computer City, Dhaka',
            'startdate' => '2020-01-01',
            'btype'     => 1,
            'IsActive'  => 1,
        ]);

        $this->subBranch = Branch::create([
            'bname'     => 'Chittagong Sub-Branch',
            'baddress'  => '456 Agrabad, Chittagong',
            'startdate' => '2021-06-01',
            'btype'     => 2,
            'IsActive'  => 1,
        ]);

        // 5. Categories
        $this->incomeCategoryMain = IncomeCategoris::create([
            'branch_id' => $this->mainBranch->id,
            'categoris' => 'Software Sales',
            'IsActive'  => 1,
        ]);

        $this->incomeCategorySub = IncomeCategoris::create([
            'branch_id' => $this->subBranch->id,
            'categoris' => 'Hardware Maintenance',
            'IsActive'  => 1,
        ]);

        $this->expenseCategoryMain = ExpanseCategoris::create([
            'branch_id' => $this->mainBranch->id,
            'categoris' => 'Office Rent',
            'IsActive'  => 1,
        ]);

        $this->expenseCategorySub = ExpanseCategoris::create([
            'branch_id' => $this->subBranch->id,
            'categoris' => 'Utility Bills',
            'IsActive'  => 1,
        ]);

        // 6. Student Fixture for Cash Reconciliation
        $student = Students::create([
            'user_id'    => $this->studentUser->id,
            'branch_id'  => $this->mainBranch->id,
            'sname'      => 'Test Student',
            'phone'      => '01711000000',
            'course_fee' => '12000.00',
            'balance'    => '7000.00',
            'IsActive'   => 1,
        ]);

        // Seed a sample fee transaction on 2026-10-24
        FeesTransections::create([
            'student_id'  => $student->id,
            'user_id'     => $this->studentUser->id,
            'paymentType' => '1',
            'paidamount'  => 5000.00,
            'paiddate'    => '2026-10-24',
            'paidremark'  => 'Admission Initial Payment',
            'trxID'       => 'TRX-FEE-1001',
            'status'      => 0,
        ]);
    }

    /**
     * Helper to clear cached Sanctum guards between consecutive authenticated requests.
     */
    protected function resetAuthGuards(): void
    {
        app('auth')->forgetGuards();
    }

    /**
     * Test 1: Unauthenticated requests are rejected with 401 across all accounting endpoints.
     */
    public function test_unauthenticated_requests_are_rejected(): void
    {
        $endpoints = [
            ['GET', '/api/v1/accounting/branches'],
            ['POST', '/api/v1/accounting/branches'],
            ['GET', '/api/v1/accounting/categories/income'],
            ['GET', '/api/v1/accounting/categories/expense'],
            ['GET', '/api/v1/accounting/incomes'],
            ['POST', '/api/v1/accounting/incomes'],
            ['GET', '/api/v1/accounting/expenses'],
            ['POST', '/api/v1/accounting/expenses'],
            ['GET', '/api/v1/accounting/reports/daily-summary'],
            ['GET', '/api/v1/accounting/reports/monthly-summary'],
        ];

        foreach ($endpoints as [$method, $uri]) {
            $response = $this->json($method, $uri);
            $response->assertStatus(401)
                     ->assertJson(['message' => 'Unauthenticated.']);
        }
    }

    /**
     * Test 2: Regular Web Users (Students) cannot access administrative accounting endpoints.
     */
    public function test_web_user_cannot_access_accounting_apis(): void
    {
        $this->resetAuthGuards();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->studentToken)
                         ->json('GET', '/api/v1/accounting/branches');

        $response->assertStatus(403)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Forbidden: Admin access required',
                 ]);
    }

    /**
     * Test 3: Existing Spatie permission enforcement on Expense and Expense Category endpoints.
     */
    public function test_permission_enforcement_for_expenses_and_categories(): void
    {
        $this->resetAuthGuards();

        // Limited Admin without expanse-* permissions gets 403 Forbidden
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->limitedAdminToken)
                         ->json('GET', '/api/v1/accounting/expenses');
        $response->assertStatus(403);

        $responseCat = $this->withHeader('Authorization', 'Bearer ' . $this->limitedAdminToken)
                            ->json('GET', '/api/v1/accounting/categories/expense');
        $responseCat->assertStatus(403);

        $this->resetAuthGuards();

        // Expense Admin with assigned permissions succeeds
        $responseAllowed = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                                ->json('GET', '/api/v1/accounting/expenses');
        $responseAllowed->assertStatus(200)
                        ->assertJson(['success' => true]);

        $responseCatAllowed = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                                   ->json('GET', '/api/v1/accounting/categories/expense');
        $responseCatAllowed->assertStatus(200)
                           ->assertJson(['success' => true]);
    }

    /**
     * Test 4: Branch CRUD operations (index, show, store, update, soft-delete).
     */
    public function test_branch_crud_operations(): void
    {
        $this->resetAuthGuards();

        // 1. List branches
        $indexRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                         ->json('GET', '/api/v1/accounting/branches');
        $indexRes->assertStatus(200)
                 ->assertJson(['success' => true]);
        $this->assertCount(2, $indexRes->json('data.data'));

        // 2. Create branch
        $storeRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                         ->json('POST', '/api/v1/accounting/branches', [
                             'bname'     => 'Sylhet New Branch',
                             'baddress'  => '789 Zindabazar, Sylhet',
                             'startdate' => '2026-10-01',
                             'btype'     => 1,
                             'IsActive'  => 1,
                         ]);
        $storeRes->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Branch created successfully',
                     'data'    => [
                         'bname' => 'Sylhet New Branch',
                     ],
                 ]);
        $branchId = $storeRes->json('data.id');

        // 3. Show branch
        $showRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                        ->json('GET', "/api/v1/accounting/branches/{$branchId}");
        $showRes->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data'    => ['id' => $branchId, 'bname' => 'Sylhet New Branch'],
                ]);

        // 4. Update branch
        $updateRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                          ->json('PUT', "/api/v1/accounting/branches/{$branchId}", [
                              'bname' => 'Sylhet Digital Campus',
                          ]);
        $updateRes->assertStatus(200)
                  ->assertJson([
                      'success' => true,
                      'data'    => ['bname' => 'Sylhet Digital Campus'],
                  ]);

        // 5. Soft-delete branch
        $deleteRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                          ->json('DELETE', "/api/v1/accounting/branches/{$branchId}");
        $deleteRes->assertStatus(200)
                  ->assertJson(['success' => true, 'message' => 'Branch deleted successfully']);

        // Verify soft-deleted from index but retained in database
        $this->assertNull(Branch::find($branchId));
        $this->assertNotNull(Branch::withTrashed()->find($branchId));
    }

    /**
     * Test 5: Income and Expense category administration.
     */
    public function test_category_administration(): void
    {
        $this->resetAuthGuards();

        // 1. Create Income Category
        $incCatRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                          ->json('POST', '/api/v1/accounting/categories/income', [
                              'categoris' => 'Govt Training Grant',
                              'branch_id' => $this->mainBranch->id,
                              'IsActive'  => 1,
                          ]);
        $incCatRes->assertStatus(201)
                  ->assertJson(['success' => true, 'data' => ['categoris' => 'Govt Training Grant']]);
        $incCatId = $incCatRes->json('data.id');

        // 2. Update Income Category
        $updateIncRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                             ->json('PUT', "/api/v1/accounting/categories/income/{$incCatId}", [
                                 'categoris' => 'National Training Grant',
                             ]);
        $updateIncRes->assertStatus(200)
                     ->assertJson(['success' => true, 'data' => ['categoris' => 'National Training Grant']]);

        // 3. Create Expense Category
        $this->resetAuthGuards();
        $expCatRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                          ->json('POST', '/api/v1/accounting/categories/expense', [
                              'categoris' => 'Server & Cloud Hosting',
                              'branch_id' => $this->mainBranch->id,
                              'IsActive'  => 1,
                          ]);
        $expCatRes->assertStatus(201)
                  ->assertJson(['success' => true, 'data' => ['categoris' => 'Server & Cloud Hosting']]);
        $expCatId = $expCatRes->json('data.id');

        // 4. Soft-delete Expense Category
        $delExpRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                          ->json('DELETE', "/api/v1/accounting/categories/expense/{$expCatId}");
        $delExpRes->assertStatus(200)
                  ->assertJson(['success' => true]);

        $this->assertNull(ExpanseCategoris::find($expCatId));
        $this->assertNotNull(ExpanseCategoris::withTrashed()->find($expCatId));
    }

    /**
     * Test 6: Income validation and record persistence with amount normalization.
     */
    public function test_income_validation_and_persistence(): void
    {
        $this->resetAuthGuards();

        // 1. Validation failure: missing required fields
        $invalidRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                           ->json('POST', '/api/v1/accounting/incomes', []);
        $invalidRes->assertStatus(422)
                   ->assertJsonValidationErrors(['categoris_id', 'title', 'amount', 'invoiceDate']);

        // 2. Successful income creation with string amount containing commas
        $validRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                         ->json('POST', '/api/v1/accounting/incomes', [
                             'branch_id'    => $this->mainBranch->id,
                             'categoris_id' => $this->incomeCategoryMain->id,
                             'invoiceDate'  => '2026-10-24',
                             'title'        => 'Custom ERP Licensing Fee',
                             'seller'       => 'INNOVA Software Division',
                             'recever'      => 'ABC Technologies Ltd.',
                             'amount'       => '35,000.50',
                             'bookNO'       => 'BK-2026-01',
                             'invoiceID'    => 'INV-INC-1001',
                             'description'  => 'Commercial license delivery for Q4',
                             'IsActive'     => 1,
                         ]);

        $validRes->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Income record created successfully',
                     'data'    => [
                         'title'     => 'Custom ERP Licensing Fee',
                         'amount'    => '35000.50',
                         'bookNO'    => 'BK-2026-01',
                         'invoiceID' => 'INV-INC-1001',
                     ],
                 ]);

        $incomeId = $validRes->json('data.id');

        // 3. Retrieve detail
        $showRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                        ->json('GET', "/api/v1/accounting/incomes/{$incomeId}");
        $showRes->assertStatus(200)
                ->assertJson(['success' => true, 'data' => ['id' => $incomeId]]);

        // 4. Update income
        $updateRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                          ->json('PUT', "/api/v1/accounting/incomes/{$incomeId}", [
                              'amount' => '40000.00',
                              'seller' => 'INNOVA Enterprise Division',
                          ]);
        $updateRes->assertStatus(200)
                  ->assertJson([
                      'success' => true,
                      'data'    => [
                          'amount' => '40000.00',
                          'seller' => 'INNOVA Enterprise Division',
                      ],
                  ]);

        // 5. Soft-delete income
        $delRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                       ->json('DELETE', "/api/v1/accounting/incomes/{$incomeId}");
        $delRes->assertStatus(200);

        $this->assertNull(Income::find($incomeId));
        $this->assertNotNull(Income::withTrashed()->find($incomeId));
    }

    /**
     * Test 7: Expense validation and record persistence with amount normalization and permission check.
     */
    public function test_expense_validation_and_persistence(): void
    {
        $this->resetAuthGuards();

        // 1. Validation failure: missing required fields
        $invalidRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                           ->json('POST', '/api/v1/accounting/expenses', []);
        $invalidRes->assertStatus(422)
                   ->assertJsonValidationErrors(['categoris_id', 'title', 'amount', 'invoiceDate']);

        // 2. Successful expense creation with formatted amount
        $validRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                         ->json('POST', '/api/v1/accounting/expenses', [
                             'branch_id'    => $this->mainBranch->id,
                             'categoris_id' => $this->expenseCategoryMain->id,
                             'invoiceDate'  => '2026-10-24',
                             'title'        => 'Headquarters Monthly Rent',
                             'seller'       => 'Tower Management Corp',
                             'recever'      => 'INNOVA Accounts Dept',
                             'amount'       => '25,000.00',
                             'invoiceID'    => 'EXP-RENT-2026',
                             'description'  => 'Rent for October 2026',
                             'IsActive'     => 1,
                         ]);

        $validRes->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Expense record created successfully',
                     'data'    => [
                         'title'     => 'Headquarters Monthly Rent',
                         'amount'    => '25000.00',
                         'invoiceID' => 'EXP-RENT-2026',
                     ],
                 ]);

        $expenseId = $validRes->json('data.id');

        // 3. Update expense
        $updateRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                          ->json('PUT', "/api/v1/accounting/expenses/{$expenseId}", [
                              'amount' => '26000.00',
                          ]);
        $updateRes->assertStatus(200)
                  ->assertJson(['success' => true, 'data' => ['amount' => '26000.00']]);

        // 4. Soft-delete expense
        $delRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                       ->json('DELETE', "/api/v1/accounting/expenses/{$expenseId}");
        $delRes->assertStatus(200);

        $this->assertNull(Expanse::find($expenseId));
        $this->assertNotNull(Expanse::withTrashed()->find($expenseId));
    }

    /**
     * Test 8: Non-existent category or branch foreign keys are rejected with 422.
     */
    public function test_invalid_foreign_keys_are_rejected(): void
    {
        $this->resetAuthGuards();

        $invalidIncome = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                              ->json('POST', '/api/v1/accounting/incomes', [
                                  'branch_id'    => 999999,
                                  'categoris_id' => 999999,
                                  'title'        => 'Invalid Relation Income',
                                  'amount'       => 1000,
                                  'invoiceDate'  => '2026-10-24',
                              ]);
        $invalidIncome->assertStatus(422)
                      ->assertJsonValidationErrors(['branch_id', 'categoris_id']);

        $this->resetAuthGuards();
        $invalidExpense = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                               ->json('POST', '/api/v1/accounting/expenses', [
                                   'branch_id'    => 999999,
                                   'categoris_id' => 999999,
                                   'title'        => 'Invalid Relation Expense',
                                   'amount'       => 1000,
                                   'invoiceDate'  => '2026-10-24',
                               ]);
        $invalidExpense->assertStatus(422)
                       ->assertJsonValidationErrors(['branch_id', 'categoris_id']);
    }

    /**
     * Test 9: Filters, pagination, and search queries on income and expense listings.
     */
    public function test_filters_and_pagination(): void
    {
        $this->resetAuthGuards();

        // Seed 3 income entries
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => '2026-10-10',
            'title'        => 'Software Training Session 1',
            'amount'       => '10000.00',
            'createDate'   => '2026-10-10',
        ]);
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => '2026-10-20',
            'title'        => 'Software Training Session 2',
            'amount'       => '15000.00',
            'createDate'   => '2026-10-20',
        ]);
        Income::create([
            'branch_id'    => $this->subBranch->id,
            'categoris_id' => $this->incomeCategorySub->id,
            'invoiceDate'  => '2026-10-22',
            'title'        => 'Hardware Diagnostics',
            'amount'       => '8000.00',
            'createDate'   => '2026-10-22',
        ]);

        // Filter by branch_id
        $branchRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                          ->json('GET', '/api/v1/accounting/incomes?branch_id=' . $this->subBranch->id);
        $branchRes->assertStatus(200);
        $this->assertCount(1, $branchRes->json('data.data'));
        $this->assertEquals('Hardware Diagnostics', $branchRes->json('data.data.0.title'));

        // Filter by date range
        $dateRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                        ->json('GET', '/api/v1/accounting/incomes?start_date=2026-10-15&end_date=2026-10-21');
        $dateRes->assertStatus(200);
        $this->assertCount(1, $dateRes->json('data.data'));
        $this->assertEquals('Software Training Session 2', $dateRes->json('data.data.0.title'));

        // Search by keyword
        $searchRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                          ->json('GET', '/api/v1/accounting/incomes?search=Session 1');
        $searchRes->assertStatus(200);
        $this->assertCount(1, $searchRes->json('data.data'));
        $this->assertEquals('Software Training Session 1', $searchRes->json('data.data.0.title'));
    }

    /**
     * Test 10: Daily Cash Summary and Reconciliation Calculation.
     * Checks: total_revenue = total_income + total_fees_collected, net_cash_flow = total_revenue - total_expense.
     */
    public function test_daily_cash_summary_reconciliation(): void
    {
        $this->resetAuthGuards();

        $targetDate = '2026-10-24';

        // Add income on targetDate: 20000.00
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => $targetDate,
            'title'        => 'Enterprise Support Plan',
            'amount'       => '20,000.00',
            'createDate'   => $targetDate,
        ]);

        // Add expense on targetDate: 8000.00
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => $targetDate,
            'title'        => 'Office Refreshments & Supplies',
            'amount'       => '8,000.00',
            'createDate'   => $targetDate,
        ]);

        // Note: seedTestData already seeded 5000.00 in fees_transections on 2026-10-24!
        // Expected:
        // total_income = 20000.00
        // total_fees_collected = 5000.00
        // total_revenue = 25000.00
        // total_expense = 8000.00
        // net_cash_flow = 17000.00

        $summaryRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                           ->json('GET', "/api/v1/accounting/reports/daily-summary?date={$targetDate}&branch_id={$this->mainBranch->id}");

        $summaryRes->assertStatus(200)
                   ->assertJson([
                       'success' => true,
                       'data'    => [
                           'date'      => $targetDate,
                           'branch_id' => $this->mainBranch->id,
                           'summary'   => [
                               'total_income'         => 20000.00,
                               'total_fees_collected' => 5000.00,
                               'total_revenue'        => 25000.00,
                               'total_expense'        => 8000.00,
                               'net_cash_flow'        => 17000.00,
                           ],
                       ],
                   ]);
    }

    /**
     * Test 11: Expense and Income category-level report aggregations.
     */
    public function test_category_reports_and_aggregations(): void
    {
        $this->resetAuthGuards();

        // Seed 2 expenses in Main Category (total: 7000.00)
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => '2026-10-12',
            'title'        => 'Internet Fiber Line',
            'amount'       => '3000.00',
            'createDate'   => '2026-10-12',
        ]);
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => '2026-10-18',
            'title'        => 'Backup 4G Router',
            'amount'       => '4000.00',
            'createDate'   => '2026-10-18',
        ]);

        $reportRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                          ->json('GET', '/api/v1/accounting/reports/expense-by-category?start_date=2026-10-01&end_date=2026-10-31&branch_id=' . $this->mainBranch->id);

        $reportRes->assertStatus(200)
                  ->assertJson([
                      'success' => true,
                      'data'    => [
                          'overall_total' => 7000.00,
                      ],
                  ]);

        // Category line items details
        $detailsRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                           ->json('GET', "/api/v1/accounting/reports/category-details/expense/{$this->expenseCategoryMain->id}?year=2026&month=10");
        $detailsRes->assertStatus(200)
                   ->assertJson([
                       'success' => true,
                       'data'    => [
                           'category_id'  => $this->expenseCategoryMain->id,
                           'total_amount' => 7000.00,
                           'item_count'   => 2,
                       ],
                   ]);
    }

    /**
     * Test 12: Monthly summary report with current, previous, and cumulative calculations.
     */
    public function test_monthly_summary_report(): void
    {
        $this->resetAuthGuards();

        // Seed previous month (September 2026)
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => '2026-09-15',
            'title'        => 'September Software Service',
            'amount'       => '50000.00',
            'createDate'   => '2026-09-15',
        ]);
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => '2026-09-20',
            'title'        => 'September Office Equipment',
            'amount'       => '20000.00',
            'createDate'   => '2026-09-20',
        ]);

        // Seed current month (October 2026)
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => '2026-10-10',
            'title'        => 'October Software Service',
            'amount'       => '60000.00',
            'createDate'   => '2026-10-10',
        ]);
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => '2026-10-15',
            'title'        => 'October Office Supplies',
            'amount'       => '25000.00',
            'createDate'   => '2026-10-15',
        ]);

        $monthlyRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                           ->json('GET', '/api/v1/accounting/reports/monthly-summary?year=2026&month=10&branch_id=' . $this->mainBranch->id);

        $monthlyRes->assertStatus(200)
                   ->assertJson([
                       'success' => true,
                       'data'    => [
                           'year'           => 2026,
                           'month'          => 10,
                           'current_month'  => [
                               'income'  => 60000.00,
                               'expense' => 25000.00,
                               'net'     => 35000.00,
                           ],
                           'previous_month' => [
                               'year'    => 2026,
                               'month'   => 9,
                               'income'  => 50000.00,
                               'expense' => 20000.00,
                               'net'     => 30000.00,
                           ],
                           'cumulative_totals' => [
                               'total_incomes'  => 110000.00,
                               'total_expenses' => 45000.00,
                               'net_balance'    => 65000.00,
                           ],
                       ],
                   ]);
    }

    /**
     * Test 13: Audit — Verify Daily Cash Summary strictly isolates Approved fees (status = 0)
     * and excludes Pending (status = 1) or other unapproved statuses from realized cash flow.
     */
    public function test_daily_cash_summary_distinguishes_approved_vs_pending_and_rejected_fee_status(): void
    {
        $this->resetAuthGuards();

        $auditDate = '2026-11-15';

        // 1. Approved counter fee payment (status = 0): 7500.00
        FeesTransections::create([
            'student_id'  => 1,
            'user_id'     => $this->studentUser->id,
            'paymentType' => '1',
            'paidamount'  => 7500.00,
            'paiddate'    => $auditDate,
            'paidremark'  => 'Approved Counter Fee',
            'status'      => 0, // Authoritative: 0 = Approved
        ]);

        // 2. Pending bKash payment awaiting admin verification (status = 1): 4000.00
        FeesTransections::create([
            'student_id'  => 1,
            'user_id'     => $this->studentUser->id,
            'paymentType' => '1',
            'paidamount'  => 4000.00,
            'paiddate'    => $auditDate,
            'paidremark'  => 'Pending Online bKash Fee',
            'status'      => 1, // Authoritative: 1 = Pending
        ]);

        // 3. Rejected or invalid status transaction (status = 2): 2500.00
        FeesTransections::create([
            'student_id'  => 1,
            'user_id'     => $this->studentUser->id,
            'paymentType' => '1',
            'paidamount'  => 2500.00,
            'paiddate'    => $auditDate,
            'paidremark'  => 'Declined Counter Fee',
            'status'      => 2, // Non-approved
        ]);

        // 4. Institutional income on audit date: 10000.00
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => $auditDate,
            'title'        => 'Audit Testing Income',
            'amount'       => '10000.00',
            'createDate'   => $auditDate,
        ]);

        // 5. Institutional expense on audit date: 3500.00
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => $auditDate,
            'title'        => 'Audit Testing Expense',
            'amount'       => '3500.00',
            'createDate'   => $auditDate,
        ]);

        $summaryRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                           ->json('GET', "/api/v1/accounting/reports/daily-summary?date={$auditDate}");

        // Expected:
        // total_income = 10000.00
        // total_fees_collected = 7500.00 (ONLY status = 0, excluding 4000 pending and 2500 rejected)
        // total_revenue = 10000.00 + 7500.00 = 17500.00
        // total_expense = 3500.00
        // net_cash_flow = 17500.00 - 3500.00 = 14000.00

        $summaryRes->assertStatus(200)
                   ->assertJson([
                       'success' => true,
                       'data'    => [
                           'date'    => $auditDate,
                           'summary' => [
                               'total_income'         => 10000.00,
                               'total_fees_collected' => 7500.00,
                               'total_revenue'        => 17500.00,
                               'total_expense'        => 3500.00,
                               'net_cash_flow'        => 14000.00,
                           ],
                       ],
                   ]);

        // Assert fee_items in payload contains only the 1 approved record
        $feeItems = $summaryRes->json('data.fee_items');
        $this->assertCount(1, $feeItems);
        $this->assertEquals(0, $feeItems[0]['status']);
        $this->assertEquals(7500.00, $feeItems[0]['paidamount']);
    }

    /**
     * Test 14: Audit — Authorization Barrier on Expense Category Details.
     * Staff lacking 'expanse-list' permission cannot view expense category breakdown.
     */
    public function test_expense_category_details_authorization_barrier(): void
    {
        $this->resetAuthGuards();

        // 1. Limited Admin without expanse-list is blocked with 403 Forbidden
        $blockedRes = $this->withHeader('Authorization', 'Bearer ' . $this->limitedAdminToken)
                           ->json('GET', "/api/v1/accounting/reports/category-details/expense/{$this->expenseCategoryMain->id}?year=2026&month=10");
        $blockedRes->assertStatus(403)
                   ->assertJson([
                       'success' => false,
                       'message' => 'Forbidden: Insufficient permissions to view expense category details',
                   ]);

        $this->resetAuthGuards();

        // 2. Expense Admin with expanse-list permission succeeds with 200 OK
        $allowedRes = $this->withHeader('Authorization', 'Bearer ' . $this->expenseAdminToken)
                           ->json('GET', "/api/v1/accounting/reports/category-details/expense/{$this->expenseCategoryMain->id}?year=2026&month=10");
        $allowedRes->assertStatus(200)
                   ->assertJson(['success' => true]);

        $this->resetAuthGuards();

        // 3. Super Admin succeeds via Gate::before
        $superRes = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                         ->json('GET', "/api/v1/accounting/reports/category-details/expense/{$this->expenseCategoryMain->id}?year=2026&month=10");
        $superRes->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    /**
     * Test 15: Audit — Monthly Summary handles January (Month 1) year boundary without error.
     * When month = 1, previous month should roll back to month = 12 of prior year.
     */
    public function test_monthly_summary_handles_january_boundary_correctly(): void
    {
        $this->resetAuthGuards();

        // Seed December 2025
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => '2025-12-20',
            'title'        => 'December Prior Year Service',
            'amount'       => '45000.00',
            'createDate'   => '2025-12-20',
        ]);
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => '2025-12-25',
            'title'        => 'December Prior Year Expense',
            'amount'       => '15000.00',
            'createDate'   => '2025-12-25',
        ]);

        // Seed January 2026
        Income::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->incomeCategoryMain->id,
            'invoiceDate'  => '2026-01-15',
            'title'        => 'January New Year Service',
            'amount'       => '55000.00',
            'createDate'   => '2026-01-15',
        ]);
        Expanse::create([
            'branch_id'    => $this->mainBranch->id,
            'categoris_id' => $this->expenseCategoryMain->id,
            'invoiceDate'  => '2026-01-20',
            'title'        => 'January New Year Expense',
            'amount'       => '20000.00',
            'createDate'   => '2026-01-20',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
                         ->json('GET', '/api/v1/accounting/reports/monthly-summary?year=2026&month=1&branch_id=' . $this->mainBranch->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data'    => [
                         'year'           => 2026,
                         'month'          => 1,
                         'current_month'  => [
                             'income'  => 55000.00,
                             'expense' => 20000.00,
                             'net'     => 35000.00,
                         ],
                         'previous_month' => [
                             'year'    => 2025,
                             'month'   => 12,
                             'income'  => 45000.00,
                             'expense' => 15000.00,
                             'net'     => 30000.00,
                         ],
                     ],
                 ]);
    }
}
