<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BlogContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class BlogRepository
 *
 * @package \App\Repositories
 */
class BlogRepository extends BaseRepository implements BlogContract
{
    use UploadAble;

    /**
     * BlogRepository constructor.
     * @param Blog $model
     */
    public function __construct(Blog $model)
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
    public function listCourses(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCourseById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Blog|mixed
     */
    public function createCourse(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'blog');
            }

            $merge = $collection->merge(compact('image'));

            $courses = new Blog($merge->all());

            $courses->save();

            return $courses;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCourse(array $params)
    {
        $courses = $this->findCourseById($params['id']);

        $collection = collect($params)->except('_token');
        $image= $params['imageno'];
        // dd($image);

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($courses->image != null) {
                $this->deleteOne($courses->image);
            }

            $image = $this->uploadOne($params['image'], 'blog');
        }

        $merge = $collection->merge(compact('image'));

        $courses->update($merge->all());

        return $courses;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCourse($id)
    {
        $courses = $this->findCourseById($id);

        if ($courses->image != null) {
            $this->deleteOne($courses->image);
        }

        $courses->delete();

        return $courses;
    }
}