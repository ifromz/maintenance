<?php namespace Stevebauman\Maintenance\Requests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Dmyers\Storage\Storage;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Requests\AbstractRequest;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;

class AssetImageRequest extends AbstractRequest {
	
	public function __construct(AssetService $asset, AttachmentService $attachment){
		$this->asset = $asset;
		$this->attachment = $attachment;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($asset_id){
		try{
			$asset = $this->asset->find($asset_id);
			
			return View::make('maintenance::assets.images.index', 
				array(
					'title' => 'Viewing Asset Images for: '.$asset->name,
					'asset' => $asset,
				)
			);
			
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($asset_id){
		try{
			$asset = $this->asset->find($asset_id);
			
			return View::make('maintenance::assets.images.create', 
				array(
					'title' => 'Adding Asset Images for: '.$asset->name,
					'asset' => $asset,
				)
			);
			
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($asset_id, $data){
		try{
                   
                    $asset = $this->asset->find($asset_id);

                    //Check if any files have been uploaded
                    if(array_key_exists('files', $data)){
                        //For each file, create the attachment record, and sync asset image pivot table
                        foreach($data['files'] as $file){
                            $attributes = explode('|', $file);
                            
                            $fileName = $attributes[0];
                            $filePath = $attributes[1];
                            
                            //Ex. files/assets/images/1/example.png
                            $movedFilePath = Config::get('maintenance::site.paths.assets.images').sprintf('%s/', $asset->id);
                            
                            //Move the file
                            Storage::move($filePath.$fileName, $movedFilePath.$fileName);
                            
                            //Data to insert into DB
                            $insert = array(
                                'file_name' => $fileName,
                                'file_path' => $movedFilePath,
                            );
                            
                            if($record = $this->attachment->create($insert)){
                                $asset->images()->attach($record);
                                
                                $this->redirect = route('maintenance.assets.images.index', array($asset->id));
                                $this->message = 'Successfully added images';
                                $this->messageType = 'success';
                                
                            } else{
                                $this->redirect = route('maintenance.assets.images.create', array($asset->id));
                                $this->message = 'There was an error adding images to the asset, please try again';
                                $this->messageType = 'danger';
                                
                            }
                            return $this->response();
                        }
                    }
                    
		} catch(RecordNotFoundException $e){
			return $this->assetNotFound();
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($asset_id, $attachment_id){
            try{
                $asset = $this->asset->find($asset_id);
                
                try{
                    $attachment = $this->attachment->find($attachment_id);
                    
                    return View::make('maintenance::assets.images.show', 
                            array(
                                    'title' => 'Viewing Asset Image',
                                    'asset' => $asset,
                                    'image' => $attachment,
                            )
                    );
                    
                } catch (RecordNotFoundException $e) {
                    return $this->assetImageNotFound($asset->id);
                }
            } catch(RecordNotFoundException $e){
                return $this->assetNotFound();
            }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($asset_id, $attachment_id){
             try{
                $asset = $this->asset->find($asset_id);
                
                try{
                    $attachment = $this->attachment->find($attachment_id);
                    
                    if(Storage::delete($attachment->file_path.$attachment->file_name)){
                        $attachment->delete();
                        
                        $this->redirect = route('maintenance.assets.images.index', array($asset->id));
                        $this->message = 'Successfully deleted image';
                        $this->messageType = 'success';
                        
                    } else{
                        $this->redirect = route('maintenance.assets.images.show', array($asset->id, $attachment->id));
                        $this->message = 'There was an error deleting the image file, please try again';
                        $this->messageType = 'danger';
                    }
                    
                    return $this->response();
                    
                } catch (RecordNotFoundException $e) {
                    return $this->assetImageNotFound($asset->id);
                }
            } catch(RecordNotFoundException $e){
                return $this->assetNotFound();
            } 
	}
        
        /**
	 * Return user to asset index and show an error messsage
	 *
	 * @return $this->response (object or json response)
	 */
	public function assetImageNotFound($asset_id){
		$this->redirect = route('maintenance.assets.show', array($asset_id));
		$this->message = 'Cannot find asset image; It either does not exist, or has been deleted.';
		$this->messageType = 'danger';
		
		return $this->response();
	}
	
	/**
	 * Return user to asset index and show an error messsage
	 *
	 * @return $this->response (object or json response)
	 */
	public function assetNotFound(){
		$this->redirect = route('maintenance.assets.index');
		$this->message = 'Cannot find asset; It either does not exist, or has been deleted.';
		$this->messageType = 'danger';
		
		return $this->response();
	}


}
