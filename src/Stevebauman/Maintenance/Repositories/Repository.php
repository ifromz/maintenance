<?php

namespace Stevebauman\Maintenance\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Cartalyst\DataGrid\Laravel\Facades\DataGrid;

abstract class Repository
{
    /**
     * The repositories model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Returns the current model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract public function model();

    /**
     * Finds the specified inventory record by it's ID.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return $this->model()->find($id);
    }

    /**
     * Deletes a record on the current model.
     *
     * @param int|string $id
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete($id)
    {
        return $this->model()->destroy($id);
    }

    /**
     * Retrieves all of the current users inventory items.
     *
     * @param array    $columns
     * @param array    $settings
     * @param \Closure $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model();

        return $this->newGrid($model, $columns, $settings, $transformer);
    }

    /**
     * Constructs a new data grid instance with the
     * specified resource, columns and settings.
     *
     * @param mixed    $data
     * @param array    $columns
     * @param array    $settings
     * @param \Closure $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function newGrid($data, array $columns = [], array $settings = [], $transformer = null)
    {
        return DataGrid::make($data, $columns, $settings, $transformer);
    }

    /**
     * Caches an item with the specified key and value.
     *
     * @param int|string $key
     * @param mixed      $value
     * @param int        $minutes
     *
     * @return mixed
     */
    public function cache($key, $value, $minutes = 60)
    {
        return Cache::remember($key, $value, $minutes);
    }

    /**
     * Caches an item with the
     * specified key and value forever.
     *
     * @param int|string $key
     * @param mixed      $value
     *
     * @return mixed
     */
    public function cacheForever($key, $value)
    {
        return Cache::forever($key, $value);
    }

    /**
     * Returns true / false if the cache
     * contains an item with the specified key.
     *
     * @param int|string $key
     *
     * @return bool
     */
    public function cacheHas($key)
    {
        return Cache::has($key);
    }

    /**
     * Returns true / false if the key
     * specified has been forgotten in the cache.
     *
     * @param int|string $key
     *
     * @return bool
     */
    public function cacheForget($key)
    {
        return Cache::forget($key);
    }

    /**
     * Starts a database transaction
     */
    protected function dbStartTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * Commits the current database transaction
     */
    protected function dbCommitTransaction()
    {
        DB::commit();
    }

    /**
     * Rolls back a database transaction
     */
    protected function dbRollbackTransaction()
    {
        DB::rollback();
    }
}
