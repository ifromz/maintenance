<?php

namespace Stevebauman\Maintenance\Services\Inventory;

use Stevebauman\Maintenance\Exceptions\InventoryStockNotFoundException;
use Stevebauman\Maintenance\Models\InventoryStock;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class StockService
 * @package Stevebauman\Maintenance\Services\Inventory
 */
class StockService extends BaseModelService
{

    public function __construct(
        InventoryStock $inventoryStock,
        StockMovementService $inventoryStockMovement,
        InventoryStockNotFoundException $notFoundException
    )
    {
        $this->model = $inventoryStock;
        $this->inventoryStockMovement = $inventoryStockMovement;
        $this->notFoundException = $notFoundException;
    }

    /**
     * Creates a stock record as well as a first record movement
     *
     * @return bool|static
     */
    public function create()
    {

        $this->dbStartTransaction();

        try {

            /*
             * Set insert data
             */
            $insert = array(
                'inventory_id' => $this->getInput('inventory_id'),
                'location_id' => $this->getInput('location_id'),
                'quantity' => $this->getInput('quantity')
            );

            /*
             * Create the stock record
             */
            $record = $this->model->create($insert);

            if ($record) {

                /*
                 * Fire stock created event
                 */
                $this->fireEvent('maintenance.inventory.stock.created', array(
                    'stock' => $record
                ));

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

    /**
     * Updates the current stock record and creates a stock movement when it has
     * been updated.
     *
     * @param string|int $id
     * @return bool|static
     */
    public function update($id)
    {

        $this->dbStartTransaction();

        try {

            $record = $this->find($id);

            $location = $this->getInput('location_id');

            /*
             * Move the stock if the location has changed
             */
            if ($location != $record->location->id) {

                $record->moveTo($location);

            }

            $quantity = $this->getInput('quantity', $record->quantity);
            $reason = $this->getInput('reason', NULL, true);
            $cost = $this->getInput('cost', NULL);

            /*
             * Update the stocks quantity
             */
            if ($record->updateQuantity($quantity, $reason, $cost)) {

                /*
                 * Fire stock updated event
                 */
                $this->fireEvent('maintenance.inventory.stock.updated', array(
                    'stock' => $record
                ));

                $this->dbCommitTransaction();

                /*
                 * Return updated stock record
                 */
                return $record;

            }

            /*
             * Rollback on failure to update the stock record
             */
            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

    /**
     * Updates the stock record by taking away the inputted stock by the current stock,
     * effectively processing a "taking from stock" action.
     *
     * @param string|int $id
     * @return bool|static
     */
    public function take($id)
    {

        $this->dbStartTransaction();

        try {
            /*
             * Find the stock record
             */
            $record = $this->find($id);

            /*
             * Update stock record
             */
            if ($record->take($this->getInput('quantity', 0), $this->getInput('reason'))) {

                /*
                 * Fire stock taken event
                 */
                $this->fireEvent('maintenance.inventory.stock.taken', array(
                    'stock' => $record
                ));

                $this->dbCommitTransaction();

                return $record;
            }

            /*
             * Rollback on failure to update the record
             */
            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }

    }

    /**
     * Updates the stock record by adding the inputted stock to the current stock,
     * effectively processing a "putting into the stock" action.
     *
     * @param string|int $id
     * @return mixed
     */
    public function put($id)
    {

        $this->dbStartTransaction();

        try {

            /*
             * Find the stock record
             */
            $record = $this->find($id);

            /*
             * Update the record
             */
            if ($record->put($this->getInput('quantity'), $this->getInput('reason'), $this->getInput('cost', 0))) {

                /*
                 * Fire stock put event
                 */
                $this->fireEvent('maintenance.inventory.stock.put', array(
                    'stock' => $record
                ));

                $this->dbCommitTransaction();

                /*
                 * Return the record
                 */
                return $record;

            }

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }

    }

}