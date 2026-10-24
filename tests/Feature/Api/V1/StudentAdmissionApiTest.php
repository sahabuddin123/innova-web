<?php

namespace Tests\Feature\Api\V1;

use App\Models\Admin;
use App\Models\Admission;
use App\Models\Batchs;
use App\Models\CourseCategory;
use App\Models\Courses;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Class StudentAdmissionApiTest
 *
 * Feature tests for Phase 2.4 Student Lifecycle & Admission APIs.
 * Runs strictly against an isolated in-memory SQLite database (:memory:) to guarantee zero MySQL writes.
 *
 * @package Tests\Feature\Api\V1
 */
class StudentAdmissionApiTest extends TestCase
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
     * @var Courses
     */
    protected $testCourse;

    /**
     * @var Batchs
     */
    protected $testBatch;

    /**
     * Set up isolated test environment with in-memory SQLite database.
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
            $this->fail('CRITICAL SAFETY CHECK: StudentAdmissionApiTest is not running on an isolated SQLite database!');
        }

        $this->createTestTables();
        $this->seedTestAuthAndAcademicData();
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

        Schema::create('course_categories', function ($table) {
            $table->id();
            $table->string('CourseCategoris');
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
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->string('religion');
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('phone')->nullable();
            $table->string('nid')->nullable();
            $table->string('last_school')->nullable();
            $table->string('f_name')->nullable();
            $table->string('f_phone')->nullable();
            $table->string('m_name')->nullable();
            $table->string('m_phone')->nullable();
            $table->string('g_name');
            $table->string('g_phone');
            $table->string('rel_g');
            $table->string('discount')->nullable();
            $table->string('course_fee');
            $table->string('balance')->nullable();
            $table->string('ref')->nullable();
            $table->string('image')->nullable();
            $table->date('admission_date');
            $table->unsignedInteger('IsRegister')->default(1)->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('fees_transections', function ($table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('amount');
            $table->unsignedInteger('paymentType')->default(1);
            $table->timestamps();
        });

        Schema::create('admissions', function ($table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('courseId')->nullable();
            $table->unsignedInteger('courseType')->default(0)->nullable();
            $table->unsignedInteger('isActive')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Seed initial auth and foundational academic entities.
     */
    protected function seedTestAuthAndAcademicData(): void
    {
        $this->superAdmin = Admin::create([
            'name'     => 'Super Administrator',
            'email'    => 'admin@innovacomputersbd.com',
            'password' => Hash::make('secret123'),
        ]);

        $superRole = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        $this->superAdmin->assignRole($superRole);

        $permissions = [
            'student-list', 'student-create', 'student-edit', 'student-delete',
            'course-list', 'batch-list',
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'admin']);
        }

        $this->superAdminToken = $this->superAdmin->createToken('admin-token')->plainTextToken;

        $category = CourseCategory::create(['CourseCategoris' => 'Information Technology']);
        $this->testCourse = Courses::create([
            'category_id' => $category->id,
            'name'        => 'Web Development with Laravel',
            'coursefee'   => '18000',
        ]);

        $this->testBatch = Batchs::create([
            'batchnum'  => 'WD-2026-01',
            'totalseat' => '30',
        ]);
    }

    /**
     * Clean up test tables.
     */
    protected function tearDown(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::dropIfExists('admissions');
            Schema::dropIfExists('fees_transections');
            Schema::dropIfExists('students');
            Schema::dropIfExists('batchs');
            Schema::dropIfExists('courses');
            Schema::dropIfExists('course_categories');
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

    // ==========================================
    // STUDENT TESTS
    // ==========================================

    public function test_admin_can_list_students_with_pagination()
    {
        Students::create([
            'course_id'      => $this->testCourse->id,
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Student Alpha',
            'gender'         => 'Male',
            'religion'       => 'Islam',
            'phone'          => '01711111111',
            'g_name'         => 'Guardian A',
            'g_phone'        => '01700000001',
            'rel_g'          => 'Father',
            'course_fee'     => '18000',
            'admission_date' => '2026-01-15',
            'IsActive'       => 1,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/academic/students');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Students retrieved successfully',
            ])
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'sname', 'phone', 'batch_id', 'course_id', 'IsActive', 'admission_date']
                ],
                'meta' => ['current_page', 'per_page', 'total', 'last_page']
            ]);
    }

    public function test_unauthenticated_cannot_access_students_list()
    {
        $response = $this->getJson('/api/v1/academic/students');
        $response->assertStatus(401);
    }

    public function test_student_user_token_cannot_access_administrative_students_list()
    {
        $user = User::create([
            'name'     => 'Learner One',
            'email'    => 'learner@test.com',
            'password' => Hash::make('password'),
        ]);
        $userToken = $user->createToken('user-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $userToken)
            ->getJson('/api/v1/academic/students');

        $response->assertStatus(403)
            ->assertJson(['success' => false, 'message' => 'Forbidden: Admin access required']);
    }

    public function test_admin_can_create_student_with_valid_relationships()
    {
        $payload = [
            'course_id'      => $this->testCourse->id,
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Shakib Khan',
            'gender'         => 'Male',
            'religion'       => 'Islam',
            'phone'          => '01822222222',
            'g_name'         => 'Kader Khan',
            'g_phone'        => '01800000002',
            'rel_g'          => 'Father',
            'course_fee'     => '18000',
            'discount'       => '2000',
            'balance'        => '16000',
            'admission_date' => '2026-02-01',
            'IsActive'       => 1,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/students', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Student enrolled successfully',
                'data'    => [
                    'sname'      => 'Shakib Khan',
                    'course_fee' => '18000',
                    'IsActive'   => 1,
                ],
            ]);

        $this->assertDatabaseHas('students', ['sname' => 'Shakib Khan', 'phone' => '01822222222']);
    }

    public function test_student_creation_fails_with_invalid_course_or_batch_id()
    {
        $payload = [
            'course_id'      => 99999, // non-existent
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Invalid Student',
            'gender'         => 'Female',
            'religion'       => 'Hindu',
            'g_name'         => 'Guardian',
            'g_phone'        => '01900000000',
            'rel_g'          => 'Mother',
            'course_fee'     => '10000',
            'admission_date' => '2026-02-01',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/students', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['course_id']]);
    }

    public function test_student_multistate_is_active_preserves_values_one_through_five()
    {
        foreach ([1 => 'Active', 2 => 'Irregular', 3 => 'Complete', 4 => 'Restricted', 5 => 'Postponed'] as $status => $label) {
            $student = Students::create([
                'course_id'      => $this->testCourse->id,
                'batch_id'       => $this->testBatch->id,
                'sname'          => "Student Status $label",
                'gender'         => 'Other',
                'religion'       => 'Other',
                'g_name'         => 'Guardian',
                'g_phone'        => '01900000000',
                'rel_g'          => 'Brother',
                'course_fee'     => '15000',
                'admission_date' => '2026-01-01',
                'IsActive'       => $status,
            ]);

            $this->assertEquals($status, $student->IsActive);
        }

        // Invalid status value (e.g. 99) must be rejected with 422
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/students', [
                'course_id'      => $this->testCourse->id,
                'batch_id'       => $this->testBatch->id,
                'sname'          => 'Invalid Status Student',
                'gender'         => 'Male',
                'religion'       => 'Islam',
                'g_name'         => 'Guardian',
                'g_phone'        => '01900000000',
                'rel_g'          => 'Father',
                'course_fee'     => '15000',
                'admission_date' => '2026-01-01',
                'IsActive'       => 99,
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['IsActive']]);
    }

    public function test_student_user_can_view_own_record_but_not_another_students_record()
    {
        // Student A User and Record
        $userA = User::create(['name' => 'Student A', 'email' => 'a@test.com', 'password' => Hash::make('secret')]);
        $studentA = Students::create([
            'user_id'        => $userA->id,
            'course_id'      => $this->testCourse->id,
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Student A',
            'gender'         => 'Male',
            'religion'       => 'Islam',
            'g_name'         => 'Guardian A',
            'g_phone'        => '01700000001',
            'rel_g'          => 'Father',
            'course_fee'     => '18000',
            'admission_date' => '2026-01-01',
        ]);
        $tokenA = $userA->createToken('token-a')->plainTextToken;

        // Student B User and Record
        $userB = User::create(['name' => 'Student B', 'email' => 'b@test.com', 'password' => Hash::make('secret')]);
        $studentB = Students::create([
            'user_id'        => $userB->id,
            'course_id'      => $this->testCourse->id,
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Student B',
            'gender'         => 'Female',
            'religion'       => 'Islam',
            'g_name'         => 'Guardian B',
            'g_phone'        => '01700000002',
            'rel_g'          => 'Mother',
            'course_fee'     => '18000',
            'admission_date' => '2026-01-01',
        ]);

        // 1. Student A accessing their own record via /students/{id} -> 200 OK
        $ownResponse = $this->withHeader('Authorization', 'Bearer ' . $tokenA)
            ->getJson('/api/v1/academic/students/' . $studentA->id);
        $ownResponse->assertStatus(200)
            ->assertJsonPath('data.sname', 'Student A');

        // 2. Student A accessing their own record via /students/me -> 200 OK
        $meResponse = $this->withHeader('Authorization', 'Bearer ' . $tokenA)
            ->getJson('/api/v1/academic/students/me');
        $meResponse->assertStatus(200)
            ->assertJsonPath('data.sname', 'Student A');

        // 3. Student A attempting to access Student B's record via ID tampering -> 403 Forbidden
        $tamperResponse = $this->withHeader('Authorization', 'Bearer ' . $tokenA)
            ->getJson('/api/v1/academic/students/' . $studentB->id);
        $tamperResponse->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Forbidden: You can only access your own student record',
            ]);
    }

    public function test_cannot_delete_student_with_payment_records()
    {
        $student = Students::create([
            'course_id'      => $this->testCourse->id,
            'batch_id'       => $this->testBatch->id,
            'sname'          => 'Paid Student',
            'gender'         => 'Male',
            'religion'       => 'Islam',
            'g_name'         => 'Guardian',
            'g_phone'        => '01700000000',
            'rel_g'          => 'Father',
            'course_fee'     => '18000',
            'admission_date' => '2026-01-01',
        ]);

        DB::table('fees_transections')->insert([
            'student_id'  => $student->id,
            'amount'      => '5000',
            'paymentType' => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->deleteJson('/api/v1/academic/students/' . $student->id);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot delete student: payment records exist for this student. Deactivate student status instead.',
            ]);
    }

    // ==========================================
    // ADMISSION TESTS
    // ==========================================

    public function test_public_can_submit_online_admission_inquiry()
    {
        $payload = [
            'username'   => 'Prospective Learner',
            'phone'      => '01911223344',
            'email'      => 'learner@example.com',
            'courseId'   => $this->testCourse->id,
            'courseType' => 1,
        ];

        $response = $this->postJson('/api/v1/academic/admissions', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Admission inquiry submitted successfully',
                'data'    => [
                    'username' => 'Prospective Learner',
                    'phone'    => '01911223344',
                    'isActive' => 0, // Pending/New
                ],
            ]);

        $this->assertDatabaseHas('admissions', ['phone' => '01911223344', 'isActive' => 0]);
    }

    public function test_duplicate_phone_in_admission_is_rejected_with_422()
    {
        Admission::create([
            'username'   => 'Existing Inquirer',
            'phone'      => '01999999999',
            'courseId'   => $this->testCourse->id,
            'courseType' => 1,
            'isActive'   => 0,
        ]);

        $response = $this->postJson('/api/v1/academic/admissions', [
            'username'   => 'Another Person',
            'phone'      => '01999999999', // duplicate phone
            'courseId'   => $this->testCourse->id,
            'courseType' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['phone']]);
    }

    public function test_admin_can_list_and_update_admissions()
    {
        $admission = Admission::create([
            'username'   => 'Inquirer To Review',
            'phone'      => '01511111111',
            'courseId'   => $this->testCourse->id,
            'courseType' => 1,
            'isActive'   => 0,
        ]);

        // Admin lists admissions
        $listResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/academic/admissions');

        $listResponse->assertStatus(200)
            ->assertJsonCount(1, 'data');

        // Admin updates status to approved (1)
        $updateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->putJson('/api/v1/academic/admissions/' . $admission->id, [
                'isActive' => 1,
            ]);

        $updateResponse->assertStatus(200)
            ->assertJsonPath('data.isActive', 1);

        $this->assertDatabaseHas('admissions', ['id' => $admission->id, 'isActive' => 1]);
    }
}
