<?php

namespace Tests\Feature\Api\V1;

use App\Models\Admin;
use App\Models\Batchs;
use App\Models\CourseCategory;
use App\Models\Courses;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Class AcademicApiTest
 *
 * Feature tests for Phase 2.3 Academic & Course Management APIs.
 * Runs strictly on an isolated in-memory SQLite database (:memory:) ensuring zero MySQL writes.
 *
 * @package Tests\Feature\Api\V1
 */
class AcademicApiTest extends TestCase
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
            $this->fail('CRITICAL SAFETY CHECK: AcademicApiTest is not running on an isolated SQLite in-memory database!');
        }

        $this->createTestTables();
        $this->seedTestAuth();
    }

    /**
     * Create isolated tables in SQLite memory.
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
            $table->string('icon')->nullable();
            $table->string('fontawesome')->nullable();
            $table->unsignedInteger('isFeature')->default(0)->nullable();
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
            $table->string('courseduration')->nullable();
            $table->string('lacture')->nullable();
            $table->string('totalmoduls')->nullable();
            $table->string('totalproject')->nullable();
            $table->text('description')->nullable();
            $table->text('overview')->nullable();
            $table->text('curriculum')->nullable();
            $table->text('software')->nullable();
            $table->text('trainee')->nullable();
            $table->text('jobPlacement')->nullable();
            $table->text('jobPosition')->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->unsignedInteger('featured')->default(0)->nullable();
            $table->unsignedInteger('IsCourse')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('courseFor')->nullable();
            $table->string('Instructor')->nullable();
            $table->string('Rating')->nullable();
            $table->string('TotalReview')->nullable();
            $table->string('Discount')->nullable();
            $table->unsignedBigInteger('views')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sessions', function ($table) {
            $table->id();
            $table->string('sessionName');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('batchs', function ($table) {
            $table->id();
            $table->unsignedBigInteger('stuff_id')->nullable();
            $table->string('batchnum');
            $table->string('totalseat');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->unsignedInteger('day1')->default(0)->nullable();
            $table->string('schedule1')->nullable();
            $table->unsignedInteger('day2')->default(0)->nullable();
            $table->string('schedule2')->nullable();
            $table->unsignedInteger('day3')->default(0)->nullable();
            $table->string('schedule3')->nullable();
            $table->unsignedInteger('day4')->default(0)->nullable();
            $table->string('schedule4')->nullable();
            $table->unsignedInteger('day5')->default(0)->nullable();
            $table->string('schedule5')->nullable();
            $table->unsignedInteger('day6')->default(0)->nullable();
            $table->string('schedule6')->nullable();
            $table->unsignedInteger('day7')->default(0)->nullable();
            $table->string('schedule7')->nullable();
            $table->unsignedInteger('IsActive')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('students', function ($table) {
            $table->id();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('registrations', function ($table) {
            $table->id();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->string('reg_no')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Seed initial auth admin and permissions.
     */
    protected function seedTestAuth(): void
    {
        $this->superAdmin = Admin::create([
            'name'     => 'Super Administrator',
            'email'    => 'admin@innovacomputersbd.com',
            'password' => Hash::make('secret123'),
        ]);

        $superRole = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        $this->superAdmin->assignRole($superRole);

        // Seed academic permissions
        $permissions = [
            'course-list', 'course-create', 'course-edit', 'course-delete',
            'batch-list', 'batch-create', 'batch-edit', 'batch-delete',
            'session-list', 'session-create', 'session-edit', 'session-delete',
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'admin']);
        }

        $this->superAdminToken = $this->superAdmin->createToken('super-admin-token')->plainTextToken;
    }

    /**
     * Clean up test tables.
     */
    protected function tearDown(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::dropIfExists('registrations');
            Schema::dropIfExists('students');
            Schema::dropIfExists('batchs');
            Schema::dropIfExists('sessions');
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
    // COURSE CATEGORIES TESTS
    // ==========================================

    public function test_public_can_list_course_categories()
    {
        CourseCategory::create(['CourseCategoris' => 'Web Development', 'IsActive' => 1]);
        CourseCategory::create(['CourseCategoris' => 'Graphic Design', 'IsActive' => 1]);

        $response = $this->getJson('/api/v1/academic/categories');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Course categories retrieved successfully',
            ])
            ->assertJsonCount(2, 'data');
    }

    public function test_public_can_retrieve_single_course_category()
    {
        $category = CourseCategory::create(['CourseCategoris' => 'Cyber Security', 'IsActive' => 1]);

        $response = $this->getJson('/api/v1/academic/categories/' . $category->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'id'              => $category->id,
                    'CourseCategoris' => 'Cyber Security',
                ],
            ]);
    }

    public function test_admin_can_create_course_category()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/categories', [
                'CourseCategoris' => 'Digital Marketing',
                'isFeature'       => 1,
                'IsActive'        => 1,
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Course category created successfully',
                'data'    => [
                    'CourseCategoris' => 'Digital Marketing',
                ],
            ]);

        $this->assertDatabaseHas('course_categories', ['CourseCategoris' => 'Digital Marketing']);
    }

    public function test_unauthenticated_user_cannot_create_course_category()
    {
        $response = $this->postJson('/api/v1/academic/categories', [
            'CourseCategoris' => 'Unauthorized Category',
        ]);

        $response->assertStatus(401);
    }

    public function test_student_user_token_rejected_from_creating_course_category()
    {
        $user = User::create([
            'name'     => 'Student User',
            'email'    => 'student@test.com',
            'password' => Hash::make('password'),
        ]);
        $userToken = $user->createToken('user-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $userToken)
            ->postJson('/api/v1/academic/categories', [
                'CourseCategoris' => 'Hacker Category',
            ]);

        $response->assertStatus(403)
            ->assertJson(['success' => false, 'message' => 'Forbidden: Admin access required']);
    }

    public function test_cannot_delete_category_with_active_courses()
    {
        $category = CourseCategory::create(['CourseCategoris' => 'Programming']);
        Courses::create([
            'category_id' => $category->id,
            'name'        => 'PHP & Laravel Mastery',
            'coursefee'   => '15000',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->deleteJson('/api/v1/academic/categories/' . $category->id);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot delete course category: active courses are linked to this category',
            ]);
    }

    // ==========================================
    // COURSES TESTS
    // ==========================================

    public function test_public_can_list_and_filter_courses()
    {
        $category1 = CourseCategory::create(['CourseCategoris' => 'Design']);
        $category2 = CourseCategory::create(['CourseCategoris' => 'Development']);

        Courses::create(['category_id' => $category1->id, 'name' => 'UI/UX Design', 'coursefee' => '10000', 'IsActive' => 1]);
        Courses::create(['category_id' => $category2->id, 'name' => 'Full Stack Web', 'coursefee' => '25000', 'IsActive' => 1]);

        // Filter by category_id
        $response = $this->getJson('/api/v1/academic/courses?category_id=' . $category2->id);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Full Stack Web');
    }

    public function test_admin_can_create_course_with_valid_category()
    {
        $category = CourseCategory::create(['CourseCategoris' => 'Networking']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/courses', [
                'name'        => 'CCNA Routing & Switching',
                'coursefee'   => '18000',
                'category_id' => $category->id,
                'shortTitle'  => 'CCNA',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'name'      => 'CCNA Routing & Switching',
                    'coursefee' => '18000',
                ],
            ]);
    }

    public function test_create_course_fails_with_invalid_category_id()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/courses', [
                'name'        => 'Invalid Category Course',
                'coursefee'   => '5000',
                'category_id' => 99999, // does not exist
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['category_id']]);
    }

    public function test_cannot_delete_course_with_enrolled_students()
    {
        $course = Courses::create(['name' => 'Web App Dev', 'coursefee' => '20000']);
        DB::table('students')->insert([
            'course_id'  => $course->id,
            'name'       => 'Test Enrolled Student',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->deleteJson('/api/v1/academic/courses/' . $course->id);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot delete course: enrolled students are linked to this course',
            ]);
    }

    // ==========================================
    // ACADEMIC SESSIONS TESTS
    // ==========================================

    public function test_admin_can_list_and_create_academic_sessions()
    {
        $createResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/sessions', [
                'sessionName' => 'January-June 2026',
                'startdate'   => '2026-01-01',
                'enddate'     => '2026-06-30',
                'IsActive'    => 1,
            ]);

        $createResponse->assertStatus(201)
            ->assertJsonPath('data.sessionName', 'January-June 2026');

        $listResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/academic/sessions');

        $listResponse->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_cannot_delete_session_with_linked_registrations()
    {
        $session = Session::create(['sessionName' => 'July-December 2026']);
        DB::table('registrations')->insert([
            'session_id' => $session->id,
            'reg_no'     => 'BTEB-12345',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->deleteJson('/api/v1/academic/sessions/' . $session->id);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot delete academic session: active student registrations are linked to this session',
            ]);
    }

    // ==========================================
    // BATCHES TESTS
    // ==========================================

    public function test_admin_can_list_and_create_batches()
    {
        $createResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->postJson('/api/v1/academic/batches', [
                'batchnum'  => 'WD-2026-01',
                'totalseat' => '30',
                'startdate' => '2026-02-01',
                'enddate'   => '2026-05-30',
                'IsActive'  => 1, // Running
            ]);

        $createResponse->assertStatus(201)
            ->assertJsonPath('data.batchnum', 'WD-2026-01');

        // Filter batches by status running (1)
        $listResponse = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->getJson('/api/v1/academic/batches?status=running');

        $listResponse->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_cannot_delete_batch_with_assigned_students()
    {
        $batch = Batchs::create(['batchnum' => 'GD-2026-01', 'totalseat' => '25']);
        DB::table('students')->insert([
            'batch_id'   => $batch->id,
            'name'       => 'Batch Enrolled Student',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->superAdminToken)
            ->deleteJson('/api/v1/academic/batches/' . $batch->id);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot delete batch: enrolled students are assigned to this batch',
            ]);
    }

    // ==========================================
    // PERMISSION ENFORCEMENT TEST
    // ==========================================

    public function test_admin_without_permission_receives_403()
    {
        $restrictedAdmin = Admin::create([
            'name'     => 'Restricted Officer',
            'email'    => 'officer@test.com',
            'password' => Hash::make('password123'),
        ]);
        // Do NOT assign super-admin or course-delete permission
        $token = $restrictedAdmin->createToken('restricted-token')->plainTextToken;

        $category = CourseCategory::create(['CourseCategoris' => 'Unprotected']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson('/api/v1/academic/categories/' . $category->id);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'User does not have the required permissions.',
            ]);
    }
}
