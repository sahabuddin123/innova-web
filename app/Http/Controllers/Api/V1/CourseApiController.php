<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreCourseRequest;
use App\Http\Requests\Api\V1\UpdateCourseRequest;
use App\Models\Courses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CourseApiController
 *
 * REST API controller managing courses under /api/v1/academic/courses.
 *
 * @package App\Http\Controllers\Api\V1
 */
class CourseApiController extends ApiController
{
    /**
     * Display a listing of courses.
     * Public read access with optional filtering and pagination.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Courses::whereNull('deleted_at')->with('CourseCategory');

        if ($request->has('category_id')) {
            $query->where('category_id', (int) $request->input('category_id'));
        }

        if ($request->has('is_active')) {
            $query->where('IsActive', (int) $request->input('is_active'));
        }

        if ($request->has('featured')) {
            $query->where('featured', (int) $request->input('featured'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('shortTitle', 'like', "%{$search}%");
            });
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);
        $paginated = $query->orderBy('id', 'asc')->paginate($perPage);

        return $this->success($paginated->items(), 'Courses retrieved successfully', 200, [
            'current_page' => $paginated->currentPage(),
            'per_page'     => $paginated->perPage(),
            'total'        => $paginated->total(),
            'last_page'    => $paginated->lastPage(),
        ]);
    }

    /**
     * Display the specified course with its category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $course = Courses::whereNull('deleted_at')
            ->with('CourseCategory')
            ->find($id);

        if (!$course) {
            return $this->error('Course not found', 404);
        }

        return $this->success($course, 'Course retrieved successfully');
    }

    /**
     * Store a newly created course.
     *
     * @param StoreCourseRequest $request
     * @return JsonResponse
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
        $course = Courses::create($request->validated());

        return $this->success($course, 'Course created successfully', 201);
    }

    /**
     * Update the specified course.
     *
     * @param UpdateCourseRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCourseRequest $request, $id): JsonResponse
    {
        $course = Courses::whereNull('deleted_at')->find($id);

        if (!$course) {
            return $this->error('Course not found', 404);
        }

        $course->update($request->validated());

        return $this->success($course, 'Course updated successfully');
    }

    /**
     * Remove the specified course.
     * Prevents deletion if students are enrolled under this course.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $course = Courses::whereNull('deleted_at')->find($id);

        if (!$course) {
            return $this->error('Course not found', 404);
        }

        if (method_exists($course, 'StudentInfo') && $course->StudentInfo()->count() > 0) {
            return $this->error('Cannot delete course: enrolled students are linked to this course', 422);
        }

        $course->delete();

        return $this->success(null, 'Course deleted successfully');
    }
}
