<?php

namespace App\Repositories;

use App\Models\Session;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\SessionContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class SessionsRepository
 *
 * @package \App\Repositories
 */
class SessionsRepository extends BaseRepository implements SessionContract
{
    use UploadAble;

    /**
     * SessionsRepository constructor.
     * @param Session $model
     */
    public function __construct(Session $model)
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
    public function listSessions(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findSessionsById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    } 

    /**
     * @param array $params
     * @return Session|mixed
     */
    public function createSessions(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'sessions');
            }

            $merge = $collection->merge(compact('image'));

            $batchs = new Session($merge->all());

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
    public function updateSessions(array $params)
    {
        date_default_timezone_set('Asia/Dhaka');
        $batchs = $this->findSessionsById($params['id']);

        $collection = collect($params)->except('_token');
        $image=null;

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($batchs->image != null) {
                $this->deleteOne($batchs->image);
            }

            $image = $this->uploadOne($params['image'], 'sessions');
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
    public function deleteSessions($id)
    {
        $batchs = $this->findSessionsById($id);

        if ($batchs->image != null) {
            $this->deleteOne($batchs->image);
        }

        $batchs->delete();

        return $batchs;
    }
}