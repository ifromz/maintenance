<?php

namespace Stevebauman\Maintenance\Models\Extended;

use Venturecraft\Revisionable\RevisionableTrait;
use Stevebauman\Viewer\Traits\ViewableTrait;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Inventory\Models\InventoryStock as BaseStock;

class InventoryStock extends BaseStock
{
    use RevisionableTrait;

    use TableTrait;

    use ViewableTrait;

    protected $viewer = 'Stevebauman\Maintenance\Viewers\InventoryStockViewer';

    public function item()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Extended\Inventory', 'inventory_id', 'id');
    }
    public function movements()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\Extended\InventoryStockMovement', 'stock_id')->orderBy('created_at', 'DESC');
    }

}