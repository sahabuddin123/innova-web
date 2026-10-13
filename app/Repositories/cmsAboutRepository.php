<?php

namespace App\Repositories;

use App\Models\cmsAbout;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\cmsAboutContact;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class cmsAboutRepository
 *
 * @package \App\Repositories
 */
class cmsAboutRepository extends BaseRepository implements cmsAboutContact
{
    use UploadAble;

    /**
     * cmsAboutRepository constructor.
     * @param cmsAbout $model
     */
    public function __construct(cmsAbout $model)
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
    public function listCertificate(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCertificateById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return cmsAbout|mixed
     */
    public function createCertificate(array $params)
    {
        try {
            $collection = collect($params);

            $bgimg1 = null;
            $bgimg2 = null;
            if ($collection->has('bgimg1') && ($params['bgimg1'] instanceof  UploadedFile)) {
                $bgimg1 = $this->uploadOne($params['bgimg1'], 'cmsAbout');
            }
            if ($collection->has('bgimg2') && ($params['bgimg2'] instanceof  UploadedFile)) {
                $bgimg2 = $this->uploadOne($params['bgimg2'], 'cmsAbout');
            }

            $merge = $collection->merge(compact('bgimg1', 'bgimg2'));

            $certificate = new cmsAbout($merge->all());

            $certificate->save();

            return $certificate;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCertificate(array $params)
    {
        $certificate = $this->findCertificateById($params['id']);

        $collection = collect($params)->except('_token');


        if ($collection->has('bgimg1') && ($params['bgimg1'] instanceof  UploadedFile)) {

            if ($certificate->bgimg1 != null) {
                $this->deleteOne($certificate->bgimg1);
                unlink($certificate->bgimg1);
            }
            
            $bgimg1 = $this->uploadOne($params['bgimg1'], 'cmsAbout');
        } else {
            $bgimg1 = $params['oldcimage'];
        }

        if ($collection->has('bgimg2') && ($params['bgimg2'] instanceof  UploadedFile)) {

            if ($certificate->bgimg2 != null) {
                $this->deleteOne($certificate->bgimg2);
                unlink($certificate->bgimg2);
            }

            $bgimg2 = $this->uploadOne($params['bgimg2'], 'cmsAbout');
        } else {
            $bgimg2 = $params['olddimage'];
        }

        $merge = $collection->merge(compact('bgimg1', 'bgimg2'));

        $certificate->update($merge->all());

        return $certificate;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCertificate($id)
    {
        $ertificate = $this->findCertificateById($id);

        if ($ertificate->image != null) {
            $this->deleteOne($ertificate->image);
        }
        if ($ertificate->nid != null) {
            $this->deleteOne($ertificate->image);
        }

        $ertificate->delete();

        return $ertificate;
    }
}
