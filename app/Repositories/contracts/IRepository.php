<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository {
    public function find(int $id): Model|null;

    public function all(): Collection;

    public function update(int $id, array $parameters):int;

    public function delete(int $id):int;

    public function create(array $parameters):Model|null;

    public function updateOrCreate(array $atributes, array $values):Model|null;
}

?>
