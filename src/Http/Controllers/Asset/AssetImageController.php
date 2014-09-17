<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Input;
use Stevebauman\Maintenance\Http\Requests\AssetImageRequest;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class AssetImageController extends BaseController {
	
	public function __construct(AssetImageRequest $asset){
		$this->asset = $asset;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($asset_id){
		return $this->asset->index($asset_id);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($asset_id){
		return $this->asset->create($asset_id, Input::all());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($asset_id){
		return $this->asset->store($asset_id, Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($asset_id, $image_id){
            return $this->asset->show($asset_id, $image_id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($asset_id, $attachment_id){
            return $this->asset->destroy($asset_id, $attachment_id);
	}
	


}
