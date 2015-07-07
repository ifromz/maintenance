<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Inventory;

use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Repositories\Inventory\Repository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var Repository
     */
    protected $inventory;

    /**
     * Constructor.
     *
     * @param Repository $inventory
     */
    public function __construct(Repository $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Returns a new grid instance.
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
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 10,
        ];

        $transformer = function(Inventory $inventory)
        {
            return [
                'id' => $inventory->id,
                'sku' => ($inventory->sku_code ? $inventory->sku_code : '<em>None</em>'),
                'name' => $inventory->name,
                'category' => ($inventory->category ? $inventory->category->trail : null),
                'current_stock' => $inventory->viewer()->lblCurrentStock(),
                'created_at' => $inventory->created_at,
                'view_url' => route('maintenance.inventory.show', [$inventory->id]),
            ];
        };

        return $this->inventory->grid($columns, $settings, $transformer);
    }
}
