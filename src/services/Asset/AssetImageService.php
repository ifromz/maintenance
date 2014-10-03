<?php namespace Stevebauman\Maintenance\Services;

use Dmyers\Storage\Storage;
use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Services\AttachmentService;

class AssetImageService extends AbstractModelService {
	
	public function __construct(AssetService $asset, AttachmentService $attachment){
		$this->asset = $asset;
		$this->attachment = $attachment;
	}
	
        
        public function create($asset){
            
            //Check if any files have been uploaded
            if($files = $this->input('files')){
                
                //For each file, create the attachment record, and sync asset image pivot table
                foreach($files as $file){
                    
                    $attributes = explode('|', $file);

                    $fileName = $attributes[0];
                    $fileOriginalName = $attributes[1];

                    //Ex. files/assets/images/1/example.png
                    $movedFilePath = Config::get('maintenance::site.paths.assets.images').sprintf('%s/', $asset->id);

                    //Move the file
                    Storage::move(Config::get('maintenance::site.paths.temp').$fileName, $movedFilePath.$fileName);

                    //Data to insert into DB
                    $insert = array(
                        'name' => $fileOriginalName,
                        'file_name' => $fileName,
                        'file_path' => $movedFilePath,
                    );
                    
                    if($record = $this->attachment->create($insert)){
                        $asset->images()->attach($record);
                    }
                }
                
                // Return record on success
                return $record;
            } else{
                //No Files were detected to be uploaded, return false
                return false;
            }
            
        }
            
}