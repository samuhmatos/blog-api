<?php

namespace App\Repositories;
use App\Repositories\Contracts\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Repository implements IRepository {
    protected $model;

    public function model():Model
    {
        return app($this->model);
    }
    public function create(array $parameters):Model|null
    {
        return $this->model()
            ->query()
            ->create($parameters);
    }

    public function update(int $id, array $parameters):int{
        return $this->model()
            ->query()
            ->where('id', $id)
            ->update($parameters);
    }
    public function delete(int $id):int
    {
        return $this->model()
            ->query()
            ->where('id', $id)
            ->delete();
    }
    public function find(int $id): Model| null
    {
        return $this->model()
            ->query()
            ->find($id);
    }

    public function all(): Collection
    {
        return $this->model()::all();
    }
}
