<?php

namespace App\Repositories;

use App\Models\Registration;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\RegistrationContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class RegistrationsRepository
 *
 * @package \App\Repositories
 */
class RegistrationsRepository extends BaseRepository implements RegistrationContract
{
    use UploadAble;

    /**
     * RegistrationsRepository constructor.
     * @param Registration $model
     */
    public function __construct(Registration $model)
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
    public function listRegistrations(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findRegistrationsById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }

    } 

    /**
     * @param array $params
     * @return Registration|mixed
     */
    public function createRegistrations(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'Registration');
            }

            $merge = $collection->merge(compact('image'));

            $batchs = new Registration($merge->all());

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
    public function updateRegistrations(array $params)
    {
        date_default_timezone_set('Asia/Dhaka');
        $batchs = $this->findRegistrationsById($params['id']);

        $collection = collect($params)->except('_token');
        $image=null;

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($batchs->image != null) {
                $this->deleteOne($batchs->image);
            }

            $image = $this->uploadOne($params['image'], 'Registration');
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
    public function deleteRegistrations($id)
    {
        $batchs = $this->findRegistrationsById($id);

        if ($batchs->image != null) {
            $this->deleteOne($batchs->image);
        }

        $batchs->delete();

        return $batchs;
    }
}