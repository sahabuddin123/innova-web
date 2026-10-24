<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreIncomeCategoryRequest;
use App\Http\Requests\Api\V1\UpdateIncomeCategoryRequest;
use App\Models\IncomeCategoris;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class IncomeCategoryApiController
 *
 * REST API controller managing institutional income categories.
 *
 * @package App\Http\Controllers\Api\V1
 */
class IncomeCategoryApiController extends ApiController
{
    /**
     * Display a listing of income categories.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = IncomeCategoris::query()->with('branches:id,bname');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', (int) $request->branch_id);
        }

        if ($request->has('is_active') && $request->is_active !== null && $request->is_active !== '') {
            $query->where('IsActive', (int) $request->is_active);
        }

        if ($request->filled('search')) {
            $query->where('categoris', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->boolean('all')) {
            $categories = $query->orderBy('id', 'asc')->get();
            return $this->success($categories, 'All income categories retrieved successfully');
        }

        $perPage = (int) $request->input('per_page', 15);
        $categories = $query->orderBy('id', 'asc')->paginate($perPage);

        return $this->success($categories, 'Income categories retrieved successfully');
    }

    /**
     * Display the specified income category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $category = IncomeCategoris::with('branches:id,bname')->find($id);

        if (!$category) {
            return $this->error('Income category not found', 404);
        }

        return $this->success($category, 'Income category retrieved successfully');
    }

    /**
     * Store a newly created income category in storage.
     *
     * @param StoreIncomeCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreIncomeCategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $category = DB::transaction(function () use ($validated) {
            return IncomeCategoris::create([
                'categoris' => $validated['categoris'],
                'branch_id' => $validated['branch_id'] ?? null,
                'IsActive'  => $validated['IsActive'] ?? 1,
            ]);
        });

        return $this->success($category->load('branches:id,bname'), 'Income category created successfully', 201);
    }

    /**
     * Update the specified income category in storage.
     *
     * @param UpdateIncomeCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateIncomeCategoryRequest $request, $id): JsonResponse
    {
        $category = IncomeCategoris::find($id);

        if (!$category) {
            return $this->error('Income category not found', 404);
        }

        $validated = $request->validated();

        DB::transaction(function () use ($category, $validated) {
            $category->update($validated);
        });

        return $this->success($category->fresh()->load('branches:id,bname'), 'Income category updated successfully');
    }

    /**
     * Soft-delete the specified income category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $category = IncomeCategoris::find($id);

        if (!$category) {
            return $this->error('Income category not found', 404);
        }

        $category->delete();

        return $this->success(null, 'Income category deleted successfully');
    }
}
