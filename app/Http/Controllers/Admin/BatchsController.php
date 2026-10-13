<?php

namespace App\Http\Controllers\Admin;

use App\Models\Batchs;
use App\Models\Students;
use App\Models\Teachers;
use App\Contracts\BatchsContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Admin\SMSController;
use Illuminate\Support\Facades\DB;

class BatchsController extends BaseController
{
    /**
     * @var BatchsContract
     */
    protected $batchsRepository;
    /**
     * CategoryController constructor.
     * @param BatchsContract $categoryRepository
     */
    public function __construct(BatchsContract $batchsRepository)
    {
        $this->batchsRepository = $batchsRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batchs = Batchs::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Batchs', 'List of all batchs');
        return view('admin.batchs.index', compact('batchs'));
    }
    public function postponded()
    {
        $batchs = Batchs::where('deleted_at', null)->where('IsActive', 0)->get();

        $this->setPageTitle('Batchs', 'List of all Postponded batchs');
        return view('admin.batchs.index', compact('batchs'));
    }
    
    public function running()
    {
        $batchs = Batchs::where('deleted_at', null)->where('IsActive', 1)->get();

        $this->setPageTitle('Batchs', 'List of all Running batchs');
        return view('admin.batchs.index', compact('batchs'));
    }
    public function upcomming()
    {
        $batchs = Batchs::where('deleted_at', null)->where('IsActive', 2)->get();

        $this->setPageTitle('Batchs', 'List of all Upcomming batchs');
        return view('admin.batchs.index', compact('batchs'));
    }
    public function complete()
    {
        $batchs = Batchs::where('deleted_at', null)->where('IsActive', 3)->get();
        $this->setPageTitle('Batchs', 'List of all Complete batchs');
        return view('admin.batchs.index', compact('batchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $batchs = $this->batchsRepository->listBatchs('id', 'asc');
        $stuff = Teachers::where('deleted_at', null)->get();
        $this->setPageTitle('Create New Batchs', 'Create Batchs');
        return view('admin.batchs.create', compact('batchs','stuff'));
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
            'batchnum'      =>  'required|max:191',
            'totalseat' =>  'required'
        ]);

        $params = $request->except('_token');

        $batchs = $this->batchsRepository->createBatchs($params);

        if (!$batchs) {
            return $this->responseRedirectBack('Error occurred while creating batchs.', 'error', true, true);
        }
        return $this->responseRedirect('admin.batchs.index', 'Batchs added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batchs  $batchs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = Students::where('deleted_at', null)->where('batch_id', $id)->orderBy('id', 'desc')->paginate(15);
        $this->setPageTitle('Students', "List of $id Number batchs Students");
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batchs  $batchs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetbatchs = $this->batchsRepository->findBatchsById($id);
        $batchs = $this->batchsRepository->listBatchs();
        $stuff = Teachers::where('deleted_at', null)->get();
        $this->setPageTitle('Batchs', 'View Batchs : '.$targetbatchs->name);
        return view('admin.batchs.edit', compact('batchs', 'targetbatchs', 'stuff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batchs  $batchs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'batchnum'      =>  'required|max:191',
            'totalseat' =>  'required'
        ]);

        $params = $request->except('_token');

        $batchs = $this->batchsRepository->updateBatchs($params);

        if (!$batchs) {
            return $this->responseRedirectBack('Error occurred while updating batchs.', 'error', true, true);
        }
        return $this->responseRedirect('admin.batchs.index', 'Batchs updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batchs  $batchs
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('y-m-d h:i:s');
        $batchs = DB::table('batchs')->where('id', $id)->update(['deleted_at' => $date]);
        
        if (!$batchs) {
            return $this->responseRedirectBack('Error occurred while deleting Batchs.', 'error', true, true);
        }
        return $this->responseRedirect('admin.batchs.index', 'Batchs deleted successfully' ,'success',false, false);
    }
    

    
}
