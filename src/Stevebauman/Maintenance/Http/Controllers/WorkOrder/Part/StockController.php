<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder\Part;

use Stevebauman\Maintenance\Validators\WorkOrder\PartPutBackValidator;
use Stevebauman\Maintenance\Validators\WorkOrder\PartTakeValidator;
use Stevebauman\Maintenance\Services\Inventory\StockMovementService;
use Stevebauman\Maintenance\Services\Inventory\StockService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class StockController extends Controller
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var InventoryService
     */
    protected $inventory;

    /**
     * @var StockService
     */
    protected $inventoryStock;

    /**
     * @var StockMovementService
     */
    protected $inventoryStockMovement;

    /**
     * @var PartTakeValidator
     */
    protected $workOrderPartTakeValidator;

    /**
     * @var PartPutBackValidator
     */
    protected $workOrderPartPutBackValidator;

    /**
     * Constructor.
     *
     * @param WorkOrderService $workOrder
     * @param InventoryService $inventory
     * @param StockService $inventoryStock
     * @param StockMovementService $inventoryStockMovement
     * @param PartTakeValidator $workOrderPartTakeValidator
     * @param PartPutBackValidator $workOrderPartPutBackValidator
     */
    public function __construct(
        WorkOrderService $workOrder,
        InventoryService $inventory,
        StockService $inventoryStock,
        StockMovementService $inventoryStockMovement,
        PartTakeValidator $workOrderPartTakeValidator,
        PartPutBackValidator $workOrderPartPutBackValidator
    ) {
        $this->workOrder = $workOrder;
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
        $this->inventoryStockMovement = $inventoryStockMovement;
        $this->workOrderPartTakeValidator = $workOrderPartTakeValidator;
        $this->workOrderPartPutBackValidator = $workOrderPartPutBackValidator;
    }

    /**
     * Display Inventory item stocks per location
     * available to transfer into the work order.
     *
     * @param int|string $workOrderId
     * @param int|string $inventoryId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId, $inventoryId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);

        return view('maintenance::work-orders.parts.inventory.stocks.index', compact('workOrder', 'item'));
    }

    /**
     * Displays the form for taking inventory stock
     * and attaching it to the specified work order.
     *
     * @param int|string $workOrderId
     * @param int|string $inventoryId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function getTake($workOrderId, $inventoryId, $stockId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);
        $stock = $item->stocks()->findOrFail($stockId);

        return view('maintenance::work-orders.parts.inventory.stocks.take', compact('workOrder', 'item', 'stock'));
    }

    public function postTake($workOrderId, $inventoryId, $stockId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);
        $stock = $item->stocks()->findOrFail($stockId);
    }

    public function getPut($workOrderId, $inventoryId, $stockId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);
    }

    public function postPut($workOrderId, $inventoryId, $stockId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);
    }

    /**
     * Display the form to update the quantity the
     * user is taking from the inventory for the work order.
     *
     * @param int|string $workOrder_id
     * @param int|string $inventory_id
     * @param int|string $stock_id
     *
     * @return \Illuminate\View\View
     */
    public function create($workOrder_id, $inventory_id, $stock_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);
        $item = $this->inventory->find($inventory_id);
        $stock = $this->inventoryStock->find($stock_id);

        return view('maintenance::work-orders.parts.stocks.create', [
            'title' => 'Enter Quantity Used',
            'workOrder' => $workOrder,
            'item' => $item,
            'stock' => $stock,
        ]);
    }

    /**
     * Process the quantity the user is taking from the stock location.
     *
     * @param int|string $workOrder_id
     * @param int|string $inventory_id
     * @param int|string $stock_id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store($workOrder_id, $inventory_id, $stock_id)
    {
        if ($this->workOrderPartTakeValidator->passes()) {
            $workOrder = $this->workOrder->find($workOrder_id);
            $item = $this->inventory->find($inventory_id);
            $stock = $this->inventoryStock->find($stock_id);

            /*
             * Grab all input data
             */
            $data = $this->inputAll();

            /*
             * Add Part to work order (passing in the work order and the stock)
             */
            $this->workOrder->setInput($data)->savePart($workOrder, $stock);

            /*
             * Set the extra input data for the inventory stock change reason
             */
            $data['reason'] = sprintf('Used for <a href="%s">Work Order</a>', route('maintenance.work-orders.show', [$workOrder->id]));

            /*
             * Perform a take from the stock
             */
            $this->inventoryStock->setInput($data)->take($stock->id);

            /*
             * Set the return messages
             */
            $this->message = sprintf(
                'Successfully added %s of %s to work order. %s or %s',
                $this->input('quantity'),
                $item->name,
                link_to_route('maintenance.work-orders.parts.index', 'Add More', [$workOrder->id]),
                link_to_route('maintenance.work-orders.show', 'View Work Order', [$workOrder->id])
            );

            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.parts.index', [$workOrder->id]);
        } else {
            $this->errors = $this->workOrderPartTakeValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.parts.stocks.create', [
                $workOrder_id, $inventory_id, $stock_id,
            ]);
        }

        return $this->response();
    }

    /**
     * Destroys the pivot table entry of the stock quantity used in the work order,
     * then returns the quantity back to the stock and creates a movement indicating
     * that the quantity of the item was put back from a work order.
     *
     * @param int|string $workOrder_id
     * @param int|string $inventory_id
     * @param int|string $stock_id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postPutBack($workOrder_id, $inventory_id, $stock_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);
        $item = $this->inventory->find($inventory_id);
        $stock = $this->inventoryStock->find($stock_id);

        /*
         * Find the specific work order part record from the stock id
         */
        $record = $workOrder->parts->find($stock->id);

        /*
         * Set the reason and quantity of why the putting back is taking place
         */
        $data = [
            'reason' => sprintf('Put back from <a href="%s">Work Order</a>', route('maintenance.work-orders.show', [$workOrder->id])),
            'quantity' => $record->pivot->quantity,
        ];

        /*
         * Update the inventory stock record
         */
        $this->inventoryStock->setInput($data)->put($stock->id);

        /*
         * Remove the part from the work order
         */
        $workOrder->parts()->detach($stock->id);

        $this->message = sprintf('Successfully put back %s into the inventory', $item->name);
        $this->messageType = 'success';
        $this->redirect = route('maintenance.work-orders.show', [$workOrder->id]);

        return $this->response();
    }

    /**
     * Processes a put back some operation on the specified
     * inventory stock from the specified work order.
     *
     * @param int|string $workOrder_id
     * @param int|string $inventory_id
     * @param int|string $stock_id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postPutBackSome($workOrder_id, $inventory_id, $stock_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);
        $item = $this->inventory->find($inventory_id);
        $stock = $this->inventoryStock->find($stock_id);

        /*
         * Find the specific work order part record from the stock id
         */
        $part = $workOrder->parts->find($stock->id);

        /*
         * Add less than rule so users must enter a number below the quantity that
         * was taken for the work order
         */
        $this->workOrderPartPutBackValidator->addRule('quantity', 'less_than:'.$part->pivot->quantity);

        if ($this->workOrderPartPutBackValidator->passes()) {

            /*
             * Set the reason and quantity of why the putting back is taking place
             */
            $data = [
                'reason' => sprintf('Put back from <a href="%s">Work Order</a>', route('maintenance.work-orders.show', [$workOrder->id])),
                'quantity' => $this->input('quantity'),
            ];

            /*
             * Update the inventory stock record
             */
            $this->inventoryStock->setInput($data)->put($stock->id);

            /*
             * Set the new pivot quantity
             */
            $newQuantity = $part->pivot->quantity - $this->input('quantity');

            /*
             * Update the existing pivot record
             */
            $workOrder->parts()->updateExistingPivot($stock->id, ['quantity' => $newQuantity]);

            $this->message = sprintf('Successfully put back %s into the inventory', $item->name);
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.show', [$workOrder->id]);
        } else {
            $this->errors = $this->workOrderPartPutBackValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.parts.stocks.index', [$workOrder_id, $inventory_id]);
        }

        return $this->response();
    }
}
