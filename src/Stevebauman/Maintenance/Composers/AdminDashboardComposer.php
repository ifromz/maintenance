<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;

/**
 * Class AdminDashboardComposer
 * @package Stevebauman\Maintenance\Composers
 */
class AdminDashboardComposer
{

    /**
     * @var UserService
     */
    protected $user;

    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * @var InventoryService
     */
    protected $inventory;

    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @param UserService $user
     * @param AssetService $asset
     * @param InventoryService $inventory
     * @param WorkOrderService $workOrder
     */
    public function __construct(UserService $user, AssetService $asset, InventoryService $inventory, WorkOrderService $workOrder)
    {
        $this->user = $user;
        $this->asset = $asset;
        $this->inventory = $inventory;
        $this->workOrder = $workOrder;
    }

    /**
     * @param $view
     * @return mixed
     */
    public function compose($view)
    {
        return $view
            ->with('users', $this->user->get()->count())
            ->with('assets', $this->asset->get()->count())
            ->with('inventories', $this->inventory->get()->count())
            ->with('workOrders', $this->workOrder->get()->count());
    }

}