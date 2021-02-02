<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{

    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $data)
    {
        try {
            $data['password'] = bcrypt($data['password']);
            return $this->repository->create($data);
        } catch (\Exception $e) {
            throw new CustomException('Failed on create resource', 500);
        }
    }

    public function update(int $id, array $data)
    {
        try {
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            return $this->repository->update($id, $data);
        } catch (\Exception $e) {
            throw new CustomException('Failed on update resource', 500);
        }
    }
}
