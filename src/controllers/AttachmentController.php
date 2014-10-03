<?php namespace Stevebauman\Maintenance\Controllers;

use Attachment;
use Request;
use Response;
use Storage;
use Config;
use Stevebauman\Maintenance\Controllers\BaseController;

class AttachmentController extends BaseController {
	
	public function __construct(Attachment $attachment){
		$this->attachment = $attachment;
	}
	
	public function destroy($attachment_id){
		if(Request::ajax()){
			$attachment = $this->attachment->find($attachment_id);
			if($attachment){
				if(Storage::delete($attachment->file_path.$attachment->file_name)){
					rmdir(Config::get('path.storage').$attachment->file_path);
					$attachment->delete();
					
					return Response::json(array(
						'message'=>'Successfully deleted attachment',
						'messageType' => 'success'
					));
				} else{
					return Response::json(array(
						'message'=>'Error deleting attachment',
						'messageType' => 'error'
					));
				}
			}
		}
	}
}