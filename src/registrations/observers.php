<?php

use Stevebauman\Maintenance\Models\Inventory;

Inventory::observe(new \Stevebauman\Maintenance\Handlers\Observers\InventoryObserver());