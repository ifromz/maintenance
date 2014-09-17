<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\BaseController;
use Stevebauman\Maintenance\Requests\AssetImageUploadRequest;

class AssetImageUploadController extends BaseController {
	
	public function __construct(AssetImageUploadRequest $assetImage){
		$this->assetImage = $assetImage;
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		return $this->assetImage->upload();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(){
		return $this->assetImage->destroy();
	}


}
