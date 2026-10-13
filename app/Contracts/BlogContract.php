<?php

namespace App\Contracts;

/**
 * Interface BlogContract
 * @package App\Contracts
 */
interface BlogContract
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCourses(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCourseById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCourse(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCourse(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCourse($id);
}