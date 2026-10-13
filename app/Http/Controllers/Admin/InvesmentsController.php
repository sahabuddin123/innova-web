<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invesments;
use App\Models\Shareholder;
use Illuminate\Http\Request;
use App\Contracts\InvestmentContact;
use App\Http\Controllers\BaseController;
use DB;

class InvesmentsController extends BaseController
{
    /**
     * @var InvestmentContact 
     */
    protected $investmentRepository;
    /**
     * CategoryController constructor.
     * @param InvestmentContact $investmentRepository 
     */
    public function __construct(InvestmentContact $investmentRepository)
    {
        $this->investmentRepository = $investmentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invesments = Invesments::where('deleted_at',null)->orderBy('id','desc')->get();
        $this->setPageTitle('Investment', 'List of all Share Holder');
        return view('admin.investment.fees', compact('invesments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $investment = $this->investmentRepository->list('id', 'asc');
        $shareHolder = Shareholder::where('deleted_at',null)->where('id', $id)->first();
        $this->setPageTitle('Create New Investment', 'Make New Investment');
        return view('admin.investment.create', compact('investment','shareHolder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'shareholder_id'  =>  'required',
            'amount' =>  'required',
            'recevedBy' =>  'required',
            'recevedDate' =>  'required',
            'isActive' =>  'required'
        ]);

        $params = $request->except('_token');
        $investment = $this->investmentRepository->createData($params);
        if (!$investment) {
            return $this->responseRedirectBack('Error occurred while creating Investment.', 'error', true, true);
        }
        else{
            return $this->responseRedirect('admin.investment.index', 'Investment added successfully' ,'success',false, false);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invesments  $invesments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $investment = Invesments::find($id);
        $target = Shareholder::where('id', $investment->shareholder_id)->first();
        $investments = Invesments::where('shareholder_id', $target->id)->get();
        $paid = Invesments::where('shareholder_id', $target->id)->sum('amount');
        $this->setPageTitle('Investment', 'View Investment');
        return view('admin.investment.show', compact('target','investments','paid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invesments  $invesments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $target = $this->investmentRepository->findById($id);
        $shareHolder = Shareholder::where('id', $target->shareholder_id)->first();
        // dd($shareHolder->name);
        $this->setPageTitle('Investment', 'Edit Investment');
        return view('admin.investment.edit', compact('target','shareHolder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invesments  $invesments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'shareholder_id'  =>  'required',
            'amount' =>  'required',
            'recevedBy' =>  'required',
            'recevedDate' =>  'required',
            'isActive' =>  'required'
        ]);
       
        $params = $request->except('_token');

        $investment = $this->investmentRepository->updateData($params);

        if (!$investment) {
            return $this->responseRedirectBack('Error occurred while updating Investment.', 'error', true, true);
        }
        return $this->responseRedirect('admin.investment.index', 'Investment updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invesments  $invesments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('y-m-d h:i:s');
        $investment = Invesments::where('id', $id)->update(['deleted_at' => $date]);
        if (!$investment) {
            return $this->responseRedirectBack('Error occurred while deleting Investment.', 'error', true, true);
        }
        return $this->responseRedirect('admin.investment.index', 'Investment deleted successfully' ,'success',false, false);
    }

    /**
     * Show a single investment record detail
     */
    public function detail($id)
    {
        $investment = Invesments::findOrFail($id);
        $shareholder = Shareholder::where('id', $investment->shareholder_id)->first();
        $this->setPageTitle('Investment Detail', 'View Single Investment');
        return view('admin.investment.detail', compact('investment', 'shareholder'));
    }

    /**
     * Show investment statement (bank statement style) with deposits and withdrawals
     */
    public function statement($id)
    {
        $shareholder = Shareholder::findOrFail($id);
        $this->setPageTitle('Investment Statement', 'Deposits and Withdrawals - ' . $shareholder->name);

        // Get all investments (deposits) for this shareholder
        $deposits = Invesments::where('shareholder_id', $id)
            ->where('deleted_at', null)
            ->get()
            ->map(function ($inv) {
                return [
                    'type' => 'Deposit',
                    'date' => $inv->recevedDate,
                    'description' => 'Investment Deposit',
                    'debit' => $inv->amount,
                    'credit' => 0,
                    'id' => $inv->id,
                    'ref_type' => 'investment'
                ];
            });

        // Get all investment withdrawals for this shareholder
        $withdrawals = \App\Models\InvestmentWithdraw::where('shareholder_id', $id)
            ->where('deleted_at', null)
            ->where('status', 'approved')
            ->get()
            ->map(function ($w) {
                return [
                    'type' => 'Withdrawal',
                    'date' => $w->withdraw_date ?? $w->requested_at,
                    'description' => 'Investment Withdrawal - ' . ($w->receiver_name ?? 'N/A'),
                    'debit' => 0,
                    'credit' => $w->amount,
                    'id' => $w->id,
                    'ref_type' => 'withdraw'
                ];
            });

        // Merge and sort by date
        $transactions = collect($deposits)
            ->merge($withdrawals)
            ->sortBy('date')
            ->values();

        // Calculate running balance
        $balance = 0;
        $transactions = $transactions->map(function ($txn) use (&$balance) {
            $balance += $txn['debit'] - $txn['credit'];
            $txn['balance'] = $balance;
            return $txn;
        });

        // Calculate summary totals
        $totalInvestment = $transactions->where('type', 'Deposit')->sum('debit');
        $totalWithdrawn = $transactions->where('type', 'Withdrawal')->sum('credit');
        $currentBalance = $totalInvestment - $totalWithdrawn;

        return view('admin.investment.statement', compact('shareholder', 'transactions', 'totalInvestment', 'totalWithdrawn', 'currentBalance'));
    }
}
