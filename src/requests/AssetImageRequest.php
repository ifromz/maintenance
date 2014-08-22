<?php namespace Stevebauman\Maintenance\Requests;

use View;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Services\AssetImageService;
use Stevebauman\Maintenance\Validators\AssetImageValidator;
use Stevebauman\Maintenance\Requests\AbstractRequest;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;


class AssetImageRequest extends AbstractRequest {
	
	public function __construct(AssetService $asset, AssetImageService $assetImage){
		$this->asset = $asset;
		$this->assetImage = $assetImage;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($asset_id){
		try{
			$asset = $this->asset->find($asset_id);
			
			return View::make('maintenance::assets.images.index', 
				array(
					'title' => 'Viewing Asset Images for: '.$asset->name,
					'asset' => $asset,
				)
			);
			
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($asset_id){
		try{
			$asset = $this->asset->find($asset_id);
			
			return View::make('maintenance::assets.images.create', 
				array(
					'title' => 'Adding Asset Images for: '.$asset->name,
					'asset' => $asset,
				)
			);
			
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($asset_id, $data){
		try{
			
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
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
