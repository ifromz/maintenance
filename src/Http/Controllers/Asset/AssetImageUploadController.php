<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Http\Controllers\AbstractUploadController;

/**
 * Processes the upload from PLUpload and store's it inside a temporary location.
 * A json view response is defineable here you can customize the layout of the dynamic uploads. 
 *
 */
class AssetImageUploadController extends AbstractUploadController {
	
	public function __construct(){
            parent::__construct();
			
            $this->responseView = 'maintenance::partials.upload';
	}
	
}