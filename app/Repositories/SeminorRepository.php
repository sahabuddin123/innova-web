<?php

namespace App\Repositories;

use App\Models\Seminor;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\SeminorContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class SeminorContract
 *
 * @package \App\Repositories
 */
class SeminorRepository extends BaseRepository implements SeminorContract
{
    use UploadAble;

    /**
     * SeminorContract constructor.
     * @param Seminor $model
     */
    public function __construct(Seminor $model)
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
     * @return Seminor|mixed
     */
    public function createData(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'Seminor');
            }

            $merge = $collection->merge(compact('image'));

            $data = new Seminor($merge->all());

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

            $image = $this->uploadOne($params['image'], 'Seminor');
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