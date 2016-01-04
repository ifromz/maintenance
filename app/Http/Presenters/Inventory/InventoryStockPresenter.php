<?php

namespace App\Http\Presenters\Inventory;

use App\Models\Location;
use App\Models\Inventory;
use App\Models\InventoryStock;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;
use Orchestra\Contracts\Html\Table\Column;
use Orchestra\Contracts\Html\Table\Grid as TableGrid;
use App\Http\Presenters\Presenter;

class InventoryStockPresenter extends Presenter
{
    /**
     * Returns a new table of all stocks of the specified inventory item.
     *
     * @param Inventory $item
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function table(Inventory $item)
    {
        $stocks = $item->stocks();

        return $this->table->of('inventory.stock', function (TableGrid $table) use ($item, $stocks) {
            $table->with($stocks);

            $table->attributes([
                'class' => 'table table-hover table-striped',
            ]);

            $table->column('quantity');

            $table->column('location', function (Column $column) use ($item) {
                $column->value = function (InventoryStock $stock) use ($item) {
                    $name = $stock->location->trail;

                    return link_to_route('maintenance.inventory.stocks.show', $name, [$item->getKey(), $stock->getKey()]);
                };
            });

            $table->column('last_movement', function (Column $column) {
                $column->value = function (InventoryStock $stock) {
                    return $stock->last_movement;
                };
            });

            $table->column('last_movement_by', function (Column $column) {
                $column->value = function (InventoryStock $stock) {
                    return $stock->last_movement_by;
                };
            });
        });
    }

    /**
     * Returns a new form of the specified inventory stock.
     *
     * @param Inventory      $item
     * @param InventoryStock $stock
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(Inventory $item, InventoryStock $stock)
    {
        return $this->form->of('inventory.stock', function (FormGrid $form) use ($item, $stock) {
            if ($stock->exists) {
                $method = 'PATCH';
                $url = route('maintenance.inventory.stocks.update', [$item->getKey(), $stock->getKey()]);
                $form->submit = 'Save';
            } else {
                $method = 'POST';
                $url = route('maintenance.inventory.stocks.store', [$item->getKey()]);
                $form->submit = 'Create';
            }

            $locations = Location::getSelectHierarchy();

            $form->with($stock);
            $form->attributes(compact('method', 'url'));

            $form->fieldset(function (Fieldset $fieldset) use ($locations) {
                $fieldset
                    ->control('select', 'location')
                    ->value(function (InventoryStock $stock) {
                        return $stock->location_id;
                    })
                    ->options($locations);

                $fieldset
                    ->control('input:text', 'quantity')
                    ->attributes([
                        'placeholder' => 'ex. 45',
                    ]);

                $fieldset
                    ->control('input:text', 'reason')
                    ->attributes([
                        'placeholder' => 'ex. Stock Update',
                    ]);

                $fieldset
                    ->control('input:text', 'cost')
                    ->attributes([
                        'placeholder' => 'ex. 15.00',
                    ]);
            });
        });
    }

    /**
     * Returns a new navbar for the inventory stock index.
     *
     * @param Inventory $item
     *
     * @return \Illuminate\Support\Fluent
     */
    public function navbar(Inventory $item)
    {
        return $this->fluent([
            'id'         => 'inventory-stocks',
            'title'      => 'Item Stocks',
            'url'        => route('maintenance.inventory.stocks.index', [$item->getKey()]),
            'menu'       => view('inventory.stocks._nav', compact('item')),
            'attributes' => [
                'class' => 'navbar-default',
            ],
        ]);
    }
}
