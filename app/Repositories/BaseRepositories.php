<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepositories
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array  $attributes
     * @return mixed
     */

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function insert(array $attributes)
    {
        return $this->model->insert($attributes);
    }

    /**
     * @param array  $attributes
     * @param int $id
     * @return boolean
     */

    public function update(array $attributes, int $id): bool
    {
        return $this->model->find($id)->update($attributes);
    }

    /**
     * basically updateOrCreate retrun insert id 
     * @param array  $search_data
     * @param array  $attributes
     * @return mixed
     */

    public function updateOrCreate(array $search_data, array $attributes)
    {
       //dd($attributes);
      return $this->model->updateOrCreate($search_data,$attributes);
       
    }

    /**
     * basically updateOrInsert not retrun insert id 
     * @param array  $search_data
     * @param array  $attributes
     * @return mixed
     */

    public function updateOrInsert(array $search_data, array $attributes)
    {
        return $this->model->updateOrInsert($search_data, $attributes);
    }

    /**
     * basically fatching by all data 
     * @param array  $columns
     * @param string  $orderBy
     * @param string  $sortBy
     * @return mixed
     */

    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * basically fatching by all data 
     * @param int $id
     * @return mixed
     */

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * ModelNotFoundException
     * @param int $id
     * @return mixed
     * @
     */

    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * basically fatching by conditional data 
     * @param array $data
     * @return mixed

     */

    public function findBy(array $data)
    {
        return $this->model->where($data)->get();
    }

    /**
     * basically fatching by conditional data but showing first data
     * @param array $data
     * @return mixed

     */

    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    /**
     * basically fatching by conditional data but showing first data and not found data then modelNotFoundException
     * @param array $data
     * @return mixed

     */

    public function findOneByFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    /**
     *
     * @param int $id
     * @return mixed

     */

    public function delete(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    /**
     * delete method and destroy campaire delete can single data delete but destroy can multiple data data 
     * @param int $id
     * @return mixed

     */

    public function destroy(array $data): bool
    {
        return $this->model->destroy($data);
    }
}
