<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Dmyers\Storage\Storage;
use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Http\Controllers\AbstractController;

class AssetManualController extends AbstractController {
        
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
	public function store($asset_id, $data){

            $asset = $this->asset->find($asset_id);

            //Check if any files have been uploaded
            if(array_key_exists('files', $data)){
                //For each file, create the attachment record, and sync asset image pivot table
                foreach($data['files'] as $file){
                    $attributes = explode('|', $file);

                    $fileName = $attributes[0];
                    $fileOriginalName = $attributes[1];

                    //Ex. files/assets/images/1/example.png
                    $movedFilePath = Config::get('maintenance::site.paths.assets.manuals').sprintf('%s/', $asset->id);

                    //Move the file
                    Storage::move(Config::get('maintenance::site.paths.temp').$fileName, $movedFilePath.$fileName);

                    //Data to insert into DB
                    $insert = array(
                        'name' => $fileOriginalName,
                        'file_name' => $fileName,
                        'file_path' => $movedFilePath,
                    );

                    if($record = $this->attachment->create($insert)){
                        $asset->manuals()->attach($record);

                        $this->redirect = route('maintenance.assets.manuals.index', array($asset->id));
                        $this->message = 'Successfully added manual(s)';
                        $this->messageType = 'success';

                    } else{
                        $this->redirect = route('maintenance.assets.manuals.create', array($asset->id));
                        $this->message = 'There was an error adding manuals to the asset, please try again';
                        $this->messageType = 'danger';

                    }

                }
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

                $this->redirect = route('maintenance.assets.manuals.index', array($asset->id));
                $this->message = 'Successfully deleted manual';
                $this->messageType = 'success';

            } else{
                $this->redirect = route('maintenance.assets.manuals.index', array($asset->id));
                $this->message = 'There was an error deleting the manual file, please try again';
                $this->messageType = 'danger';
            }

            return $this->response();
	}

}
