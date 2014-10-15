<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\AbstractUploadController;

/**
 * Processes the upload from PLUpload and store's it inside a temporary location.
 * A json view response is defineable here you can customize the layout of the dynamic uploads. 
 *
 */
class AssetManualUploadController extends AbstractUploadController {
	
	public function __construct(){
            parent::__construct();
            
            $this->responseView = 'maintenance::partials.asset-upload';
	}
	
}