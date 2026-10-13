<?php

namespace App\Repositories;

use App\Models\Slider;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\SliderContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class SliderRepository
 *
 * @package \App\Repositories
 */
class SliderRepository extends BaseRepository implements SliderContract
{
    use UploadAble;

    /**
     * SliderRepository constructor.
     * @param Slider $model
     */
    public function __construct(Slider $model)
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
    public function listData(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findDataById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Slider|mixed
     */
    public function createData(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'slider');
            }

            $merge = $collection->merge(compact('image'));

            $data = new Slider($merge->all());

            $data->save();

            return $data;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateData(array $params)
    {
        $data = $this->findDataById($params['id']);

        $collection = collect($params)->except('_token');
        $image= $params['imageno'];
        // dd($image);

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($data->image != null) {
                $this->deleteOne($data->image);
            }

            $image = $this->uploadOne($params['image'], 'slider');
        }

        $merge = $collection->merge(compact('image'));

        $data->update($merge->all());

        return $data;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteData($id)
    {
        $data = $this->findDataById($id);

        if ($data->image != null) {
            $this->deleteOne($data->image);
        }

        $data->delete();

        return $data;
    }
}