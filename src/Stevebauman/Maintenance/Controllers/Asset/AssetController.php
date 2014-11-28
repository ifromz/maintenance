<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Services\AssetEventService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Validators\AssetValidator;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AssetController extends AbstractController {
	
	public function __construct(
                AssetService $asset, 
                AssetValidator $assetValidator, 
                AssetEventService $event,
                WorkOrderService $workOrder
                ){
		$this->asset = $asset;
                $this->event = $event;
                $this->workOrder = $workOrder;
		$this->assetValidator = $assetValidator;
	}
	
	/**
	 * Show the index of all assets
	 *
	 * @return View
	 */
	public function index(){
		$assets = $this->asset->setInput($this->inputAll())->getByPageWithFilter();
		
		return view('maintenance::assets.index', array(
                    'title' => 'All Assets', 
                    'assets' => $assets
                ));
	}
	
	/**
	 * Show the create form for assets
	 *
	 * @return View
	 */
	public function create(){
            return view('maintenance::assets.create', array(
                'title' => 'Create an Asset'
            ));
	}
	
	
	/**
	 * Process and store the creation of the asset
	 *
	 * @return $this->response (object or json response)
	 */
	public function store(){
		
		if($this->assetValidator->passes()){
                    
                    $record = $this->asset->setInput($this->inputAll())->create();
                    
                    if($record){

                        $this->redirect = route('maintenance.assets.index');
                        $this->message = sprintf('Successfully created asset: %s', link_to_route('maintenance.assets.show', 'Show', array($record->id)));
                        $this->messageType = 'success';

                    } else {
                        
                        $this->redirect = route('maintenance.asset.create');
                        $this->message = 'There was an error trying to create an asset. Please try again';
                        $this->messageType = 'danger';
                        
                    }
                    
		} else{
                    $this->redirect = route('maintenance.assets.create');
                    $this->errors = $this->assetValidator->getErrors();
		}
		
		return $this->response();
	}
	
	/**
	 * Show the asset
	 *
	 * @return View
	 */
	public function show($id) {
                $asset = $this->asset->find($id);
                
                $data = $this->inputAll();
                $data['assets'] = array($asset->id);
                
                $workOrders = $this->workOrder->setInput($data)->getByPageWithFilter();
                
                return view('maintenance::assets.show',array(
                    'title' =>'Viewing Asset: '.$asset->name,
                    'asset' => $asset,
                    'workOrders' => $workOrders
                ));

	}
	
	/**
	 * Show the edit form
	 *
	 * @return View
	 */
	public function edit($id){
            $asset = $this->asset->find($id);

            return view('maintenance::assets.edit', array(
                    'title' => 'Editing asset: '.$asset->name,
                    'asset' => $asset,
            ));
	}
	
	/**
	 * Process the edit form and update the record
	 *
	 * @return $this->response (object or json response)
	 */
	public function update($id){

            if($this->assetValidator->passes()){

                $record = $this->asset->setInput($this->inputAll())->update($id);

                $this->redirect = route('maintenance.assets.show', array($record->id));
                $this->message = sprintf('Successfully edited asset: %s', link_to_route('maintenance.assets.show', 'Show', array($record->id)));
                $this->messageType = 'success';

            } else{
                $this->redirect = route('maintenance.assets.edit', array($id));
                $this->errors = $this->assetValidator->getErrors();
            }

            return $this->response();
	}
	
	/**
	 * Delete an asset record
	 *
	 * @return $this->response (object or json response)
	 */
	public function destroy($id){
            $this->asset->destroy($id);

            $this->redirect = route('maintenance.assets.index');
            $this->message = 'Successfully deleted asset';
            $this->messageType = 'success';

            return $this->response();
	}
	
}