<?php

namespace Stevebauman\Maintenance\Handlers\Observers;

use Stevebauman\Inventory\Models\Inventory;

class InventoryObserver
{
    /**
     * Captures the Inventory models deleted event
     * and cascades the delete to all of the
     * it's children relationships.
     *
     * @param Inventory $model
     */
    public function deleted(Inventory $model)
    {
        $stocks = $model->stocks()->get();

        if(count($stocks) > 0) {
            foreach($stocks as $stock) {

                $movements = $stock->movements()->get();

                if(count($movements) > 0) {

                    foreach($movements as $movement) {
                        $movement->delete();
                    }
                }

                $stock->delete();
            }
        }
    }

    /**
     * Captures the Inventory models restored event
     * and cascades the restore to all of it's
     * children relationships.
     *
     * @param Inventory $model
     */
    public function restored(Inventory $model)
    {
        $stocks = $model->stocks()->onlyTrashed()->get();

        if(count($stocks) > 0) {
            foreach($stocks as $stock) {

                $movements = $stock->movements()->onlyTrashed()->get();

                if(count($movements) > 0) {

                    foreach($movements as $movement) {
                        $movement->restore();
                    }
                }

                $stock->restore();
            }
        }
    }
}
