<?php

namespace App\Repositories;

use App\Models\Shareholder;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\ShareHolderContact;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
// use Storege;
use Illuminate\Support\Facades\Storage;
/**
 * Class ShareHolderRepository
 *
 * @package \App\Repositories
 */
class ShareHolderRepository extends BaseRepository implements ShareHolderContact
{
    use UploadAble;

    /**
     * ShareHolderRepository constructor.
     * @param Shareholder $model
     */
    public function __construct(Shareholder $model)
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
     * @return Shareholder|mixed
     */
    public function createData(array $params)
    {
        try {
            $collection = collect($params);

            $image = null;
            $nid = null;
            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'ShareHolder');
                
            }
            if ($collection->has('nid') && ($params['nid'] instanceof  UploadedFile)) {
                $nid = $this->uploadOne($params['nid'], 'ShareHolder');
                
            }
        
            $merge = $collection->merge(compact('image','nid'));

            $shareholder = new Shareholder($merge->all());

            $shareholder->save();

            return $shareholder;

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
        $shareholder = $this->findById($params['id']);

        $collection = collect($params)->except('_token');
        

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($shareholder->image != null) {
                $this->deleteOne($shareholder->image);
            }

            $image = $this->uploadOne($params['image'], 'ShareHolder');
        }
        else{
            $image = $params['oldimage'];
        }

        if ($collection->has('nid') && ($params['nid'] instanceof  UploadedFile)) {

            if ($shareholder->nid != null) {
                $this->deleteOne($shareholder->nid);
            }

            $nid = $this->uploadOne($params['nid'], 'ShareHolder');
        }
        else{
            $nid = $params['oldnid'];
        }

        $merge = $collection->merge(compact('image','nid'));

        $shareholder->update($merge->all());

        return $shareholder;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteData($id)
    {
        $shareholder = $this->findById($id);

        if ($shareholder->image != null) {
            $this->deleteOne($shareholder->image);
        }
        if ($shareholder->nid != null) {
            $this->deleteOne($shareholder->image);
        }

        $shareholder->delete();

        return $shareholder;
    }
}