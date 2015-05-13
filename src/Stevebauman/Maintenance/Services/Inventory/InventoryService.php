<?php

namespace Stevebauman\Maintenance\Services\Inventory;

use Stevebauman\Maintenance\Exceptions\NotFound\Inventory\InventoryNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class InventoryService.
 */
class InventoryService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param Inventory                  $inventory
     * @param SentryService              $sentry
     * @param InventoryNotFoundException $notFoundException
     */
    public function __construct(Inventory $inventory, SentryService $sentry, InventoryNotFoundException $notFoundException)
    {
        $this->model = $inventory;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }

    /**
     * Returns all inventory items paginated, with eager loaded relationships,
     * as well as scopes for search.
     *
     * @param null $archived
     *
     * @return mixed
     */
    public function getByPageWithFilter($archived = null)
    {
        return $this->model
            ->with([
                'category',
                'user',
                'stocks',
            ])
            ->id($this->getInput('id'))
            ->name($this->getInput('name'))
            ->description($this->getInput('description'))
            ->category($this->getInput('category_id'))
            ->sku($this->getInput('sku'))
            ->stock(
                $this->getInput('operator'),
                $this->getInput('quantity')
            )
            ->archived($archived)
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->paginate(25);
    }

    /**
     * Creates an item record.
     *
     * @return mixed
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            /*
             * Set input data
             */
            $insert = [
                'category_id' => $this->getInput('category_id'),
                'user_id' => $this->sentry->getCurrentUserId(),
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name', null, true),
                'description' => $this->getInput('description', null, true),
            ];

            /*
             * If the record is created, return it, otherwise return false
             */
            $record = $this->model->create($insert);

            if ($record) {
                /*
                 * Fire created event
                 */
                $this->fireEvent('maintenance.inventory.created', [
                    'item' => $record,
                ]);

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Updates an item record.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {

            /*
             * Find the item record
             */
            $record = $this->find($id);

            /*
             * Set update data
             */
            $insert = [
                'category_id' => $this->getInput('category_id', $record->category_id),
                'metric_id' => $this->getInput('metric'),
                'name' => $this->getInput('name', $record->name, true),
                'description' => $this->getInput('description', $record->description, true),
            ];

            /*
             * Update the record, return it upon success
             */
            if ($record->update($insert)) {
                /*
                 * Fire updated event
                 */
                $this->fireEvent('maintenance.inventory.updated', [
                    'item' => $record,
                ]);

                $this->dbCommitTransaction();

                return $record;
            }

            $this->dbRollbackTransaction();

            return false;
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();

            return false;
        }
    }

    /*
     * Archives an item record
     */
    public function destroy($id)
    {
        $record = $this->find($id);

        $record->delete();

        /*
         * Fire archived event
         */
        $this->fireEvent('maintenance.inventory.archived', [
            'item' => $record,
        ]);

        return true;
    }
}
