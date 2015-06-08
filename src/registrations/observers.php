<?php

use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Models\InventoryStock;

// The inventory observers.
Inventory::observe(new \Stevebauman\Maintenance\Handlers\Observers\Inventory\Observer());
InventoryStock::observe(new \Stevebauman\Maintenance\Handlers\Observers\Inventory\StockObserver());
