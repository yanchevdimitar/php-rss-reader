<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * The repository model
     *
     * @var Model
     */
    protected Model $model;

    /**
     * The query builder
     */
    protected Builder $query;

    /**
     * Alias for the query limit
     */
    protected ?int $take;

    /**
     * Array of related models to eager load
     */
    protected array $with = [];

    /**
     * Array of one or more where clause parameters
     */
    protected array $wheres = [];

    /**
     * Array of one or more where in clause parameters
     */
    protected array $whereIns = [];


    /**
     * Array of one or more ORDER BY column/value pairs
     */
    protected array $orderBys = [];

    /**
     * Array of scope methods to call on the model
     */
    protected array $scopes = [];

    /**
     * Get all the model records in the database
     */
    public function all(): Collection
    {
        $this->newQuery()->eagerLoad();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }

    /**
     * Count the number of specified model records in the database
     */
    public function count(): int
    {
        return $this->get()->count();
    }

    /**
     * Create a new model record in the database
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $this->unsetClauses();

        return $this->model->create($data);
    }

    /**
     * Create one or more new model records in the database
     *
     * @param array $data
     * @return Collection
     */
    public function createMultiple(array $data): Collection
    {
        $models = new Collection();

        foreach ($data as $d) {
            $models->push($this->create($d));
        }

        return $models;
    }

    /**
     * Delete one or more model records from the database
     */
    public function delete(): mixed
    {
        $this->newQuery()->setClauses()->setScopes();

        $result = $this->query->delete();

        $this->unsetClauses();

        return $result;
    }


    /**
     * Delete the specified model record from the database
     *
     * @param $id
     * @return bool|null
     */
    public function deleteById($id): ?bool
    {
        $this->unsetClauses();

        return $this->getById($id)->delete();
    }


    /**
     * Delete multiple records
     *
     * @param array $ids
     * @return int
     */
    public function deleteMultipleById(array $ids): int
    {
        return $this->model->destroy($ids);
    }

    /**
     * Get the first specified model record from the database
     */
    public function first(): Model
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->firstOrFail();

        $this->unsetClauses();

        return $model;
    }

    /**
     * Get all the specified model records in the database
     */
    public function get(): Collection
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }

    /**
     * Get the specified model record from the database
     *
     * @param $id
     * @return Model
     */
    public function getById($id): Model
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->findOrFail($id);
    }

    /**
     * Set the query limit
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit): static
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Set an ORDER BY clause
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc'): static
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * Update the specified model record in the database
     *
     * @param       $id
     * @param array $data
     *
     * @return Model
     */
    public function updateById($id, array $data): Model
    {
        $this->unsetClauses();

        $model = $this->getById($id);

        $model->update($data);

        return $model;
    }

    /**
     * Add a simple where clause to the query
     *
     * @param string $column
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function where($column, $value, $operator = '='): static
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query
     *
     * @param string $column
     * @param mixed $values
     *
     * @return $this
     */
    public function whereIn($column, $values): static
    {
        $values = is_array($values) ? $values : array($values);

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations): static
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Create a new instance of the model's query builder
     *
     * @return $this
     */
    protected function newQuery(): static
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load
     *
     * @return $this
     */
    protected function eagerLoad(): static
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder
     *
     * @return $this
     */
    protected function setClauses(): static
    {
        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (isset($this->take) and !is_null($this->take)) {
            $this->query->take($this->take);
        }

        return $this;
    }

    /**
     * Set query scopes
     *
     * @return $this
     */
    protected function setScopes(): static
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(implode(', ', $args));
        }

        return $this;
    }

    /**
     * Reset the query clause parameter arrays
     *
     * @return $this
     */
    protected function unsetClauses(): static
    {
        $this->wheres = array();
        $this->whereIns = array();
        $this->scopes = array();
        $this->take = null;

        return $this;
    }
}
