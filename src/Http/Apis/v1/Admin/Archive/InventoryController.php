<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Admin\Archive;

use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;
use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Repositories\Inventory\Repository as InventoryRepository;

class InventoryController extends BaseController
{
    /**
     * @var InventoryRepository
     */
    protected $inventory;

    /**
     * Constructor.
     *
     * @param InventoryRepository $inventory
     */
    public function __construct(InventoryRepository $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Returns a new grid instance of all available archived inventory items.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'name',
            'category_id',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function (Inventory $inventory) {
            return [
                'id'            => $inventory->id,
                'sku'           => ($inventory->sku_code ? $inventory->sku_code : '<em>None</em>'),
                'name'          => $inventory->name,
                'category'      => ($inventory->category ? $inventory->category->trail : null),
                'current_stock' => $inventory->viewer()->lblCurrentStock(),
                'created_at'    => $inventory->created_at,
                'view_url'      => route('maintenance.admin.archive.inventory.show', [$inventory->id]),
            ];
        };

        return $this->inventory->grid($columns, $settings, $transformer);
    }
}
