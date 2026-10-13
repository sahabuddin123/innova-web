<?php

namespace App\Repositories;

use App\Models\Batchs;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BatchsContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class BatchsRepository
 *
 * @package \App\Repositories
 */
class BatchsRepository extends BaseRepository implements BatchsContract
{
    use UploadAble;

    /**
     * BatchsRepository constructor.
     * @param Batchs $model
     */
    public function __construct(Batchs $model)
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
    public function listBatchs(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBatchsById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    } 

    /**
     * @param array $params
     * @return Batchs|mixed
     */
    public function createBatchs(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'batchs');
            }

            $merge = $collection->merge(compact('image'));

            $batchs = new Batchs($merge->all());

            $batchs->save();

            return $batchs;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBatchs(array $params)
    {
        date_default_timezone_set('Asia/Dhaka');
        $batchs = $this->findBatchsById($params['id']);

        $collection = collect($params)->except('_token');
        $image=null;

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($batchs->image != null) {
                $this->deleteOne($batchs->image);
            }

            $image = $this->uploadOne($params['image'], 'batchs');
        }
        $updatedate = date('y-m-d h:i:s');
        $merge = $collection->merge(compact('updatedate','image'));

        $batchs->update($merge->all());

        return $batchs;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteBatchs($id)
    {
        $batchs = $this->findBatchsById($id);

        if ($batchs->image != null) {
            $this->deleteOne($batchs->image);
        }

        $batchs->delete();

        return $batchs;
    }
}