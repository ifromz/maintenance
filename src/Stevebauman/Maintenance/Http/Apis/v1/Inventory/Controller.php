<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Inventory;

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
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function($element)
        {
            return [
                'id' => $element->id,
                'sku' => ($element->sku_code ? $element->sku_code : '<em>None</em>'),
                'name' => $element->name,
                'category' => ($element->category ? $element->category->trail : null),
                'current_stock' => $element->viewer()->lblCurrentStock(),
                'created_at' => $element->created_at,
                'view_url' => route('maintenance.inventory.show', [$element->id]),
            ];
        };

        return $this->inventory->grid($columns, $settings, $transformer);
    }
}
