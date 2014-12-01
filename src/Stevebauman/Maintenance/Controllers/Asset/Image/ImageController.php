<?php 

namespace Stevebauman\Maintenance\Controllers\Asset\Image;

use Dmyers\Storage\Storage;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Services\AssetImageService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Controllers\BaseController;

class ImageController extends BaseController {
	
	public function __construct(AssetService $asset, AssetImageService $assetImage, AttachmentService $attachment){
		$this->asset = $asset;
		$this->assetImage = $assetImage;
                $this->attachment = $attachment;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($asset_id){

            $asset = $this->asset->find($asset_id);

            return $this->view('maintenance::assets.images.index', array(
                'title' => 'Viewing Asset Images for: '.$asset->name,
                'asset' => $asset,
            ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($asset_id){
            $asset = $this->asset->find($asset_id);

            return $this->view('maintenance::assets.images.create', array(
                    'title' => 'Adding Asset Images for: '.$asset->name,
                    'asset' => $asset,
            ));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($asset_id){
            $asset = $this->asset->find($asset_id);
            
            $data = $this->inputAll();
            $data['asset_id'] = $asset->id;
            
            if($this->assetImage->setInput($data)->create()){
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


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($asset_id, $attachment_id){
            $asset = $this->asset->find($asset_id);

            $attachment = $this->attachment->find($attachment_id);

            return $this->view('maintenance::assets.images.show', array(
                'title' => 'Viewing Asset Image',
                'asset' => $asset,
                'image' => $attachment,
            ));
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

            $asset = $this->asset->find($asset_id);
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
                    
	}

}
