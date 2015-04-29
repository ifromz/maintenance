<?php

namespace Stevebauman\Maintenance\Controllers\Admin\Archive;

use Stevebauman\Maintenance\Controllers\BaseController;
use Stevebauman\Maintenance\Services\Asset\AssetService;

class AssetController extends BaseController
{
    /**
     * Constructor.
     *
     * @param AssetService $asset
     */
    public function __construct(AssetService $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Displays the archived assets.
     *
     * @return mixed
     */
    public function index()
    {
        $assets = $this->asset->setInput($this->inputAll())->getByPageWithFilter(true);
        
        return view('maintenance::admin.archive.assets.index', [
            'title' => 'Archived Assets',
            'assets'=> $assets
        ]);
    }

    /**
     * Displays the specified archived asset.
     *
     * @param string|int $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $asset = $this->asset->findArchived($id);
        
        return view('maintenance::admin.archive.assets.show', [
            'title' => 'Viewing Archived Asset: '.$asset->name,
            'asset' => $asset
        ]);
    }

    /**
     * Deletes the specified archived asset.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($id)
    {
        $this->asset->destroyArchived($id);
       
        $this->message = 'Successfully deleted asset';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.admin.archive.assets.index');
        
        return $this->response();
    }

    /**
     * Restores the specified archived asset.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function restore($id)
    {
        if($this->asset->restoreArchived($id)){
            $this->message = sprintf('Successfully restored asset. %s', link_to_route('maintenance.assets.show', 'Show', $id));
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.assets.index');
        } else{
            $this->message = 'There was an error trying to restore this asset, please try again';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.assets.index');
        }
        
        return $this->response();
    }
    
}