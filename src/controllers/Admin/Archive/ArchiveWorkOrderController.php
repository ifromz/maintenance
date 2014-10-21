<?php

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class ArchiveAssetController extends AbstractController {
    
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }
    
    public function index()
    {
        $assets = $this->workOrder->getByPageWithFilter($archived = true);
        
        return $this->view('maintenance::admin.archive.assets.index', array(
            'title' => 'Archived Assets',
            'assets'=> $assets
        ));
    }
    
    public function show($id)
    {
        $asset = $this->asset->findArchived($id);
        
        return $this->view('maintenance::admin.archive.assets.show', array(
            'title' => 'Viewing Archived Asset: '.$asset->name,
            'asset' => $asset
        ));
    }
    
    public function destroy($id)
    {
        $this->asset->destroyArchived($id);
       
        $this->message = 'Successfully deleted asset';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.admin.archive.assets.index');
        
        return $this->response();
    }
    
    public function restore($id)
    {
        if($this->asset->restoreArchived($id)){
            $this->message = sprintf('Successfully restored asset. %s', link_to_route('maintenance.assets.show', 'Show', $id));
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.assets.index');
        } else{
            $this->message = 'There was an error trying to restore this asset, please try again';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.assets.index');
        }
        
        return $this->response();
    }
    
}