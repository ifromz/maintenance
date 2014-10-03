<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Services\EventService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Validators\AssetValidator;
use Stevebauman\Maintenance\Http\Controllers\AbstractController;

class AssetController extends AbstractController {
	
	public function __construct(AssetService $asset, AssetValidator $assetValidator, EventService $event){
		$this->asset = $asset;
                $this->event = $event;
		$this->assetValidator = $assetValidator;
	}
	
	/**
	 * Show the index of all assets
	 *
	 * @return View
	 */
	public function index(){
		$assets = $this->asset->getByPage();
		
		return $this->view('maintenance::assets.index', array(
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
            return $this->view('maintenance::assets.create', array(
                'title' => 'Create an Asset'
            ));
	}
	
	
	/**
	 * Process and store the creation of the asset
	 *
	 * @return $this->response (object or json response)
	 */
	public function store(){
		
		$validator = new $this->assetValidator;
		
		if($validator->passes()){
			
			if($record = $this->asset->create()){
				
                            $this->redirect = route('maintenance.assets.index');
                            $this->message = sprintf('Successfully created asset: %s', link_to_route('maintenance.assets.show', 'Show', array($record->id)));
                            $this->messageType = 'success';
				
			}
		} else{
			$this->redirect = route('maintenance.assets.create');
			$this->errors = $validator->getErrors();
		}
		
		return $this->response();
	}
	
	/**
	 * Show the asset
	 *
	 * @return View
	 */
	public function show($id){
                $asset = $this->asset->find($id);

                return $this->view('maintenance::assets.show',array(
                    'title' =>'Viewing Asset: '.$asset->name,
                    'asset' => $asset
                ));

	}
	
	/**
	 * Show the edit form
	 *
	 * @return View
	 */
	public function edit($id){
		try{
			$asset = $this->asset->find($id);
			
			return $this->view('maintenance::assets.edit', 
				array(
					'title' => 'Editing asset: '.$asset->name,
					'asset' => $asset,
				)
			);
			
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}
	
	/**
	 * Process the edit form and update the record
	 *
	 * @return $this->response (object or json response)
	 */
	public function update($id){
            $validator = new $this->assetValidator;

            if($validator->passes()){

                $record = $this->asset->update($id);

                $this->redirect = route('maintenance.assets.show', array($record->id));
                $this->message = sprintf('Successfully edited asset: %s', link_to_route('maintenance.assets.show', 'Show', array($record->id)));
                $this->messageType = 'success';

            } else{
                $this->redirect = route('maintenance.assets.edit', array($id));
                $this->errors = $validator->getErrors();
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