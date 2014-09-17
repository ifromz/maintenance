<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Http\Requests\AssetManualRequest;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class AssetManualController extends BaseController {
        
        public function __construct(AssetManualRequest $assetManual){
            $this->assetManual = $assetManual;
        }
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($asset_id){
            return $this->assetManual->index($asset_id);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($asset_id){
            return $this->assetManual->create($asset_id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($asset_id){
            return $this->assetManual->store($asset_id, Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($asset_id, $attachment_id){
            return $this->assetManual->show($asset_id, $attachment_id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($asset_id, $attachment_id){
            return $this->assetManual->edit($asset_id, $attachment_id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
            return $this->assetManual->update($id, Input::all());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($asset_id, $attachment_id){
            return $this->assetManual->destroy($asset_id, $attachment_id);
	}


}
