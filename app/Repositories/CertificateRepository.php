<?php

namespace App\Repositories;

use App\Models\Certificates;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CertificateContact;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CertificateRepository
 *
 * @package \App\Repositories
 */
class CertificateRepository extends BaseRepository implements CertificateContact
{
    use UploadAble;

    /**
     * CertificateRepository constructor.
     * @param Certificates $model
     */
    public function __construct(Certificates $model)
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
     * @return Certificates|mixed
     */
    public function createCertificate(array $params)
    {
        try {
            $collection = collect($params);

            $cimage = null;
            $dimage = null;
            if ($collection->has('cimage') && ($params['cimage'] instanceof  UploadedFile)) {
                $cimage = $this->uploadOne($params['cimage'], 'Certificate');
            }
            if ($collection->has('dimage') && ($params['dimage'] instanceof  UploadedFile)) {
                $dimage = $this->uploadOne($params['dimage'], 'Certificate');
            }

            $merge = $collection->merge(compact('cimage', 'dimage'));

            $certificate = new Certificates($merge->all());

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


        if ($collection->has('cimage') && ($params['cimage'] instanceof  UploadedFile)) {

            if ($certificate->cimage != null) {
                $this->deleteOne($certificate->cimage);
                unlink($certificate->cimage);
            }
            
            $cimage = $this->uploadOne($params['cimage'], 'Certificate');
        } else {
            $cimage = $params['oldcimage'];
        }

        if ($collection->has('dimage') && ($params['dimage'] instanceof  UploadedFile)) {

            if ($certificate->dimage != null) {
                $this->deleteOne($certificate->dimage);
                unlink($certificate->dimage);
            }

            $dimage = $this->uploadOne($params['dimage'], 'Certificate');
        } else {
            $dimage = $params['olddimage'];
        }

        $merge = $collection->merge(compact('cimage', 'dimage'));

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
