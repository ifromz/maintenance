<?php namespace Stevebauman\Maintenance\Controllers;

use Input;
use Stevebauman\Maintenance\Requests\AssetRequest;
use Stevebauman\Maintenance\Controllers\BaseController;

class AssetController extends BaseController {
	
	public function __construct(AssetRequest $asset){
		$this->asset = $asset;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		return $this->asset->index();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		return $this->asset->create();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		return $this->asset->store(Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		return $this->asset->show($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		return $this->asset->edit($id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		return $this->asset->update($id, Input::all());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		return $this->asset->destroy($id);
	}


}
