<?php

namespace App\Http\Controllers\Admin;

use App\Models\BankLoan;
use App\Models\EmiInstallment;
use App\Models\Shareholder;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;

class EmiInstallmentController extends BaseController
{
   // public function __construct()
  //  {
  //      $this->middleware(['auth:admin', 'role:superadmin|admin|hr']);
  //  }

    public function index()
    {
        $installments = EmiInstallment::with(['bankLoan', 'shareholder'])
            ->orderBy('id', 'desc')->get();
        $this->setPageTitle('EMI Installments', 'List of EMI payments');
        return view('admin.emi_installment.index', compact('installments'));
    }

    /**
     * Server-side DataTables data endpoint
     */
    public function data(Request $request)
    {
        $columns = [
            0 => 'emi_installments.id',
            1 => 'shareholders.name',
            2 => 'bank_loans.bank_name',
            3 => 'emi_installments.emi_amount',
            4 => 'emi_installments.savings_amount',
            5 => 'emi_installments.payment_date',
            6 => 'emi_installments.status',
        ];

        $totalData = EmiInstallment::count();
        $totalFiltered = $totalData;

        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));
        $orderColIndex = intval($request->input('order.0.column', 0));
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColIndex] ?? 'emi_installments.id';

        $query = EmiInstallment::leftJoin('shareholders', 'emi_installments.shareholder_id', '=', 'shareholders.id')
            ->leftJoin('bank_loans', 'emi_installments.bank_loan_id', '=', 'bank_loans.id')
            ->select('emi_installments.*', 'shareholders.name as shareholder_name', 'bank_loans.bank_name');

        $search = $request->input('search.value');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('shareholders.name', 'like', "%{$search}%")
                  ->orWhere('bank_loans.bank_name', 'like', "%{$search}%")
                  ->orWhere('emi_installments.status', 'like', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $rows = $query->orderBy($orderColumn, $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = [];
        foreach ($rows as $emi) {
            $nestedData = [];
            $nestedData[] = $emi->id;
            $nestedData[] = $emi->shareholder_name;
            $nestedData[] = $emi->bank_name;
            $nestedData[] = number_format($emi->emi_amount, 2);
            $nestedData[] = number_format($emi->savings_amount, 2);
            $nestedData[] = $emi->payment_date ? (is_string($emi->payment_date) ? $emi->payment_date : $emi->payment_date->format('Y-m-d')) : '';
            $nestedData[] = ucfirst($emi->status);

            $actions = '';
            $actions .= '<a href="' . route('admin.emi.installment.view', $emi->id) . '" class="btn btn-sm btn-info">View</a> ';
            $actions .= '<a href="' . route('admin.emi.installment.edit', $emi->id) . '" class="btn btn-sm btn-primary">Edit</a> ';
            $actions .= '<a href="' . route('admin.bank.loan.emi.statement', $emi->bank_loan_id) . '" class="btn btn-sm btn-success">EMI</a> ';
            $actions .= '<a href="' . route('admin.bank.loan.savings.statement', $emi->bank_loan_id) . '" class="btn btn-sm btn-warning">Savings</a> ';
            if ($emi->status == 'pending') {
                $actions .= '<button type="button" class="btn btn-sm btn-success mark-paid-btn" data-id="' . $emi->id . '" data-toggle="modal" data-target="#markPaidModal">Mark Paid</button>';
            }
            $actions .= '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $emi->id . '" data-name="EMI #' . $emi->id . '">Delete</button>';

            $nestedData[] = $actions;
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];
        return response()->json($json_data);
    }

    public function create(Request $request)
    {
        $loans = BankLoan::with('shareholder')->orderBy('id', 'desc')->get();
        $this->setPageTitle('EMI Installment', 'Create payment record');
        return view('admin.emi_installment.create', compact('loans'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'bank_loan_id' => 'required',
            'shareholder_id' => 'required',
            'emi_amount' => 'required|numeric',
            'payment_date' => 'required|date'
        ]);

        $data = $request->only([
            'bank_loan_id', 'shareholder_id', 'emi_amount', 'savings_amount',
            'payment_date', 'payment_method', 'remarks'
        ]);
        $data['status'] = 'pending';
        $data['paid_by'] = auth()->id() ?? null;

        $installment = EmiInstallment::create($data);

        if (!$installment) {
            return $this->responseRedirectBack('Error occurred while creating installment.', 'error', true, true);
        }

        return $this->responseRedirect('admin.emi.installment.index', 'EMI installment created successfully', 'success', false, false);
    }

    public function show($id)
    {
        $emi = EmiInstallment::with('bankLoan', 'shareholder', 'receivedByUser')->findOrFail($id);
        $this->setPageTitle('EMI Installment', 'View payment details');
        return view('admin.emi_installment.show', compact('emi'));
    }

    public function edit($id)
    {
        $emi = EmiInstallment::with('bankLoan', 'shareholder', 'receivedByUser')->findOrFail($id);
        $this->setPageTitle('EMI Installment', 'Edit payment');
        return view('admin.emi_installment.edit', compact('emi'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'emi_amount' => 'required|numeric'
        ]);

        $emi = EmiInstallment::findOrFail($id);
        $updateData = $request->only([
            'emi_amount', 'savings_amount', 'payment_date', 'payment_method', 'paid_by', 'received_by', 'status', 'remarks'
        ]);

        $emi->update($updateData);

        return $this->responseRedirect('admin.emi.installment.index', 'EMI installment updated successfully', 'success', false, false);
    }

    public function destroy($id)
    {
        $installment = EmiInstallment::findOrFail($id);
        $deleted = $installment->delete();

        if (!$deleted) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error occurred while deleting installment.'], 400);
            }
            return $this->responseRedirectBack('Error occurred while deleting installment.', 'error', true, true);
        }
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'EMI installment deleted successfully']);
        }
        return $this->responseRedirect('admin.emi.installment.index', 'EMI installment deleted successfully', 'success', false, false);
    }

    /**
     * Mark EMI as paid
     */
    public function markPaid(Request $request, $id)
    {
        $this->validate($request, [
            'payment_date' => 'required|date'
        ]);

        $installment = EmiInstallment::findOrFail($id);
        $installment->status = 'paid';
        $installment->paid_at = $request->input('payment_date');
        $installment->payment_date = $request->input('payment_date');
        $installment->received_by = auth('admin')->id() ?? null;
        $installment->save();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'EMI marked as paid successfully']);
        }
        return $this->responseRedirect('admin.emi.installment.index', 'EMI marked as paid', 'success', false, false);
    }

    /**
     * EMI Statement for a specific loan
     */
    public function statement($loan_id)
    {
        $loan = BankLoan::with(['shareholder', 'emiInstallments'])->findOrFail($loan_id);
        $this->setPageTitle('EMI Statement', 'Payment schedule for ' . $loan->bank_name);

        $emis = $loan->emiInstallments()->orderBy('payment_date')->get();
        $totalEmiAmount = $emis->sum('emi_amount');
        $totalSavingsAmount = $emis->sum('savings_amount');
        $paidEmiAmount = $loan->paidInstallments()->sum('emi_amount');
        $paidSavingsAmount = $loan->paidInstallments()->sum('savings_amount');
        $pendingEmiAmount = $totalEmiAmount - $paidEmiAmount;

        return view('admin.emi_installment.statement', compact(
            'loan', 'emis', 'totalEmiAmount', 'totalSavingsAmount', 'paidEmiAmount', 
            'paidSavingsAmount', 'pendingEmiAmount'
        ));
    }
}
