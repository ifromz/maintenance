<?php

namespace Stevebauman\Maintenance\Controllers\Asset\Image;

use Illuminate\Filesystem\Filesystem;
use Stevebauman\Maintenance\Validators\ImageValidator;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\Asset\ImageService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Controllers\AbstractUploadController;

/**
 * Class ImageController
 */
class ImageController extends AbstractUploadController
{
    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * @var ImageService
     */
    protected $assetImage;

    /**
     * @var ImageValidator
     */
    protected $imageValidator;

    /**
     * @var AttachmentService
     */
    protected $attachment;

    /**
     * @var FileSystem
     */
    protected $file;

    /**
     * {inheritDoc}
     *
     * @var string
     */
    protected $fileStorageLocation = 'assets/images/';

    /**
     * Constructor.
     *
     * @param AssetService      $asset
     * @param ImageService      $assetImage
     * @param ImageValidator    $imageValidator
     * @param AttachmentService $attachment
     * @param Filesystem        $filesystem
     */
    public function __construct(
        AssetService $asset,
        ImageService $assetImage,
        ImageValidator $imageValidator,
        AttachmentService $attachment,
        Filesystem $filesystem
    ) {
        $this->asset = $asset;
        $this->assetImage = $assetImage;
        $this->imageValidator = $imageValidator;
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

        return view('maintenance::assets.images.index', [
            'title' => 'Viewing Asset Images for: '.$asset->name,
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

        return view('maintenance::assets.images.create', [
            'title' => 'Adding Asset Images for: '.$asset->name,
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
        if($this->imageValidator->passes()) {
            $files = $this->uploadFiles();

            $data = $this->inputAll();
            $data['asset_id'] = $assetId;
            $data['file_path'] = $this->getUploadDirectory();
            $data['files'] = $files;

            if ($this->assetImage->setInput($data)->create()) {
                $this->redirect = route('maintenance.assets.images.index', [$assetId]);
                $this->message = 'Successfully added images';
                $this->messageType = 'success';
            } else {
                $this->redirect = route('maintenance.assets.images.create', [$assetId]);
                $this->message = 'There was an error adding images to the asset, please try again';
                $this->messageType = 'danger';
            }
        } else {
            $this->redirect = route('maintenance.assets.images.create', [$assetId]);
            $this->errors = $this->imageValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param $asset_id
     * @param $attachment_id
     *
     * @return mixed
     */
    public function show($asset_id, $attachment_id)
    {
        $asset = $this->asset->find($asset_id);

        $attachment = $this->attachment->find($attachment_id);

        return view('maintenance::assets.images.show', [
            'title' => 'Viewing Asset Image',
            'asset' => $asset,
            'image' => $attachment,
        ]);
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

            $this->redirect = route('maintenance.assets.images.index', [$asset->id]);
            $this->message = 'Successfully deleted image';
            $this->messageType = 'success';
        } else {
            $this->redirect = route('maintenance.assets.images.show', [$asset->id, $attachment->id]);
            $this->message = 'There was an error deleting the image file, please try again';
            $this->messageType = 'danger';
        }

        return $this->response();
    }
}
