<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Http\Controllers\BaseController;
use Stevebauman\Maintenance\Http\Requests\AssetManualUploadRequest;

class AssetManualUploadController extends BaseController {
	
	public function __construct(AssetManualUploadRequest $assetManual){
		$this->assetManual = $assetManual;
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		return $this->assetManual->upload();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(){
		return $this->assetManual->destroy();
	}


}
