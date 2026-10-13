<?php

namespace App\Contracts;

/**
 * Interface StudentsContract
 * @package App\Contracts
 */
interface StudentsContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listStudents(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findStudentsById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createStudents(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateStudents(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteStudents($id);
}