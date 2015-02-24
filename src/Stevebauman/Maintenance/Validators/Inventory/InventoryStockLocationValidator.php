<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Services\Inventory\StockService;
use Illuminate\Support\Facades\Route;

/**
 * Class InventoryStockLocationValidator
 * @package Stevebauman\Maintenance\Validators
 */
class InventoryStockLocationValidator
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
    
    public function validateStockLocation($attribute, $location_id, $parameters)
    {
        $item_id = Route::getCurrentRoute()->getParameter('inventory');
        $stock_id = Route::getCurrentRoute()->getParameter('stocks');

        if(isset($stock_id))
        {
         $stocks = $this
             ->inventoryStock
             ->where('inventory_id', $item_id)
             ->where('id', '!=', $stock_id)
             ->where('location_id', $location_id)
             ->get();
        } else
        {
         $stocks = $this
             ->inventoryStock
             ->where('inventory_id', $item_id)
             ->where('location_id', $location_id)
             ->get();
        }

        if($stocks->count() > 0) return false;

        return true;
    }
    
}