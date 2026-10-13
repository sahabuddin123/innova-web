<?php

namespace App\Contracts;

/**
 * Interface SessionContract
 * @package App\Contracts
 */
interface SessionContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listSessions(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findSessionsById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createSessions(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateSessions(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteSessions($id);
}