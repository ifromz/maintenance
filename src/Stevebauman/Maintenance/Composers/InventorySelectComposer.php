<?php 

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\Inventory\InventoryService;

class InventorySelectComposer {
    
    public function __construct(InventoryService $inventory){
        $this->inventory = $inventory;
    }
    
    public function compose($view)
    {
        $allInventories = $this->inventory->get()->lists('name', 'id');
        
        return $view->with('allInventories', $allInventories);
    }
    
}
