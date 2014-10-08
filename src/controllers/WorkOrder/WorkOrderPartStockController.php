<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\WorkOrderPartValidator;
use Stevebauman\Maintenance\Services\InventoryStockMovementService;
use Stevebauman\Maintenance\Services\InventoryStockService;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class WorkOrderPartStockController extends AbstractController {
    
    public function __construct(
            WorkOrderService $workOrder, 
            InventoryService $inventory, 
            InventoryStockService $inventoryStock,
            InventoryStockMovementService $inventoryStockMovement,
            WorkOrderPartValidator $workOrderPartValidator){
        $this->workOrder = $workOrder;
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
        $this->inventoryStockMovement = $inventoryStockMovement;
        $this->workOrderPartValidator = $workOrderPartValidator;
    }
    
    public function getIndex($workOrder_id, $inventory_id){
        $workOrder = $this->workOrder->find($workOrder_id);
        $item = $this->inventory->find($inventory_id);
        
        return $this->view('maintenance::work-orders.parts.stocks.index', array(
            'title' => 'Choose Quantities',
            'workOrder' => $workOrder,
            'item' => $item
        ));
    }
    
    public function getAdd($workOrder_id, $inventory_id, $stock_id){
        
        $workOrder = $this->workOrder->find($workOrder_id);
        $item = $this->inventory->find($inventory_id);
        $stock = $this->inventoryStock->find($stock_id);
        
        return $this->view('maintenance::work-orders.parts.stocks.add', array(
            'title' => "Enter Quantity Used",
            'workOrder' => $workOrder,
            'item' => $item,
            'stock' => $stock
        ));
        
    }
    
    public function postStore($workOrder_id, $inventory_id, $stock_id){
        $validator = new $this->workOrderPartValidator;
        
        if($validator->passes()){
            
            $workOrder = $this->workOrder->find($workOrder_id);
            $item = $this->inventory->find($inventory_id);
            $stock = $this->inventoryStock->find($stock_id);
            
            $workOrder->parts()->attach($stock->id, array('quantity'=>$this->input('quantity')));
            
            $data = $this->inputAll();
            $data['reason'] = sprintf('Used for <a href="%s">Work Order</a>', route('maintenance.work-orders.show', array($workOrder->id)));

            $this->inventoryStock->setInput($data)->take($stock->id);
            
            $this->message = sprintf('Successfully added %s of %s to work order', $this->input('quantity'), $item->name);
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.parts.index', array($workOrder->id));
            
        } else{
            
            $this->errors = $validator->getErrors();
            $this->redirect = route('maintenance.work-orders.parts.stocks.add', array(
                $workOrder_id, $inventory_id, $stock_id
            ));
        }
        
        return $this->response();
    }
    
    public function postDestroy($workOrder_id, $inventory_id, $stock_id){
        $workOrder = $this->workOrder->find($workOrder_id);
        $item = $this->inventory->find($inventory_id);
        $stock = $this->inventoryStock->find($stock_id);
        
        $record = $workOrder->parts->find($stock->id);
        
        $data = array(
            'reason' => sprintf('Put back from <a href="%s">Work Order</a>', route('maintenance.work-orders.show', array($workOrder->id))),
            'quantity' => $record->pivot->quantity
        );
        
        $this->inventoryStock->setInput($data)->put($stock->id);
        
        $workOrder->parts()->detach($stock->id);
        
        $this->message = 'Successfully removed '.$item->name;
        $this->messageType = 'success';
        $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));
        
        return $this->response();
    }
    
}