<?php

namespace Stevebauman\Maintenance\Repositories;

use Cartalyst\DataGrid\Laravel\Facades\DataGrid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Maintenance\Models\Revision;

abstract class Repository
{
    /**
     * Returns the current model instance.
     *
     * @return Model
     */
    abstract public function model();

    /**
     * Returns all of the models results.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model()->all();
    }

    /**
     * Finds the specified record by its ID.
     *
     * @param int|string $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->model()->findOrFail($id);
    }

    /**
     * Finds the specified archived record by its ID.
     *
     * @param int|string $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return mixed
     */
    public function findArchived($id)
    {
        return $this->model()->onlyTrashed()->findOrFail($id);
    }

    /**
     * Deletes a record on the current model.
     *
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->model()->destroy($id);
    }

    /**
     * Deletes an archived record on the current model.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function deleteArchived($id)
    {
        $record = $this->findArchived($id);

        if ($record) {
            $record->forceDelete();

            return true;
        }

        return false;
    }

    /**
     * Restores an archived record.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function restore($id)
    {
        $record = $this->findArchived($id);

        if ($record) {
            return $record->restore();
        }

        return false;
    }

    /**
     * Returns a new grid instance of the current model.
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
     * Returns a new grid instance of the current models archived records.
     *
     * @param array    $columns
     * @param array    $settings
     * @param \Closure $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridArchived(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model()->onlyTrashed();

        return $this->newGrid($model, $columns, $settings, $transformer);
    }

    /**
     * Constructs a new data grid instance
     * tailored to revision history settings.
     *
     * @param mixed $data
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function newHistoryGrid($data)
    {
        $columns = [
            'id',
            'user_id',
            'revisionable_type',
            'revisionable_id',
            'key',
            'new_value',
            'old_value',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function (Revision $revision) {
            return [
                'user'       => $revision->getUserResponsible()->full_name,
                'key'        => $revision->getKey(),
                'old_value'  => (!is_null($revision->getOldValue()) ? $revision->getOldValue() : '<em>None</em>'),
                'new_value'  => ($revision->getNewValue() ? $revision->getNewValue() : '<em>None</em>'),
                'created_at' => $revision->created_at->format('Y-m-d g:i a'),
            ];
        };

        return $this->newGrid($data, $columns, $settings, $transformer);
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
     * @param int        $minutes
     * @param \Closure   $closure
     *
     * @return mixed
     */
    public function cache($key, $minutes = 60, \Closure $closure)
    {
        return Cache::remember($key, $minutes, $closure);
    }

    /**
     * Caches an item with the
     * specified key and value forever.
     *
     * @param int|string $key
     * @param \Closure   $closure
     *
     * @return mixed
     */
    public function cacheForever($key, $closure)
    {
        return Cache::rememberForever($key, $closure);
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
     * Converts a string to a date for inserting into the database.
     *
     * @param string $str
     *
     * @return bool|string
     */
    protected function strToDate($str)
    {
        return date('Y-m-d H:i:s', strtotime($str));
    }
}
