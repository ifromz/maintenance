<?php namespace Stevebauman\Maintenance\Requests;

use Stevebauman\Maintenance\Requests\AbstractUploadRequest;

class AssetImageUploadRequest extends AbstractUploadRequest {
	
	public function __construct(){
            parent::__construct();
			
            $this->responseView = 'maintenance::partials.upload';
	}
	
}