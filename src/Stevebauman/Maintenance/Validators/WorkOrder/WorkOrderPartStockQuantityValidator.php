<?php

namespace Stevebauman\Maintenance\Validators;

use Illuminate\Support\Facades\Route;
use Stevebauman\Maintenance\Services\Inventory\StockService;

/**
 * Class WorkOrderPartStockQuantityValidator.
 */
class WorkOrderPartStockQuantityValidator
{
    /**
     * @var StockService
     */
    protected $inventoryStock;

    /**
     * @param StockService $inventoryStock
     */
    public function __construct(StockService $inventoryStock)
    {
        $this->inventoryStock = $inventoryStock;
    }

    public function validateEnoughQuantity($attribute, $quantity, $parameters)
    {
        if (is_numeric($quantity)) {
            $stock_id = Route::getCurrentRoute()->getParameter('stocks');

            $stock = $this->inventoryStock->find($stock_id);

            if ($quantity > $stock->quantity) {
                return false;
            }

            return true;
        }

        return false;
    }
}
