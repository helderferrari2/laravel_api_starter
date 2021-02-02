<?php

namespace App\Repositories\Contracts;

interface AbstractRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function find(int $id);
    public function paginate($limit = null, $columns = array('*'));
}
