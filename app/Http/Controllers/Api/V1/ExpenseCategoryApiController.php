<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreExpenseCategoryRequest;
use App\Http\Requests\Api\V1\UpdateExpenseCategoryRequest;
use App\Models\ExpanseCategoris;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ExpenseCategoryApiController
 *
 * REST API controller managing institutional expense categories.
 *
 * @package App\Http\Controllers\Api\V1
 */
class ExpenseCategoryApiController extends ApiController
{
    /**
     * Display a listing of expense categories.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = ExpanseCategoris::query()->with('branches:id,bname');

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
            return $this->success($categories, 'All expense categories retrieved successfully');
        }

        $perPage = (int) $request->input('per_page', 15);
        $categories = $query->orderBy('id', 'asc')->paginate($perPage);

        return $this->success($categories, 'Expense categories retrieved successfully');
    }

    /**
     * Display the specified expense category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $category = ExpanseCategoris::with('branches:id,bname')->find($id);

        if (!$category) {
            return $this->error('Expense category not found', 404);
        }

        return $this->success($category, 'Expense category retrieved successfully');
    }

    /**
     * Store a newly created expense category in storage.
     *
     * @param StoreExpenseCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreExpenseCategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $category = DB::transaction(function () use ($validated) {
            return ExpanseCategoris::create([
                'categoris' => $validated['categoris'],
                'branch_id' => $validated['branch_id'] ?? null,
                'IsActive'  => $validated['IsActive'] ?? 1,
            ]);
        });

        return $this->success($category->load('branches:id,bname'), 'Expense category created successfully', 201);
    }

    /**
     * Update the specified expense category in storage.
     *
     * @param UpdateExpenseCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateExpenseCategoryRequest $request, $id): JsonResponse
    {
        $category = ExpanseCategoris::find($id);

        if (!$category) {
            return $this->error('Expense category not found', 404);
        }

        $validated = $request->validated();

        DB::transaction(function () use ($category, $validated) {
            $category->update($validated);
        });

        return $this->success($category->fresh()->load('branches:id,bname'), 'Expense category updated successfully');
    }

    /**
     * Soft-delete the specified expense category.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $category = ExpanseCategoris::find($id);

        if (!$category) {
            return $this->error('Expense category not found', 404);
        }

        $category->delete();

        return $this->success(null, 'Expense category deleted successfully');
    }
}
