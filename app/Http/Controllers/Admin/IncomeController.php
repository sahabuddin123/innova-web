<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Income;
use App\Models\IncomeCategoris;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class IncomeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Income::where('deleted_at', null)->orderBy('id', 'asc')->with('inCategoris')->get();
        $branchs = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Income', 'List of all Income');
        return view('admin.income.index', compact('data', 'branchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Income::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $categoris = IncomeCategoris::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $branchs = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Create New Income', 'Create Income');
        return view('admin.income.create', compact('data', 'categoris', 'branchs'));
    }
    /**
     * Show the form for getCourseinfo resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomeCategoris($id)
    {
        $categorisInfo = IncomeCategoris::where('deleted_at', null)->where("branch_id", $id)->pluck("categoris", "id");
        // dd($coursefee);
        return json_encode($categorisInfo);
    }
    /**
     * Show the form for getCourseinfo resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getincctg($id)
    {
        $categorisInfo = IncomeCategoris::where('deleted_at', null)->where("branch_id", $id)->pluck("categoris", "id");
        // dd($coursefee);
        return json_encode($categorisInfo);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'categoris_id' =>  'required',
        //     'title' =>  'required',
        //     'amount' =>  'required',
        //     'invoiceDate' =>  'required',
        //     'createDate' =>  'required',
        //     'image' => 'mimes:jpeg,jpg,png,gif|max:1024'
        // ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $image = null;
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            $image = $this->uploadOne($params['image'], 'income');
        }
        if ($collection->has('image2') && $params['image2'] != null) {
            $img = $params['image2'];
            $path = 'public/income/';
            $paths = 'income/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $image = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        }
        $createDate = Date('Y-m-d h:s:i');
        // dd($createDate); 
        $merge = $collection->merge(compact('image','createDate'));
        $data = new Income($merge->all());
        $data->save();

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Incomme.', 'error', true, true);
        } else {
            return $this->responseRedirect('admin.income.index', 'Income added successfully', 'success', false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetData = Income::find($id);
        $data = Income::where('deleted_at', null)->get();
        $categoris = IncomeCategoris::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Income', 'View Income : ' . $targetData->title);
        if(request()->get('report')){
            $branchName = null; $serialNo = null; $comments = null; $totalInWords = null; $category = null;
            return view('admin.report.singleRecordPrint', compact('targetData','branchName','serialNo','comments','totalInWords','categoris','category'));
        }
        return view('admin.income.show', compact('data', 'targetData', 'categoris'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = Income::find($id);
        $data = Income::where('deleted_at', null)->get();
        $categoris = IncomeCategoris::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $branchs = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Income', 'Edit Income : ' . $targetData->title);
        return view('admin.income.edit', compact('data', 'targetData', 'categoris', 'branchs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Income  $Income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $params)
    {
        $this->validate($params, [
            'categoris_id' =>  'required',
            'title' =>  'required',
            'amount' =>  'required',
            'invoiceDate' =>  'required',
            'createDate' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1024'
        ]);

        $data = Income::find($params['id']);
        $collection = collect($params)->except('_token');
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            if ($data->image != null) {
                $this->deleteOne($data->image);
            }
            $image = $this->uploadOne($params['image'], 'income');
        } else if ($collection->has('image2') && $params['image2'] != null) {
            // unlink($params['oldimage']);
            $this->deleteOne($data->image);
            $img = $params['image2'];
            $path = 'public/income/';
            $paths = 'income/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $image = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        } else {
            $image = $params['oldimage'];
        }
        $merge = $collection->merge(compact('image'));
        $data->update($merge->all());
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Income.', 'error', true, true);
        }
        return $this->responseRedirect('admin.income.index', 'Income updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $data = Income::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Income.', 'error', true, true);
        }
        return $this->responseRedirect('admin.income.index', 'Income deleted successfully', 'success', false, false);
    }

    public  function shortShow(Request $request)
    {
        $id = $request->phoneData;
        $personal = Income::where('id', $id)->first();
        $buydate = strtotime($personal['invoiceDate']);
        $buydate = date('d-M-y', $buydate);
        // $employeeinfo = Employeeinfo::where('empID',$id)->first();
        $single = "<div class='row'>
            <div class='col-sm-12 col-md-12  col-lg-12'>
                <div class='tile'>
                    <div class='tile-body'>
                         <div class='card-body border'>
                            <div class='A4Size'>
                                <section>
                                    <article>
                                        <table width='100%'' cellpadding='5'>
                                            <tr>
                                                <th rowspan='7' width='20%'><div class='personalImage'>";
        if (isset($personal["image"])) {
            $single .= '<a data-magnify="gallery" data-src="" data-caption="' . $personal['title'] . '" data-group="a"
                                href="' . asset('public/storage/' . $personal['image']) . '">
                                <img src="' . asset('public/storage/' . $personal['image']) . '" class="rounded  img-thumbnail" alt="..." width="120">
                              </a>';
        } else {
            $single .= ' <img src="" class="rounded  img-thumbnail" alt="..." width="120"alt="!">';
        }
        $single .= '  </div></th>
                      </tr>
                      <tr>
                        <th>Sell/Collect Date</th>
                       <th> ' . $buydate . '</th>
                      </tr>
                      <tr>
                        <th>Invoice ID</th>
                        <th>' . $personal['invoiceID'] . '</th>
                      </tr>
                      <tr>
                        <th>Buyer/Student Name</th>
                        <th>' . $personal['recever'] . '</th>
                      </tr>
                      <tr>
                        <th>Seller/Accounts Name</th>
                        <th>' . $personal['seller'] . '</th>
                      </tr>
                      <tr>
                        <th>Invoice/Payslip Title</th>
                        <th>' . $personal['title'] . '</th>
                      </tr>
                      <tr>
                        <th>Total Amount</th>
                        <th>' . $personal['amount'] . ' BDT</th>
                      </tr>
                    </table>
                  </article>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>';
        return Response()->json($single, 200, [], JSON_UNESCAPED_UNICODE);
        //echo response()->json($single);
    }
}
