<?php

namespace Stevebauman\Maintenance\Models;

/**
 * Class InventoryAssembly
 * @package Stevebauman\Maintenance\Models
 */
class InventoryAssembly extends BaseModel
{
    protected $table = 'inventory_assemblies';

    protected $fillable = [
        'inventory_id',
        'part_id',
        'quantity',
        'depth',
    ];
}