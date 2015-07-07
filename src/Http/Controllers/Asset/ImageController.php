<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Illuminate\Filesystem\Filesystem;
use Stevebauman\Maintenance\Validators\ImageValidator;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Services\Asset\ImageService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Http\Controllers\AbstractUploadController;

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
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * {@inheritDoc}
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

        return view('maintenance::assets.images.index', compact('asset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int|string $assetId
     *
     * @return mixed
     */
    public function create($assetId)
    {
        $asset = $this->asset->find($assetId);

        return view('maintenance::assets.images.create', compact('asset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int|string $assetId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($assetId)
    {
        if ($this->imageValidator->passes()) {
            $files = $this->uploadFiles();

            $data = $this->inputAll();
            $data['asset_id'] = $assetId;
            $data['file_path'] = $this->getUploadDirectory();
            $data['files'] = $files;

            if ($this->assetImage->setInput($data)->create()) {
                $this->redirect = route('maintenance.assets.images.index', [$assetId]);
                $this->message = 'Successfully added image(s)';
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
     * Displays the asset image.
     *
     * @param int|string $assetId
     * @param int|string $attachmentId
     *
     * @return mixed
     */
    public function show($assetId, $attachmentId)
    {
        $asset = $this->asset->find($assetId);

        $attachment = $this->attachment->find($attachmentId);

        return view('maintenance::assets.images.show', [
            'title' => 'Viewing Asset Image',
            'asset' => $asset,
            'image' => $attachment,
        ]);
    }

    /**
     * Deletes the specified image from the asset.
     *
     * @param int|string $assetId
     * @param int|string $attachmentId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($assetId, $attachmentId)
    {
        $asset = $this->asset->find($assetId);
        $attachment = $this->attachment->find($attachmentId);

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

    /**
     * Prompts the user to download the specified uploaded file.
     *
     * @param int|string $id
     * @param int|string $attachmentId
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id, $attachmentId)
    {
        $asset = $this->asset->find($id);

        $image = $asset->images()->find($attachmentId);

        if($image) {
            return response()->download($image->file_path);
        } else {
            abort(404);
        }
    }
}
