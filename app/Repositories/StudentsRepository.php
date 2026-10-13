<?php

namespace App\Repositories;

use App\Models\Students;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\StudentsContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
// use Storege;
use Illuminate\Support\Facades\Storage;
/**
 * Class StudentsRepository
 *
 * @package \App\Repositories
 */
class StudentsRepository extends BaseRepository implements StudentsContract
{
    use UploadAble;

    /**
     * StudentsRepository constructor.
     * @param Students $model
     */
    public function __construct(Students $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listStudents(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findStudentsById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Students|mixed
     */
    public function createStudents(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;
            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'students');
                
            }
            // dd($params);
            if($collection->has('image2') && $params['image2'] !=null){
                $img = $params['image2'];
                $path = 'public/students/';
                $paths = 'students/';
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.png';
                $imagepth = $path . $fileName;
                $image = $paths . $fileName;
                Storage::put($imagepth, $image_base64);
            }
            
            $fees = $params['course_fee'];
            $duscount = $params['discount'];
            $discountAmount = $params['course_fee']*($params['discount']/100);
            $balance = $fees - $discountAmount;
            $course_fee = $params['course_fee'];
        
            $merge = $collection->merge(compact('course_fee','balance','image'));

            $students = new Students($merge->all());

            $students->save();

            return $students;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateStudents(array $params)
    {
        $students = $this->findStudentsById($params['id']);

        $collection = collect($params)->except('_token');
        

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($students->image != null) {
                $this->deleteOne($students->image);
            }

            $image = $this->uploadOne($params['image'], 'students');
        }
        else if($collection->has('image2') && $params['image2'] !=null){
            // unlink($params['oldimage']);
            $this->deleteOne($students->image);
            $img = $params['image2'];
            $path = 'public/students/';
            $paths = 'students/';
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

            $fees = $params['course_fee'];
            $duscount = $params['discount'];
            $discountAmount = $params['course_fee']*($params['discount']/100);
            $balance = $fees - $discountAmount;
            $course_fee = $params['course_fee'];
        
            $merge = $collection->merge(compact('course_fee','balance','image'));

        $students->update($merge->all());

        return $students;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteStudents($id)
    {
        $students = $this->findStudentsById($id);

        if ($students->image != null) {
            $this->deleteOne($students->image);
        }

        $students->delete();

        return $students;
    }
}