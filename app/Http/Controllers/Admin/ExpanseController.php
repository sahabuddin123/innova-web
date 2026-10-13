<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Expanse;
use App\Models\ExpanseCategoris;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Branch;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class ExpanseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Expanse::where('deleted_at',null)->orderBy('id','asc')->with('exCategoris')->get();
        $branchs = Branch::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Expanse', 'List of all Expanse');
        return view('admin.expance.index', compact('data','branchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Expanse::where('deleted_at',null)->orderBy('id','asc')->get();
        $categoris = ExpanseCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $branchs = Branch::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Create New Expanse', 'Create Expanse');
        return view('admin.expance.create', compact('data','categoris','branchs'));
    }
    /**
     * Show the form for getCourseinfo resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpanceCategoris($id)
    {
        $categorisInfo = ExpanseCategoris::where('deleted_at',null)->where("branch_id", $id)->pluck("categoris", "id");
        // dd($coursefee);
        return json_encode($categorisInfo);
    }
    /**
     * Show the form for getCourseinfo resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getexctg($id)
    {
        $categorisInfo = ExpanseCategoris::where('deleted_at',null)->where("branch_id", $id)->pluck("categoris", "id");
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
        $this->validate($request, [
            'categoris_id' =>  'required',
            'title' =>  'required',
            'amount' =>  'required',
            'invoiceDate' =>  'required',
            'createDate' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1024'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $image = null;
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            $image = $this->uploadOne($params['image'], 'expanse');
        }
        if($collection->has('image2') && $params['image2'] !=null){
            $img = $params['image2'];
            $path = 'public/expanse/';
            $paths = 'expanse/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $image = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        }
        $merge = $collection->merge(compact('image'));
        $data = new Expanse($merge->all());
        $data->save();
        
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Expanse.', 'error', true, true);
        }
        else{
            return $this->responseRedirect('admin.expance.index', 'Expanse added successfully' ,'success',false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expanse  $expanse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetData = Expanse::find($id);
        $data = Expanse::where('deleted_at',null)->get();
        $categoris = ExpanseCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Expanse', 'View Expanse : '.$targetData->title);
        // If requested as report, show printable single-record layout
        if(request()->get('report')){
            $branchName = null; $serialNo = null; $comments = null; $totalInWords = null;
            return view('admin.report.singleRecordPrint', compact('targetData','branchName','serialNo','comments','totalInWords','categoris'));
        }
        return view('admin.expance.show', compact('data', 'targetData','categoris'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expanse  $expanse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = Expanse::find($id);
        $data = Expanse::where('deleted_at',null)->get();
        $categoris = ExpanseCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $branchs = Branch::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Expanse', 'Edit Expanse : '.$targetData->title);
        return view('admin.expance.edit', compact('data', 'targetData','categoris','branchs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expanse  $expanse
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

        $data = Expanse::find($params['id']);
        $collection = collect($params)->except('_token');
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            if ($data->image != null) {
                $this->deleteOne($data->image);
            }
            $image = $this->uploadOne($params['image'], 'expanse');
        }
        else if($collection->has('image2') && $params['image2'] !=null){
            // unlink($params['oldimage']);
            $this->deleteOne($data->image);
            $img = $params['image2'];
            $path = 'public/expanse/';
            $paths = 'expanse/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $image = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        }
        else{
            $image = $params['oldimage'];
        }
        $merge = $collection->merge(compact('image'));
        $data->update($merge->all());
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Expanse.', 'error', true, true);
        }
        return $this->responseRedirect('admin.expance.index', 'Expanse updated successfully' ,'success',false, false);
    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expanse  $expanse
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $data = Expanse::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Expanse.', 'error', true, true);
        }
        return $this->responseRedirect('admin.expance.index', 'Expanse deleted successfully' ,'success',false, false);
    
    }

    public  function shortShow(Request $request){
        $id = $request->phoneData;
        $personal = Expanse::where('id',$id)->first();
        $buydate = strtotime($personal['invoiceDate']);
        $buydate = date('d-M-y',$buydate);
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
                                                    if(isset($personal["image"])){
                                                    $single .= '<a data-magnify="gallery" data-src="" data-caption="'.$personal['title'].'" data-group="a"
                                href="'.asset('public/storage/'.$personal['image']).'">
                                <img src="'. asset('public/storage/'.$personal['image']).'" class="rounded  img-thumbnail" alt="..." width="120">
                              </a>';

                        }

                             else{
                             $single .=' <img src="" class="rounded  img-thumbnail" alt="..." width="120"alt="!">';
                              }
                           $single .='  </div></th>
                      </tr>
                      <tr>
                        <th>Buy Date</th>
                       <th> '.$buydate.'</th>
                      </tr>
                      <tr>
                        <th>Invoice ID</th>
                        <th>'.$personal['invoiceID'].'</th>
                      </tr>
                      <tr>
                        <th>Buyer Name</th>
                        <th>'.$personal['recever'].'</th>
                      </tr>
                      <tr>
                        <th>Seller Name</th>
                        <th>'.$personal['seller'].'</th>
                      </tr>
                      <tr>
                        <th>Invoice Title</th>
                        <th>'.$personal['title'].'</th>
                      </tr>
                      <tr>
                        <th>Total Amount</th>
                        <th>'.$personal['amount'].' BDT</th>
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
