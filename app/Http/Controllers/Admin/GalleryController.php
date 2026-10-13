<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Contracts\GalleryContract;
use App\Http\Controllers\BaseController; 

class GalleryController extends BaseController
{
        /**
     * @var GalleryContract 
     */
    protected $dataRepository;
    /**
     * CategoryController constructor.
     * @param GalleryContract $dataRepository
     */
    public function __construct(GalleryContract $dataRepository)
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
        $this->setPageTitle('Gallery', 'List of all Gallery Images');
        return view('admin.gallery.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->dataRepository->listData('id', 'asc');
        $this->setPageTitle('Add New Galary Image', 'Add Galary Image');
        return view('admin.gallery.create', compact('data'));
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
            'type'             =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png,gif,svg|max:3000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->createData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while Gallery Image.', 'error', true, true);
        }
        return $this->responseRedirect('admin.gallery.index', 'Gallery Image added successfully' ,'success',false, false);
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
        $this->setPageTitle('Gallery Image', 'Edit Gallery Image');
        return view('admin.gallery.edit', compact('data', 'targetData'));
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
            'type'             =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png,gif,svg|max:3000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->updateData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Gallery Image.', 'error', true, true);
        }
        return $this->responseRedirect('admin.gallery.index', 'Gallery Image updated successfully' ,'success',false, false);
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
            return $this->responseRedirectBack('Error occurred while deleting Gallery Image.', 'error', true, true);
        }
        return $this->responseRedirect('admin.gallery.index', 'Gallery Image deleted successfully' ,'success',false, false);
    }
}
