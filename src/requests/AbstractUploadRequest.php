<?php namespace Stevebauman\Maintenance\Requests;

use Config;
use Plupload;
use Storage;

abstract class AbstractUploadRequest extends AbstractRequest {
	
	protected $storagePath;
	
	protected $uploadPath;
	
	protected $responseView;
	
	public function __construct(){
		$this->storagePath = Config::get('maintenance::site.path.storage');
	}
	
	public function upload(){
		 return Plupload::receive('file', function ($file){
			$url = Storage::url($this->uploadPath. $file->getClientOriginalName());
			$file_path = $this->uploadPath. $file->getClientOriginalName();
			
        	$file->move($this->storagePath . $this->uploadPath, $file->getClientOriginalName());
			
        	return array('url'=>$url, 'name'=>$file->getClientOriginalName(), 'html'=>View::make($this->responseView)
				->with('file', $file)
				->with('file_path', $file_path)
				->with('file_folder', $this->uploadPath)
				->render());
    	});
	}
	
	public function destroyUpload(){
		if(Request::ajax()){
			if(Input::get('file_path')){
				if(Storage::delete(Input::get('file_path'))){
					rmdir(Config::get('maintenance::site.paths.storage').Input::get('file_folder'));
					return Response::json(array('fileDeleted'=>true, 'messageType'=>'success', 'message'=>'Successfully deleted attachment'));
				} else{
					return Response::json(array('fileDeleted'=>false, 'messageType'=>'danger', 'message'=>'Error deleting attachment'));
				}
				
			}
		}
	}
	
}