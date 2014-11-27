<?php 

namespace Stevebauman\Maintenance\Controllers;

use Dmyers\Storage\Storage;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Services\AssetManualService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class AssetManualController extends AbstractController {
        
        public function __construct(AssetService $asset, AssetManualService $assetManual, AttachmentService $attachment){
            $this->asset = $asset;
            $this->assetManual = $assetManual;
            $this->attachment = $attachment;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($asset_id){
            $asset = $this->asset->find($asset_id);

            return $this->view('maintenance::assets.manuals.index', array(
                    'title' => 'Viewing Asset Manuals for: '.$asset->name,
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

            return $this->view('maintenance::assets.manuals.create', array(
                    'title' => 'Upload Asset Manuals for: '.$asset->name,
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

            if($this->assetManual->setInput($data)->create()){
                $this->redirect = route('maintenance.assets.manuals.index', array($asset->id));
                $this->message = 'Successfully added manual(s)';
                $this->messageType = 'success';

            } else{
                $this->redirect = route('maintenance.assets.manuals.create', array($asset->id));
                $this->message = 'There was an error adding manuals to the asset, please try again';
                $this->messageType = 'danger';

            }

            return $this->response();
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

                $this->redirect = routeBack('maintenance.assets.manuals.index', array($asset->id));
                $this->message = 'Successfully deleted manual';
                $this->messageType = 'success';

            } else{
                $this->redirect = routeBack('maintenance.assets.manuals.index', array($asset->id));
                $this->message = 'There was an error deleting the manual file, please try again';
                $this->messageType = 'danger';
            }

            return $this->response();
	}

}
