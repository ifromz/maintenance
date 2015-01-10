<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\Inventory\InventoryService;

/**
 * Class InventorySelectComposer
 * @package Stevebauman\Maintenance\Composers
 */
class InventorySelectComposer
{

    /**
     * @var InventoryService
     */
    protected $inventory;

    /**
     * @param InventoryService $inventory
     */
    public function __construct(InventoryService $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * @param $view
     * @return mixed
     */
    public function compose($view)
    {
        $allInventories = $this->inventory->get()->lists('name', 'id');

        return $view->with('allInventories', $allInventories);
    }

}
