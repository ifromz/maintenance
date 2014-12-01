<?php

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Controllers\BaseController;

class ArchiveInventoryController extends BaseController {
    
    public function __construct(InventoryService $inventory)
    {
        $this->inventory = $inventory;
    }
    
    public function index()
    {
        $items = $this->inventory->setInput($this->inputAll())->getByPageWithFilter($archived = true);
        
        return view('maintenance::admin.archive.inventory.index', array(
            'title' => 'Archived Inventory Items',
            'items'=> $items
        ));
    }
    
    public function show($id)
    {
        $item = $this->inventory->findArchived($id);
        
        return view('maintenance::admin.archive.inventory.show', array(
            'title' => 'Viewing Archived Inventory Item: '.$item->name,
            'item' => $item
        ));
    }
    
    public function destroy($id)
    {
        $this->inventory->destroyArchived($id);
       
        $this->message = 'Successfully deleted inventory item';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.admin.archive.inventory.index');
        
        return $this->response();
    }
    
    public function restore($id)
    {
        if($this->inventory->restoreArchived($id)){
            $this->message = sprintf('Successfully restored inventory item. %s', link_to_route('maintenance.inventory.show', 'Show', $id));
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.work-orders.index');
        } else{
            $this->message = 'There was an error trying to restore this inventory item, please try again';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.inventory.index');
        }
        
        return $this->response();
    }
    
}