<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\BaseUploadController;

/**
 * Processes the upload from PLUpload and store's it inside a temporary location.
 * A json view response is definable here you can customize the layout of the dynamic uploads. 
 *
 */
class WorkOrderAttachmentUploadController extends BaseUploadController {
	
	public function __construct(){
            parent::__construct();
			
            $this->responseView = 'maintenance::partials.work-order-upload';
	}
	
}