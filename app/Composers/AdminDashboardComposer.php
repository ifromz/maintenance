<?php

namespace App\Composers;

use Illuminate\View\View;
use App\Repositories\Asset\Repository as AssetRepository;
use App\Repositories\Inventory\Repository as InventoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkOrder\Repository as WorkOrderRepository;

class AdminDashboardComposer
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @var AssetRepository
     */
    protected $asset;

    /**
     * @var InventoryRepository
     */
    protected $inventory;

    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * Constructor.
     *
     * @param UserRepository      $user
     * @param AssetRepository     $asset
     * @param InventoryRepository $inventory
     * @param WorkOrderRepository $workOrder
     */
    public function __construct(UserRepository $user, AssetRepository $asset, InventoryRepository $inventory, WorkOrderRepository $workOrder)
    {
        $this->user = $user;
        $this->asset = $asset;
        $this->inventory = $inventory;
        $this->workOrder = $workOrder;
    }

    /**
     * @param $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        return $view
            ->with('users', $this->user->all()->count())
            ->with('assets', $this->asset->all()->count())
            ->with('inventories', $this->inventory->all()->count())
            ->with('workOrders', $this->workOrder->all()->count());
    }
}
