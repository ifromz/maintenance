<?php

use Stevebauman\Maintenance\Models\Inventory;

// The inventory observer.
Inventory::observe(new \Stevebauman\Maintenance\Handlers\Observers\InventoryObserver());
