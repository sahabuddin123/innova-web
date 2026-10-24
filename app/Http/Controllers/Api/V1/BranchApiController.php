<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreBranchRequest;
use App\Http\Requests\Api\V1\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class BranchApiController
 *
 * REST API controller managing institutional branches.
 *
 * @package App\Http\Controllers\Api\V1
 */
class BranchApiController extends ApiController
{
    /**
     * Display a listing of branches with optional filtering.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Branch::query();

        if ($request->has('is_active') && $request->is_active !== null && $request->is_active !== '') {
            $query->where('IsActive', (int) $request->is_active);
        }

        if ($request->filled('btype')) {
            $query->where('btype', (int) $request->btype);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('bname', 'LIKE', $search)
                  ->orWhere('baddress', 'LIKE', $search);
            });
        }

        if ($request->boolean('all')) {
            $branches = $query->orderBy('id', 'asc')->get();
            return $this->success($branches, 'All branches retrieved successfully');
        }

        $perPage = (int) $request->input('per_page', 15);
        $branches = $query->orderBy('id', 'asc')->paginate($perPage);

        return $this->success($branches, 'Branches retrieved successfully');
    }

    /**
     * Display the specified branch.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return $this->error('Branch not found', 404);
        }

        return $this->success($branch, 'Branch retrieved successfully');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @param StoreBranchRequest $request
     * @return JsonResponse
     */
    public function store(StoreBranchRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $branch = DB::transaction(function () use ($validated) {
            return Branch::create([
                'bname'     => $validated['bname'],
                'baddress'  => $validated['baddress'],
                'startdate' => $validated['startdate'],
                'btype'     => $validated['btype'] ?? 1,
                'IsActive'  => $validated['IsActive'] ?? 1,
            ]);
        });

        return $this->success($branch, 'Branch created successfully', 201);
    }

    /**
     * Update the specified branch in storage.
     *
     * @param UpdateBranchRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateBranchRequest $request, $id): JsonResponse
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return $this->error('Branch not found', 404);
        }

        $validated = $request->validated();

        DB::transaction(function () use ($branch, $validated) {
            $branch->update($validated);
        });

        return $this->success($branch->fresh(), 'Branch updated successfully');
    }

    /**
     * Soft-delete the specified branch.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return $this->error('Branch not found', 404);
        }

        $branch->delete();

        return $this->success(null, 'Branch deleted successfully');
    }
}
