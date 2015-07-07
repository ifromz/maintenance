<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Illuminate\Filesystem\Filesystem;
use Stevebauman\Maintenance\Validators\DocumentValidator;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Services\Asset\ManualService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Http\Controllers\AbstractUploadController;

/**
 * Class ManualController.
 */
class ManualController extends AbstractUploadController
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
     * @var DocumentValidator
     */
    protected $documentValidator;

    /**
     * @var AttachmentService
     */
    protected $attachment;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * {@inheritDoc}
     */
    protected $fileStorageLocation = 'assets/manuals/';

    /**
     * Constructor.
     *
     * @param AssetService      $asset
     * @param ManualService     $assetManual
     * @param DocumentValidator $documentValidator
     * @param AttachmentService $attachment
     * @param Filesystem        $filesystem
     */
    public function __construct(
        AssetService $asset,
        ManualService $assetManual,
        DocumentValidator $documentValidator,
        AttachmentService $attachment,
        Filesystem $filesystem
    ) {
        $this->asset = $asset;
        $this->assetManual = $assetManual;
        $this->documentValidator = $documentValidator;
        $this->attachment = $attachment;
        $this->filesystem = $filesystem;
    }

    /**
     * Displays all of the specified asset manuals.
     *
     * @param $assetId
     *
     * @return mixed
     */
    public function index($assetId)
    {
        $asset = $this->asset->find($assetId);

        return view('maintenance::assets.manuals.index', [
                    'title' => 'Viewing Asset Manuals for: '.$asset->name,
                    'asset' => $asset,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $assetId
     *
     * @return mixed
     */
    public function create($assetId)
    {
        $asset = $this->asset->find($assetId);

        return view('maintenance::assets.manuals.create', [
                    'title' => 'Upload Asset Manuals for: '.$asset->name,
                    'asset' => $asset,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $assetId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($assetId)
    {
        if ($this->documentValidator->passes()) {
            $files = $this->uploadFiles();

            $data = $this->inputAll();
            $data['asset_id'] = $assetId;
            $data['file_path'] = $this->getUploadDirectory();
            $data['files'] = $files;

            if ($this->assetManual->setInput($data)->create()) {
                $this->redirect = route('maintenance.assets.manuals.index', [$assetId]);
                $this->message = 'Successfully added manual(s)';
                $this->messageType = 'success';
            } else {
                $this->redirect = route('maintenance.assets.manuals.create', [$assetId]);
                $this->message = 'There was an error adding manuals to the asset, please try again';
                $this->messageType = 'danger';
            }
        } else {
            $this->redirect = route('maintenance.assets.manuals.create', [$assetId]);
            $this->errors = $this->documentValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $assetId
     * @param $attachmentId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($assetId, $attachmentId)
    {
        $asset = $this->asset->find($assetId);
        $attachment = $this->attachment->find($attachmentId);

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
