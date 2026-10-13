<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AssetContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class AssetRepository extends BaseRepository implements AssetContract
{
    use UploadAble;

    public function __construct(Asset $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listAssets(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function findAssetById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function createAsset(array $params)
    {
        try {
            $collection = collect($params);
            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'Assets');
            }

            $merge = $collection->merge(compact('image'));
            $asset = new Asset($merge->all());
            $asset->save();

            return $asset;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    public function updateAsset(array $params)
    {
        $asset = $this->findAssetById($params['id']);
        $collection = collect($params)->except('_token');
        $image = $params['image_no'] ?? $asset->image;

        if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {
            if ($asset->image != null) {
                $this->deleteOne($asset->image);
            }
            $image = $this->uploadOne($params['image'], 'Assets');
        }

        $merge = $collection->merge(compact('image'));
        $asset->update($merge->all());

        return $asset;
    }

    public function deleteAsset($id)
    {
        $asset = $this->findAssetById($id);

        if ($asset->image != null) {
            $this->deleteOne($asset->image);
        }

        $asset->delete();
        return $asset;
    }
}
