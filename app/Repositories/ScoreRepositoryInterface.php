<?php

namespace App\Repositories;

interface ScoreRepositoryInterface
{
    /**
     * find by id.
     *
     * @param int $id
     *
     * @return object
     */
    public function findById($id);

    /**
     * keyword search and paginate.
     *
     * @param string $keyword
     * @param int    $page_num
     *
     * @return object
     */
    public function getPaginateRecordsByKeyword($keyword, $page_num);

    /**
     * create.
     *
     * @param object $data
     *
     * @return object
     */
    public function create($data);
}
