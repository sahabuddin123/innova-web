<?php

namespace App\Contracts;

/**
 * Interface AdmissionContact
 * @package App\Contracts
 */
interface AdmissionContact
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function list(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createData(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateData(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteData($id);
}