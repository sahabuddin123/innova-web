<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shareholder;
use App\Models\Invesments;
use Illuminate\Http\Request;
use App\Contracts\ShareHolderContact;
use App\Http\Controllers\BaseController;
use DB;

class ShareholderController extends BaseController
{
     /**
     * @var ShareHolderContact 
     */
    protected $ShareHolderRepository;
    /**
     * CategoryController constructor.
     * @param ShareHolderContact $ShareHolderRepository 
     */
    public function __construct(ShareHolderContact $ShareHolderRepository)
    {
        $this->ShareHolderRepository = $ShareHolderRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shareHolder = Shareholder::where('deleted_at',null)->orderBy('id','desc')->get();
        $this->setPageTitle('Share Holder', 'List of all Share Holder');
        return view('admin.shareHolder.index', compact('shareHolder'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shareHolder = $this->ShareHolderRepository->list('id', 'asc');
        $this->setPageTitle('Create New Share Holder', 'Create Share Holder');
        return view('admin.shareHolder.create', compact('shareHolder'));
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
            'name'  =>  'required',
            'designation' =>  'required',
            'address' =>  'required',
            'shareType' =>  'required',
            'isActive' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $params = $request->except('_token');
        $shareHolder = $this->ShareHolderRepository->createData($params);
        if (!$shareHolder) {
            return $this->responseRedirectBack('Error occurred while creating ShareHolder.', 'error', true, true);
        }
        else{
            return $this->responseRedirect('admin.shareholder.index', 'Share Holder added successfully' ,'success',false, false);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shareholder  $shareholder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target = $this->ShareHolderRepository->findById($id);
        $investment = Invesments::where('shareholder_id', $id)->where('deleted_at', null)->get();
        $paid = Invesments::where('shareholder_id', $id)->sum('amount');
        $this->setPageTitle('Share Holder', 'View Share Holder : '.$target->name);
        return view('admin.shareHolder.show', compact('target','investment','paid'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shareholder  $shareholder
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $target = $this->ShareHolderRepository->findById($id);
        $shareholder = $this->ShareHolderRepository->list();
        $this->setPageTitle('ShareHolder', 'Edit Share Holder : '.$target->name);
        return view('admin.shareHolder.edit', compact('target', 'shareholder'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shareholder  $shareholder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required',
            'designation' =>  'required',
            'address' =>  'required',
            'shareType' =>  'required',
            'isActive' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $params = $request->except('_token');

        $shareHolder = $this->ShareHolderRepository->updateData($params);

        if (!$shareHolder) {
            return $this->responseRedirectBack('Error occurred while updating ShareHolder.', 'error', true, true);
        }
        return $this->responseRedirect('admin.shareholder.index', 'ShareHolder updated successfully' ,'success',false, false);
   
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shareholder  $shareholder
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('y-m-d h:i:s');
        $shareHolder = DB::table('shareholders')->where('id', $id)->update(['deleted_at' => $date]);
        if (!$shareHolder) {
            return $this->responseRedirectBack('Error occurred while deleting shareHolder.', 'error', true, true);
        }
        return $this->responseRedirect('admin.shareHolder.index', 'shareHolder deleted successfully' ,'success',false, false);
    }
}