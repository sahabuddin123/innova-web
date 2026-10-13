<?php

namespace App\Repositories;

use App\Models\Invesments;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\InvestmentContact;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class InvestmentRepository
 *
 * @package \App\Repositories
 */
class InvestmentRepository extends BaseRepository implements InvestmentContact
{
    use UploadAble;

    /**
     * InvestmentRepository constructor.
     * @param Invesments $model
     */
    public function __construct(Invesments $model)
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
    public function list(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    }

    /**
     * @param array $params
     * @return Invesments|mixed
     */
    public function createData(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'investment');
            }

            $merge = $collection->merge(compact('image'));

            $investment = new Invesments($merge->all());

            $investment->save();

            return $investment;

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
        $Invesments = $this->findById($params['id']);

        $collection = collect($params)->except('_token');
        $image=null;

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($Invesments->image != null) {
                $this->deleteOne($Invesments->image);
            }

            $image = $this->uploadOne($params['image'], 'invesments');
        }

        $merge = $collection->merge(compact('image'));

        $Invesments->update($merge->all());

        return $Invesments;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteData($id)
    {
        $Invesments = $this->findById($id);

        if ($Invesments->image != null) {
            $this->deleteOne($Invesments->image);
        }

        $Invesments->delete();

        return $Invesments;
    }
}