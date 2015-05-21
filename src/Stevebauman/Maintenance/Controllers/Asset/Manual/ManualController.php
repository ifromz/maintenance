<?php

namespace Stevebauman\Maintenance\Controllers\Asset\Manual;

use Illuminate\Filesystem\Filesystem;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Services\Asset\ManualService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Controllers\BaseController;

class ManualController extends BaseController
{
    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * @var ManualService
     */
    protected $assetManual;

    /**
     * @var AttachmentService
     */
    protected $attachment;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param AssetService      $asset
     * @param ManualService     $assetManual
     * @param AttachmentService $attachment
     */
    public function __construct(
        AssetService $asset,
        ManualService $assetManual,
        AttachmentService $attachment,
        Filesystem $filesystem
    ) {
        $this->asset = $asset;
        $this->assetManual = $assetManual;
        $this->attachment = $attachment;
        $this->filesystem = $filesystem;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $asset_id
     *
     * @return mixed
     */
    public function index($asset_id)
    {
        $asset = $this->asset->find($asset_id);

        return view('maintenance::assets.manuals.index', [
                    'title' => 'Viewing Asset Manuals for: '.$asset->name,
                    'asset' => $asset,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $asset_id
     *
     * @return mixed
     */
    public function create($asset_id)
    {
        $asset = $this->asset->find($asset_id);

        return view('maintenance::assets.manuals.create', [
                    'title' => 'Upload Asset Manuals for: '.$asset->name,
                    'asset' => $asset,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $asset_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($asset_id)
    {
        $asset = $this->asset->find($asset_id);

        $data = $this->inputAll();
        $data['asset_id'] = $asset->id;

        if ($this->assetManual->setInput($data)->create()) {
            $this->redirect = route('maintenance.assets.manuals.index', [$asset->id]);
            $this->message = 'Successfully added manual(s)';
            $this->messageType = 'success';
        } else {
            $this->redirect = route('maintenance.assets.manuals.create', [$asset->id]);
            $this->message = 'There was an error adding manuals to the asset, please try again';
            $this->messageType = 'danger';
        }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $asset_id
     * @param $attachment_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($asset_id, $attachment_id)
    {
        $asset = $this->asset->find($asset_id);
        $attachment = $this->attachment->find($attachment_id);

        if ($this->filesystem->delete($attachment->file_path)) {
            $attachment->delete();

            $this->redirect = routeBack('maintenance.assets.manuals.index', [$asset->id]);
            $this->message = 'Successfully deleted manual';
            $this->messageType = 'success';
        } else {
            $this->redirect = routeBack('maintenance.assets.manuals.index', [$asset->id]);
            $this->message = 'There was an error deleting the manual file, please try again';
            $this->messageType = 'danger';
        }

        return $this->response();
    }
}
