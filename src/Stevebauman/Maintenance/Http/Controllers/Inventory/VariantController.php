<?php

namespace Stevebauman\Maintenance\Http\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\InventoryValidator;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

/**
 * Class VariantController.
 */
class VariantController extends BaseController
{
    /**
     * @var InventoryService
     */
    protected $inventory;

    /**
     * @var InventoryValidator
     */
    protected $inventoryValidator;

    /**
     * Constructor.
     *
     * @param InventoryService   $inventory
     * @param InventoryValidator $inventoryValidator
     */
    public function __construct(InventoryService $inventory, InventoryValidator $inventoryValidator)
    {
        $this->inventory = $inventory;
        $this->inventoryValidator = $inventoryValidator;
    }

    /**
     * Displays the form for creating a variant
     * of the specified inventory.
     *
     * @param int|string $inventoryId
     *
     * @return \Illuminate\View\View
     */
    public function create($inventoryId)
    {
        $item = $this->inventory->find($inventoryId);

        return view('maintenance::inventory.variants.create', [
            'title' => 'Create Variant For: '.$item->name,
            'item' => $item,
        ]);
    }

    /**
     * Processes creating a variant of the specified
     * inventory item.
     *
     * @param int|string $inventoryId
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store($inventoryId)
    {
        if ($this->inventoryValidator->passes()) {
            $record = $this->inventory->setInput($this->inputAll())->createVariant($inventoryId);

            if ($record) {
                $this->message = sprintf('Successfully created item variant: %s', link_to_route('maintenance.inventory.show', 'Show', [$record->id]));
                $this->messageType = 'success';
                $this->redirect = route('maintenance.inventory.index');
            } else {
                $this->message = 'There was an error creating this variant. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.inventory.create');
            }
        } else {
            $this->redirect = route('maintenance.inventory.variants.create', [$inventoryId]);
            $this->errors = $this->inventoryValidator->getErrors();
        }

        return $this->response();
    }
}
