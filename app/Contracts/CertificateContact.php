<?php

namespace App\Contracts;

/**
 * Interface CertificateContact
 * @package App\Contracts
 */
interface CertificateContact
{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCertificate(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCertificateById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCertificate(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCertificate(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCertificate($id);
}