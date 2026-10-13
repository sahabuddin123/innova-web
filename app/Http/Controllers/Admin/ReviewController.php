<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Contracts\ReviewsContract;
use App\Http\Controllers\BaseController; 

class ReviewController extends BaseController
{
        /**
     * @var ReviewsContract 
     */
    protected $dataRepository;
    /**
     * CategoryController constructor.
     * @param ReviewsContract $dataRepository
     */
    public function __construct(ReviewsContract $dataRepository)
    {
        $this->dataRepository = $dataRepository; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->dataRepository->listData('id', 'desc');

        $this->setPageTitle('Review', 'List of all Review');
        return view('admin.review.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->dataRepository->listData('id', 'asc');
        $student = Students::where('deleted_at', null)->get();
        $this->setPageTitle('Create New Review', 'Create Review');
        return view('admin.review.create', compact('data','student'));
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
            'student_id'        =>  'required|max:191',
            'msg'               =>  'required',
            'IsActive'          =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->createData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while Review.', 'error', true, true);
        }
        return $this->responseRedirect('admin.review.index', 'Review added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $Review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $Review
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = $this->dataRepository->findDataById($id);
        $data = $this->dataRepository->listData();
        $student = Students::where('deleted_at', null)->get();
        $this->setPageTitle('Review', 'Edit Review');
        return view('admin.review.edit', compact('data', 'targetData','student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $Review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'student_id'        =>  'required|max:191',
            'msg'               =>  'required',
            'IsActive'          =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->updateData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Story.', 'error', true, true);
        }
        return $this->responseRedirect('admin.review.index', 'Review updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $Review
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $data = $this->dataRepository->deleteData($id);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Review.', 'error', true, true);
        }
        return $this->responseRedirect('admin.review.index', 'Review deleted successfully' ,'success',false, false);
    }
}
