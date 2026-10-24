<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreExpenseRequest;
use App\Http\Requests\Api\V1\UpdateExpenseRequest;
use App\Models\Expanse;
use App\Traits\UploadAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

/**
 * Class ExpenseApiController
 *
 * REST API controller managing institutional expense entries.
 *
 * @package App\Http\Controllers\Api\V1
 */
class ExpenseApiController extends ApiController
{
    use UploadAble;

    /**
     * Display a paginated listing of expense records with optional filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Expanse::query()->with([
            'exCategoris:id,categoris',
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
                  ->orWhere('invoiceID', 'LIKE', $search);
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $expenses = $query->orderBy('invoiceDate', 'desc')
                          ->orderBy('id', 'desc')
                          ->paginate($perPage);

        return $this->success($expenses, 'Expense records retrieved successfully');
    }

    /**
     * Display the specified expense record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $expense = Expanse::with([
            'exCategoris:id,categoris',
            'branches:id,bname',
            'user:id,name,email',
        ])->find($id);

        if (!$expense) {
            return $this->error('Expense record not found', 404);
        }

        return $this->success($expense, 'Expense record retrieved successfully');
    }

    /**
     * Store a newly created expense record in storage.
     *
     * @param StoreExpenseRequest $request
     * @return JsonResponse
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $expense = DB::transaction(function () use ($request, $validated) {
            $imagePath = null;
            if ($request->hasFile('image') && ($request->file('image') instanceof UploadedFile)) {
                $imagePath = $this->uploadOne($request->file('image'), 'expanse');
            }

            // Normalize amount to numeric string (removing commas)
            $rawAmount = str_replace(',', '', (string) $validated['amount']);
            $normalizedAmount = number_format((float) $rawAmount, 2, '.', '');

            $createDate = $validated['createDate'] ?? date('Y-m-d');
            $userId = $request->user() ? $request->user()->id : null;

            return Expanse::create([
                'user_id'      => $userId,
                'branch_id'    => $validated['branch_id'] ?? null,
                'categoris_id' => $validated['categoris_id'],
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
            $expense->load(['exCategoris:id,categoris', 'branches:id,bname', 'user:id,name,email']),
            'Expense record created successfully',
            201
        );
    }

    /**
     * Update the specified expense record in storage.
     *
     * @param UpdateExpenseRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateExpenseRequest $request, $id): JsonResponse
    {
        $expense = Expanse::find($id);

        if (!$expense) {
            return $this->error('Expense record not found', 404);
        }

        $validated = $request->validated();

        DB::transaction(function () use ($request, $expense, $validated) {
            if ($request->hasFile('image') && ($request->file('image') instanceof UploadedFile)) {
                if ($expense->image) {
                    $this->deleteOne($expense->image);
                }
                $validated['image'] = $this->uploadOne($request->file('image'), 'expanse');
            }

            if (isset($validated['amount'])) {
                $rawAmount = str_replace(',', '', (string) $validated['amount']);
                $validated['amount'] = number_format((float) $rawAmount, 2, '.', '');
            }

            $expense->update($validated);
        });

        return $this->success(
            $expense->fresh()->load(['exCategoris:id,categoris', 'branches:id,bname', 'user:id,name,email']),
            'Expense record updated successfully'
        );
    }

    /**
     * Soft-delete the specified expense record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $expense = Expanse::find($id);

        if (!$expense) {
            return $this->error('Expense record not found', 404);
        }

        $expense->delete();

        return $this->success(null, 'Expense record deleted successfully');
    }
}
