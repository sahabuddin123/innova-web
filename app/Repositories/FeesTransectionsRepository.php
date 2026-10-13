<?php

namespace App\Repositories;

use App\Models\FeesTransections;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\FeesTransactionsContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class FeesTransectionsRepository
 *
 * @package \App\Repositories
 */
class FeesTransectionsRepository extends BaseRepository implements FeesTransactionsContract
{
    use UploadAble;

    /**
     * FeesTransectionsRepository constructor.
     * @param FeesTransections $model
     */
    public function __construct(FeesTransections $model)
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
    public function listFeesTransactions(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findFeesTransactionsById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return FeesTransections|mixed
     */
    public function createFeesTransactions(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'feestransactions');
            }

            $merge = $collection->merge(compact('image'));

            $feestransactions = new FeesTransections($merge->all());

            $feestransactions->save();

            return $feestransactions;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFeesTransactions(array $params)
    {
        $feestransactions = $this->findFeesTransactionsById($params['id']);

        $collection = collect($params)->except('_token');
        $image=null;

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($feestransactions->image != null) {
                $this->deleteOne($feestransactions->image);
            }

            $image = $this->uploadOne($params['image'], 'feestransactions');
        }

        $merge = $collection->merge(compact('image'));

        $feestransactions->update($merge->all());

        return $feestransactions;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteFeesTransactions($id)
    {
        $feestransactions = $this->findFeesTransactionsById($id);

        if ($feestransactions->image != null) {
            $this->deleteOne($feestransactions->image);
        }

        $feestransactions->delete();

        return $feestransactions;
    }
}