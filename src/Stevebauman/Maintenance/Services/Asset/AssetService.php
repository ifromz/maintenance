<?php

namespace Stevebauman\Maintenance\Services\Asset;

use Exception;
use Stevebauman\Maintenance\Exceptions\AssetNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Asset;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class AssetService
 * @package Stevebauman\Maintenance\Services\Asset
 */
class AssetService extends BaseModelService
{

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param Asset $asset
     * @param SentryService $sentry
     * @param AssetNotFoundException $notFoundException
     */
    public function __construct(Asset $asset, SentryService $sentry, AssetNotFoundException $notFoundException)
    {
        $this->model = $asset;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }

    /**
     * Returns all assets paginated
     *
     * @return type Collection
     */
    public function getByPageWithFilter($archived = NULL)
    {
        return $this->model
            ->id($this->getInput('id'))
            ->name($this->getInput('name'))
            ->condition($this->getInput('condition'))
            ->category($this->getInput('category_id'))
            ->location($this->getInput('location_id'))
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->archived($archived)
            ->paginate(25);
    }

    /**
     * Returns common makes that are inputted into the DB for
     * auto-complete functionality
     *
     * @param type $make
     * @return type Collection
     */
    public function getMakes($make = NULL)
    {
        return $this->model
            ->select('make')
            ->distinct()
            ->where('make', 'LIKE', '%' . $make . '%')
            ->get();
    }

    /**
     * Returns common models that are inputted into the DB for
     * auto-complete functionality
     *
     * @param type $model
     * @return type Collection
     */
    public function getModels($model = NULL)
    {
        return $this->model
            ->distinct()
            ->select('model')
            ->where('model', 'LIKE', '%' . $model . '%')
            ->get();
    }

    /**
     * Returns common serials that are inputted into the DB for
     * auto-complete functionality
     *
     * @param type $serial
     * @return type Collection
     */
    public function getSerials($serial = NULL)
    {
        return $this->model
            ->distinct()
            ->select('serial')
            ->where('serial', 'LIKE', '%' . $serial . '%')
            ->get();
    }

    /**
     * Creates an asset
     *
     * @return boolean OR object
     */
    public function create()
    {

        $this->dbStartTransaction();

        try {

            /*
             * Set insert data
             */
            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'category_id' => $this->getInput('category_id'),
                'location_id' => $this->getInput('location_id'),
                'name' => $this->getInput('name', NULL, true),
                'condition' => $this->getInput('condition'),
                'vendor' => $this->getInput('vendor', NULL, true),
                'make' => $this->getInput('make', NULL, true),
                'model' => $this->getInput('model', NULL, true),
                'size' => $this->getInput('size', NULL, true),
                'weight' => $this->getInput('weight', NULL, true),
                'serial' => $this->getInput('serial', NULL, true),
                'acquired_at' => $this->formatDateWithTime($this->getInput('acquired_at')),
                'end_of_life' => $this->formatDateWithTime($this->getInput('end_of_life')),
            );

            /*
             * Create the record and return it upon success
             */
            $record = $this->model->create($insert);

            if ($record) {

                $this->fireEvent('maintenance.assets.created', array(
                    'asset' => $record
                ));

                $this->dbCommitTransaction();

                return $record;

            }

            $this->dbRollbackTransaction();

            /*
             * Failed to create record, return false
             */
            return false;


        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;

        }
    }

    /**
     * Updates an asset record
     *
     * @param type $id
     * @return boolean OR object
     */
    public function update($id)
    {

        $this->dbStartTransaction();

        try {

            /*
             * Find the asset record
             */
            $record = $this->find($id);

            /*
             * Set update data
             */
            $insert = array(
                'location_id' => $this->getInput('location_id', $record->location_id),
                'category_id' => $this->getInput('category_id', $record->category_id),
                'name' => $this->getInput('name', $record->name, true),
                'condition' => $this->getInput('condition', $record->condition),
                'vendor' => $this->getInput('vendor', $record->vendor, true),
                'make' => $this->getInput('make', $record->make, true),
                'model' => $this->getInput('model', $record->model, true),
                'size' => $this->getInput('size', $record->size, true),
                'weight' => $this->getInput('weight', $record->weight, true),
                'serial' => $this->getInput('serial', $record->serial, true),
                'aquired_at' => ($this->formatDateWithTime($this->getInput('aquired_at')) ?: $record->aquired_at),
                'end_of_life' => ($this->formatDateWithTime($this->getInput('end_of_life')) ?: $record->end_of_life),
            );

            /*
             * Update the record and return it upon success
             */
            if ($record->update($insert)) {

                $this->fireEvent('maintenance.assets.created', array(
                    'asset' => $record
                ));

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            /*
             * Failed to update record, return false;
             */
            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }

    }

    public function destroy($id)
    {
        $record = $this->find($id);

        $record->delete();

        $this->fireEvent('maintenance.assets.archived', array(
            'asset' => $record
        ));

        return true;
    }

}