<?php

namespace App\Repository\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IBaseRepository
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function update($id, $attributes)
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    public function save($attributes): bool
    {
        return $this->model->save($attributes);
    }

    public function sync($attributes): bool
    {
        return $this->model->sync($attributes);
    }

    public function destroy($id): bool
    {
        return $this->model->destroy ($id);
    }

    public function find($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function firstOrCreate($attributes): Model
    {
        return $this->model->firstOrCreate($attributes);
    }

    public function where(...$where): Builder
    {
        return $this->model->where(...$where);
    }

    public function ranged($offset, $limit): Builder
    {
        return $this->model->offset($offset)->limit($limit);
    }

    public function with(...$with): Builder
    {
        return $this->model->with(...$with);
    }

    public function getPaginated(int $count = 2): LengthAwarePaginator
    {
        return $this->newQuery()
            ->orderBy('created_at', 'desc')
            ->paginate($count);
    }

    public function orderBy(string $columnName, string $orderDirection)
    {
        return $this->model->orderBy ($columnName, $orderDirection);
    }

    /**
     * The query builder
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * Alias for the query limit
     *
     * @var int
     */
    protected $take;

    /**
     * Array of related models to eager load
     *
     * @var array
     */
    protected $with = array();

    /**
     * Array of one or more where clause parameters
     *
     * @var array
     */
    protected $wheres = array();

    /**
     * Array of one or more where in clause parameters
     *
     * @var array
     */
    protected $whereIns = array();

    /**
     * Get all the model records in the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        $this->newQuery()->eagerLoad();
        $models = $this->query->get();
        $this->unsetClauses();
        return $models;
    }

    /**
     * Count the number of specified model records in the database
     *
     * @return int
     */
    public function count()
    {
        return $this->get()->count();
    }

    public function validate($attributes)
    {
        return $this->model->validate($attributes);
    }

    /**
     * Create a new model record in the database
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $this->unsetClauses();
        return $this->model->create($data);
    }

    /**
     * Delete one or more model records from the database
     *
     * @return mixed
     */
    public function delete()
    {
        $this->newQuery()->setClauses();
        $result = $this->query->delete();
        $this->unsetClauses();
        return $result;
    }

    /**
     * Delete the specified model record from the database
     *
     * @param $id
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $this->unsetClauses();
        return $this->getById($id)->delete();
    }

    public function deleteMultipleById(array $ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Get the first specified model record from the database
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function first()
    {
        $this->newQuery()->eagerLoad()->setClauses();
        $model = $this->query->firstOrFail();
        $this->unsetClauses();
        return $model;
    }

    /**
     * Get all the specified model records in the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        $this->newQuery()->eagerLoad()->setClauses();
        $models = $this->query->get();
        $this->unsetClauses();
        return $models;
    }

    /**
     * Get the specified model record from the database
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
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
    public function limit($limit)
    {
        $this->take = $limit;
        return $this;
    }

    /**
     * Update the specified model record in the database
     *
     * @param       $id
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateById($id, array $data)
    {
        $this->unsetClauses();
        $model = $this->getById($id);
        $model->update($data);
        return $model;
    }

    /**
     * Create a new instance of the model's query builder
     *
     * @return $this
     */
    protected function newQuery()
    {
        $this->query = $this->model->newQuery();
        return $this;
    }

    /**
     * Add relationships to the query builder to eager load
     *
     * @return $this
     */
    protected function eagerLoad()
    {
        foreach($this->with as $relation)
        {
            $this->query->with($relation);
        }
        return $this;
    }

    /**
     * Set clauses on the query builder
     *
     * @return $this
     */
    protected function setClauses()
    {
        foreach($this->wheres as $where)
        {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        foreach($this->whereIns as $whereIn)
        {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        if(isset($this->take) and ! is_null($this->take))
        {
            $this->query->take($this->take);
        }
        return $this;
    }

    /**
     * Reset the query clause parameter arrays
     *
     * @return $this
     */
    protected function unsetClauses()
    {
        $this->wheres = array();
        $this->whereIns = array();
        $this->take = null;
        return $this;
    }
}
