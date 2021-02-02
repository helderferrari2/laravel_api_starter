<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\CustomException;
use App\Repositories\Contracts\AbstractRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository implements AbstractRepositoryInterface
{
    protected $model;
    protected $limit = 15;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get Model
     *
     * @param Model $model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get class name
     *
     * @param Model $model
     */
    protected function getClassName()
    {
        return class_basename($this->model);
    }


    /**
     * Retrieve all data of repository
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a resource by id
     *
     * @param $id
     * @return Model|null
     * @throws Exception
     */
    public function find(int $id)
    {
        $response = $this->model->find($id);
        if (empty($response)) {
            throw new CustomException($this->getClassName() . ' not found', 404);
        }
        return $response;
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param $id
     * @return Model
     */
    public function update(int $id, array $data)
    {
        $model = $this->find($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     * @return int
     */
    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function findOneBy(array $criteria)
    {
        return $this->model->where($criteria)->first();
    }

    /**
     * Retrieve all data of repository, paginated
     * @param null $limit
     * @param array $columns
     * @return Paginator
     */
    public function paginate($limit = null, $columns = array('*'))
    {
        $limit = empty(!$limit) ? $limit : $this->limit;
        return $this->model->paginate($limit, $columns);
    }

    /**
     * Load relations
     *
     * @param array $relations
     * @return $this
     */
    public function with(array $relations)
    {
        return $this->model->with($relations);
    }
}
