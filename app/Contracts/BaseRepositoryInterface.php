<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{

    public function all(): Collection;

    public function count(): int;

    public function create(array $data): Model;

    public function createMultiple(array $data): Collection;

    public function delete(): mixed;

    public function deleteById($id): ?bool;

    public function deleteMultipleById(array $ids): int;

    public function first(): Model;

    public function get(): Collection;

    public function getById($id): Model;

    public function limit($limit): static;

    public function orderBy($column, $value): static;

    public function updateById($id, array $data): Model;

    public function where($column, $value, $operator = '='): static;

    public function whereIn($column, $value): static;

    public function with($relations): static;
}
