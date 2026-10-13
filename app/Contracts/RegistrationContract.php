<?php

namespace App\Contracts;

/**
 * Interface RegistrationContract
 * @package App\Contracts
 */
interface RegistrationContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listRegistrations(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findRegistrationsById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createRegistrations(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateRegistrations(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteRegistrations($id);
}