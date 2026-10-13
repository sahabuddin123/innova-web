<?php

namespace App\Contracts;

/**
 * Interface BatchsContract
 * @package App\Contracts
 */
interface BatchsContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listBatchs(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findBatchsById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createBatchs(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBatchs(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteBatchs($id);
}