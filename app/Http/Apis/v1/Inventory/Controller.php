<?php

namespace App\Http\Apis\v1\Inventory;

use App\Http\Apis\v1\Controller as BaseController;
use App\Models\Inventory;
use App\Repositories\Inventory\Repository;

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
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function (Inventory $inventory) {
            return [
                'id'            => $inventory->getKey(),
                'sku'           => ($inventory->getSkuCodeAttribute() ? $inventory->getSkuCodeAttribute() : '<em>None</em>'),
                'name'          => $inventory->name,
                'category'      => ($inventory->category ? $inventory->category->trail : null),
                'current_stock' => $inventory->viewer()->lblCurrentStock(),
                'created_at'    => $inventory->created_at,
                'view_url'      => route('maintenance.inventory.show', [$inventory->id]),
            ];
        };

        return $this->inventory->grid($columns, $settings, $transformer);
    }
}
