<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Inventory\Models\InventoryStock as BaseStock;

class InventoryStock extends BaseStock
{
    protected $viewer = 'Stevebauman\Maintenance\Viewers\InventoryStockViewer';

    protected $revisionFormattedFieldNames = array(
        'location_id' => 'Location',
        'quantity' => 'Quantity',
    );

    public function item()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Inventory', 'inventory_id', 'id');
    }
    public function movements()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStockMovement', 'stock_id')->orderBy('created_at', 'DESC');
    }

}