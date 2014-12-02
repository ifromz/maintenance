<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;

class AdminDashboardComposer {
    
    public function __construct(UserService $user, AssetService $asset, InventoryService  $inventory, WorkOrderService $workOrder){
        $this->user = $user;
        $this->asset = $asset;
        $this->inventory = $inventory;
        $this->workOrder = $workOrder;
    }
    
    public function compose($view)
    {
        return $view
            ->with('users', $this->user->get()->count())
            ->with('assets', $this->asset->get()->count())
            ->with('inventories', $this->inventory->get()->count())
            ->with('workOrders', $this->workOrder->get()->count());
    }
    
}