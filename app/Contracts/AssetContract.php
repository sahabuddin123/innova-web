<?php

namespace App\Contracts;

interface AssetContract
{
    public function listAssets(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    public function findAssetById(int $id);

    public function createAsset(array $params);

    public function updateAsset(array $params);

    public function deleteAsset($id);
}
