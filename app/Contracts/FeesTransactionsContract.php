<?php

namespace App\Contracts;

/**
 * Interface FeesTransactionsContract
 * @package App\Contracts
 */
interface FeesTransactionsContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listFeesTransactions(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findFeesTransactionsById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createFeesTransactions(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateFeesTransactions(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteFeesTransactions($id);
}