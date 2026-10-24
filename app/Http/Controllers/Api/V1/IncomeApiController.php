<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreIncomeRequest;
use App\Http\Requests\Api\V1\UpdateIncomeRequest;
use App\Models\Income;
use App\Traits\UploadAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

/**
 * Class IncomeApiController
 *
 * REST API controller managing institutional income entries.
 *
 * @package App\Http\Controllers\Api\V1
 */
class IncomeApiController extends ApiController
{
    use UploadAble;

    /**
     * Display a paginated listing of income records with optional filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Income::query()->with([
            'inCategoris:id,categoris',
            'branches:id,bname',
            'user:id,name,email',
        ]);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', (int) $request->branch_id);
        }

        if ($request->filled('categoris_id')) {
            $query->where('categoris_id', (int) $request->categoris_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('invoiceDate', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('invoiceDate', '<=', $request->end_date);
        }

        if ($request->has('is_active') && $request->is_active !== null && $request->is_active !== '') {
            $query->where('IsActive', (int) $request->is_active);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', $search)
                  ->orWhere('seller', 'LIKE', $search)
                  ->orWhere('recever', 'LIKE', $search)
                  ->orWhere('invoiceID', 'LIKE', $search)
                  ->orWhere('bookNO', 'LIKE', $search);
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $incomes = $query->orderBy('invoiceDate', 'desc')
                         ->orderBy('id', 'desc')
                         ->paginate($perPage);

        return $this->success($incomes, 'Income records retrieved successfully');
    }

    /**
     * Display the specified income record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $income = Income::with([
            'inCategoris:id,categoris',
            'branches:id,bname',
            'user:id,name,email',
        ])->find($id);

        if (!$income) {
            return $this->error('Income record not found', 404);
        }

        return $this->success($income, 'Income record retrieved successfully');
    }

    /**
     * Store a newly created income record in storage.
     *
     * @param StoreIncomeRequest $request
     * @return JsonResponse
     */
    public function store(StoreIncomeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $income = DB::transaction(function () use ($request, $validated) {
            $imagePath = null;
            if ($request->hasFile('image') && ($request->file('image') instanceof UploadedFile)) {
                $imagePath = $this->uploadOne($request->file('image'), 'income');
            }

            // Normalize amount to numeric string (removing commas)
            $rawAmount = str_replace(',', '', (string) $validated['amount']);
            $normalizedAmount = number_format((float) $rawAmount, 2, '.', '');

            $createDate = $validated['createDate'] ?? date('Y-m-d');
            $userId = $request->user() ? $request->user()->id : null;

            return Income::create([
                'user_id'      => $userId,
                'branch_id'    => $validated['branch_id'] ?? null,
                'categoris_id' => $validated['categoris_id'],
                'bookNO'       => $validated['bookNO'] ?? null,
                'invoiceID'    => $validated['invoiceID'] ?? null,
                'invoiceDate'  => $validated['invoiceDate'],
                'title'        => $validated['title'],
                'seller'       => $validated['seller'] ?? null,
                'recever'      => $validated['recever'] ?? null,
                'description'  => $validated['description'] ?? null,
                'amount'       => $normalizedAmount,
                'createDate'   => $createDate,
                'IsActive'     => $validated['IsActive'] ?? 1,
                'image'        => $imagePath,
            ]);
        });

        return $this->success(
            $income->load(['inCategoris:id,categoris', 'branches:id,bname', 'user:id,name,email']),
            'Income record created successfully',
            201
        );
    }

    /**
     * Update the specified income record in storage.
     *
     * @param UpdateIncomeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateIncomeRequest $request, $id): JsonResponse
    {
        $income = Income::find($id);

        if (!$income) {
            return $this->error('Income record not found', 404);
        }

        $validated = $request->validated();

        DB::transaction(function () use ($request, $income, $validated) {
            if ($request->hasFile('image') && ($request->file('image') instanceof UploadedFile)) {
                if ($income->image) {
                    $this->deleteOne($income->image);
                }
                $validated['image'] = $this->uploadOne($request->file('image'), 'income');
            }

            if (isset($validated['amount'])) {
                $rawAmount = str_replace(',', '', (string) $validated['amount']);
                $validated['amount'] = number_format((float) $rawAmount, 2, '.', '');
            }

            $income->update($validated);
        });

        return $this->success(
            $income->fresh()->load(['inCategoris:id,categoris', 'branches:id,bname', 'user:id,name,email']),
            'Income record updated successfully'
        );
    }

    /**
     * Soft-delete the specified income record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $income = Income::find($id);

        if (!$income) {
            return $this->error('Income record not found', 404);
        }

        $income->delete();

        return $this->success(null, 'Income record deleted successfully');
    }
}
