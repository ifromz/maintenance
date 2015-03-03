<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Inventory\Traits\InventorySkuTrait;

/**
 * Class InventorySku
 * @package Stevebauman\Maintenance\Models
 */
class InventorySku extends BaseModel
{
    use InventorySkuTrait;

    protected $table = 'inventory_skus';

    protected $fillable = array(
        'inventory_id',
        'prefix',
        'code',
    );
}