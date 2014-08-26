<?php namespace Stevebauman\Maintenance\Requests;

use JildertMiedema\LaravelPlupload\Facades\Plupload;
use Dmyers\Storage\Storage;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use ErrorException;

abstract class AbstractUploadRequest extends AbstractRequest {
	
	protected $storagePath;
	
	protected $uploadPath;
	
	protected $responseView;
	
	public function __construct(){
            $this->uploadPath = Config::get('maintenance::site.paths.temp');
            $this->storagePath = Config::get('maintenance::site.paths.base');
	}
	
	public function upload(){
            //Init Plupload receive
            return Plupload::receive('file', function ($file){
                $url = Storage::url($this->uploadPath. $file->getClientOriginalName());
                $filePath = $this->uploadPath. $file->getClientOriginalName();
                      
                if($file->move($this->storagePath.$this->uploadPath, $file->getClientOriginalName())){
                    //Return ajax response with file information on successful upload
                    return array('url'=>$url, 'name'=>$file->getClientOriginalName(), 'html'=>View::make($this->responseView)
                        ->with('file', $file)
                        ->with('file_path', $filePath)
                        ->with('file_folder', $this->uploadPath)
                        ->render());
                } else{
                    $this->messageType = 'danger';
                    $this->message = 'There was an error uploading your attachment';
                    
                    return $this->response();
                }
            });
	}
	
	public function destroy(){
            $filePath = Input::get('file_path');
            $fileFolder = Input::get('file_folder');
            
            if(Request::ajax()){
                if(Storage::delete($filePath)){
                    $folder = $this->storagePath.$fileFolder;
                    
                    try{
                        rmdir($folder);
                    } catch(ErrorException $e){
                        //Catch folder is not empty exception
                    }
                    
                    $this->messageType = 'success';
                    $this->message = 'Successfully deleted attachment';
                    
                    return $this->response();
                } else{
                    $this->messageType = 'danger';
                    $this->message = 'Error deleting attachment';
                    
                    return $this->response();
                }
            }
	}
	
}