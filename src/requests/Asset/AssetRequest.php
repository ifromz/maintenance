<?php namespace Stevebauman\Maintenance\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Stevebauman\Maintenance\Services\EventService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Validators\AssetValidator;
use Stevebauman\Maintenance\Requests\AbstractRequest;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;

class AssetRequest extends AbstractRequest {
	
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
		
		return View::make('maintenance::assets.index', 
			array(
				'title' => 'All Assets', 
				'assets' => $assets
			)
		);
	}
	
	/**
	 * Show the create form for assets
	 *
	 * @return View
	 */
	public function create(){
		return View::make('maintenance::assets.create', array('title' => 'Create an Asset'));
	}
	
	
	/**
	 * Process and store the creation of the asset
	 *
	 * @return $this->response (object or json response)
	 */
	public function store($data){
		
		$validator = new $this->assetValidator;
		
		if($validator->passes()){
			
			if($record = $this->asset->create($data)){
				
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
		try{
			$asset = $this->asset->with(array('workOrders'))->find($id);
 
			return View::make('maintenance::assets.show',
				array(
					'title' =>'Viewing Asset: '.$asset->name,
					'asset' => $asset
				)
			);
			
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}
	
	/**
	 * Show the edit form
	 *
	 * @return View
	 */
	public function edit($id){
		try{
			$asset = $this->asset->find($id);
			
			return View::make('maintenance::assets.edit', 
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
	public function update($id, $data){
		$validator = new $this->assetValidator;
		
		if($validator->passes()){
			try{
				$record = $this->asset->update($id, $data);
				
				$this->redirect = route('maintenance.assets.show', array($record->id));
				$this->message = sprintf('Successfully edited asset: %s', link_to_route('maintenance.assets.show', 'Show', array($record->id)));
				$this->messageType = 'success';

			} catch(RecordNotFoundException $e){
				return $this->assetNotFound();
			}
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
		try{
			$this->asset->destroy($id);
			
			$this->redirect = route('maintenance.assets.index');
			$this->message = 'Successfully deleted asset';
			$this->messageType = 'success';
			
			return $this->response();
		} catch(RecordNotFoundException $e){
			$this->assetNotFound();
		}
	}
	
	/**
	 * Return user to asset index and show an error messsage
	 *
	 * @return $this->response (object or json response)
	 */
	public function assetNotFound(){
		$this->redirect = route('maintenance.assets.index');
		$this->message = 'Cannot find asset; It either does not exist, or has been deleted.';
		$this->messageType = 'danger';
		
		return $this->response();
	}
	
}