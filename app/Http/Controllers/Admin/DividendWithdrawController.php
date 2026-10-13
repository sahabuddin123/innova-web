<?php

namespace App\Http\Controllers\Admin;

use App\Models\DividendWithdraw;
use App\Models\Shareholder;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DividendWithdrawController extends BaseController
{
    public function index()
    {
        $withdraws = DividendWithdraw::orderBy('id', 'desc')->get();
        $this->setPageTitle('Dividend Withdraw', 'List of withdraw requests');
        return view('admin.withdraws.dividend.index', compact('withdraws'));
    }

    /**
     * Server-side DataTables data endpoint
     */
    public function data(Request $request)
    {
        $columns = [
            0 => 'dividend_withdraws.id',
            1 => 'shareholders.name',
            2 => 'dividend_withdraws.amount',
            3 => 'dividend_withdraws.withdraw_date',
            4 => 'dividend_withdraws.method',
            5 => 'dividend_withdraws.receiver_name',
            6 => 'dividend_withdraws.status',
            7 => 'dividend_withdraws.requested_at',
        ];

        $totalData = DividendWithdraw::count();
        $totalFiltered = $totalData;

        $limit = intval($request->input('length', 10));
        $start = intval($request->input('start', 0));
        $orderColIndex = intval($request->input('order.0.column', 0));
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColIndex] ?? 'dividend_withdraws.id';

        $query = DividendWithdraw::leftJoin('shareholders', 'dividend_withdraws.shareholder_id', '=', 'shareholders.id')
            ->select('dividend_withdraws.*', 'shareholders.name as shareholder_name');

        $search = $request->input('search.value');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('shareholders.name', 'like', "%{$search}%")
                  ->orWhere('dividend_withdraws.amount', 'like', "%{$search}%")
                  ->orWhere('dividend_withdraws.method', 'like', "%{$search}%")
                  ->orWhere('dividend_withdraws.status', 'like', "%{$search}%")
                  ->orWhere('dividend_withdraws.receiver_name', 'like', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $rows = $query->orderBy($orderColumn, $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = [];
        foreach ($rows as $w) {
            $nestedData = [];
            $nestedData[] = $w->id;
            $nestedData[] = $w->shareholder_name;
            $nestedData[] = number_format($w->amount, 2);
            $nestedData[] = $w->withdraw_date ? (is_string($w->withdraw_date) ? $w->withdraw_date : $w->withdraw_date->format('Y-m-d')) : '';
            $nestedData[] = $w->method;
            $nestedData[] = $w->receiver_name ?? '';
            $nestedData[] = ucfirst($w->status);
            $nestedData[] = $w->requested_at ? (is_string($w->requested_at) ? $w->requested_at : $w->requested_at->format('Y-m-d H:i')) : '';

            $actions = '';
            $actions .= '<a href="' . route('admin.dividend.withdraw.view', $w->id) . '" class="btn btn-sm btn-info mr-1">View</a>';
            $actions .= '<button data-id="' . $w->id . '" class="btn btn-sm btn-success btn-approve mr-1">Approve</button>';
            $actions .= '<button data-id="' . $w->id . '" class="btn btn-sm btn-warning btn-reject mr-1">Reject</button>';
            $actions .= '<a href="' . route('admin.dividend.withdraw.edit', $w->id) . '" class="btn btn-sm btn-primary mr-1">Edit</a>';
            $actions .= '<form style="display:inline" method="POST" action="' . route('admin.dividend.withdraw.delete', $w->id) . '">'
                . csrf_field() . method_field('DELETE') . '<button class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button></form>';

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

    /**
     * Return single withdraw row formatted for DataTables (array) and details
     */
    public function showJson($id)
    {
        $w = DividendWithdraw::with('shareholder')->findOrFail($id);
        $row = [];
        $row[] = $w->id;
        $row[] = $w->shareholder->name ?? '';
        $row[] = number_format($w->amount, 2);
        $row[] = $w->withdraw_date ? (is_string($w->withdraw_date) ? $w->withdraw_date : $w->withdraw_date->format('Y-m-d')) : '';
        $row[] = $w->method;
        $row[] = $w->receiver_name ?? '';
        $row[] = ucfirst($w->status);
        $row[] = $w->requested_at ? (is_string($w->requested_at) ? $w->requested_at : $w->requested_at->format('Y-m-d H:i')) : '';

        // build actions HTML same as data() so row array matches table columns
        $actions = '';
        $actions .= '<a href="' . route('admin.dividend.withdraw.view', $w->id) . '" class="btn btn-sm btn-info mr-1">View</a>';
        $actions .= '<button data-id="' . $w->id . '" class="btn btn-sm btn-success btn-approve mr-1">Approve</button>';
        $actions .= '<button data-id="' . $w->id . '" class="btn btn-sm btn-warning btn-reject mr-1">Reject</button>';
        $actions .= '<a href="' . route('admin.dividend.withdraw.edit', $w->id) . '" class="btn btn-sm btn-primary mr-1">Edit</a>';
        $actions .= '<form style="display:inline" method="POST" action="' . route('admin.dividend.withdraw.delete', $w->id) . '">' . csrf_field() . method_field('DELETE') . '<button class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button></form>';

        $row[] = $actions;

        return response()->json(['data' => $row, 'withdraw' => $w]);
    }

    public function create(Request $request, $shareholder_id = null)
    {
        $shareHolder = $shareholder_id ? Shareholder::find($shareholder_id) : null;
        $this->setPageTitle('Dividend Withdraw', 'Create withdraw request');
        if ($request->query('modal')) {
            return view('admin.withdraws.dividend._form', compact('shareHolder'));
        }
        return view('admin.withdraws.dividend.create', compact('shareHolder'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'shareholder_id' => 'required',
            'amount' => 'required|numeric',
        ]);
            $this->validate($request, [
                'withdraw_date' => 'nullable|date',
            ]);
            $this->validate($request, [
                'branch_name' => 'nullable|string|max:255'
            ]);
            $data = $request->only(['shareholder_id','amount','withdraw_date','method','receiver_name','branch_name','account_number','remarks','pay_by']);
        $data['status'] = 'pending';
        $data['requested_by'] = auth()->id() ?? null;
        $data['requested_at'] = Carbon::now();

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('withdraws', 'public');
            $data['attachment'] = $path;
        }

        $withdraw = DividendWithdraw::create($data);

        if (!$withdraw) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Error occurred while creating withdraw.'], 500);
            }
            return $this->responseRedirectBack('Error occurred while creating withdraw.', 'error', true, true);
        }

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'id' => $withdraw->id]);
        }

        return $this->responseRedirect('admin.dividend.withdraw.index', 'Withdraw request created successfully', 'success', false, false);
    }

    public function show($id)
    {
        $withdraw = DividendWithdraw::findOrFail($id);
        $this->setPageTitle('Dividend Withdraw', 'View withdraw request');
        return view('admin.withdraws.dividend.show', compact('withdraw'));
    }

    public function edit($id)
    {
        $withdraw = DividendWithdraw::findOrFail($id);
        $this->setPageTitle('Dividend Withdraw', 'Edit withdraw request');
        return view('admin.withdraws.dividend.edit', compact('withdraw'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'amount' => 'required|numeric'
        ]);

        $withdraw = DividendWithdraw::findOrFail($request->id);
        $this->validate($request, [
            'withdraw_date' => 'nullable|date',
            'branch_name' => 'nullable|string|max:255'
        ]);

        $updateData = $request->only(['amount','withdraw_date','method','receiver_name','branch_name','account_number','status','remarks','pay_by']);

        if ($request->hasFile('attachment')) {
            if ($withdraw->attachment) {
                Storage::disk('public')->delete($withdraw->attachment);
            }
            $updateData['attachment'] = $request->file('attachment')->store('withdraws','public');
        }

        $withdraw->update($updateData);

        return $this->responseRedirect('admin.dividend.withdraw.index', 'Withdraw request updated successfully', 'success', false, false);
    }

    public function destroy($id)
    {
        $withdraw = DividendWithdraw::findOrFail($id);
        $deleted = $withdraw->delete();
        if (!$deleted) {
            return $this->responseRedirectBack('Error occurred while deleting withdraw.', 'error', true, true);
        }
        return $this->responseRedirect('admin.dividend.withdraw.index', 'Withdraw deleted successfully', 'success', false, false);
    }

    public function approve(Request $request, $id)
    {
        $withdraw = DividendWithdraw::findOrFail($id);
        $withdraw->status = 'approved';
        $withdraw->processed_by = auth()->id() ?? null;
        $withdraw->processed_at = Carbon::now();
        $withdraw->processed_remarks = $request->input('remarks');
        $withdraw->save();

        if ($request->ajax()) {
            session()->flash('success', ['Withdraw approved']);
            return response()->json(['status' => 'success', 'message' => 'Withdraw approved']);
        }
        return $this->responseRedirect('admin.dividend.withdraw.index', 'Withdraw approved', 'success', false, false);
    }

    public function reject(Request $request, $id)
    {
        $withdraw = DividendWithdraw::findOrFail($id);
        $withdraw->status = 'rejected';
        $withdraw->processed_by = auth()->id() ?? null;
        $withdraw->processed_at = Carbon::now();
        $withdraw->processed_remarks = $request->input('remarks');
        $withdraw->save();

        if ($request->ajax()) {
            session()->flash('success', ['Withdraw rejected']);
            return response()->json(['status' => 'success', 'message' => 'Withdraw rejected']);
        }
        return $this->responseRedirect('admin.dividend.withdraw.index', 'Withdraw rejected', 'success', false, false);
    }
}
