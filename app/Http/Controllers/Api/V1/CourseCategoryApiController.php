<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreCourseCategoryRequest;
use App\Http\Requests\Api\V1\UpdateCourseCategoryRequest;
use App\Models\CourseCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CourseCategoryApiController
 *
 * REST API controller managing course categories under /api/v1/academic/categories.
 *
 * @package App\Http\Controllers\Api\V1
 */
class CourseCategoryApiController extends ApiController
{
    /**
     * Display a listing of course categories.
     * Public read access with optional is_active filter.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = CourseCategory::whereNull('deleted_at');

        if ($request->has('is_active')) {
            $query->where('IsActive', (int) $request->input('is_active'));
        }

        $categories = $query->orderBy('id', 'asc')->get();

        return $this->success($categories, 'Course categories retrieved successfully');
    }

    /**
     * Display the specified course category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $category = CourseCategory::whereNull('deleted_at')
            ->with(['courses' => function ($q) {
                $q->whereNull('deleted_at');
            }])
            ->find($id);

        if (!$category) {
            return $this->error('Course category not found', 404);
        }

        return $this->success($category, 'Course category retrieved successfully');
    }

    /**
     * Store a newly created course category.
     *
     * @param StoreCourseCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCourseCategoryRequest $request): JsonResponse
    {
        $category = CourseCategory::create($request->validated());

        return $this->success($category, 'Course category created successfully', 201);
    }

    /**
     * Update the specified course category.
     *
     * @param UpdateCourseCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCourseCategoryRequest $request, $id): JsonResponse
    {
        $category = CourseCategory::whereNull('deleted_at')->find($id);

        if (!$category) {
            return $this->error('Course category not found', 404);
        }

        $category->update($request->validated());

        return $this->success($category, 'Course category updated successfully');
    }

    /**
     * Remove the specified course category.
     * Prevents deletion if active courses are linked to this category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $category = CourseCategory::whereNull('deleted_at')->find($id);

        if (!$category) {
            return $this->error('Course category not found', 404);
        }

        if ($category->courses()->whereNull('deleted_at')->count() > 0) {
            return $this->error('Cannot delete course category: active courses are linked to this category', 422);
        }

        $category->delete();

        return $this->success(null, 'Course category deleted successfully');
    }
}
