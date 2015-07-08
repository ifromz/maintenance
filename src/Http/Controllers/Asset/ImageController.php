<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Stevebauman\Maintenance\Http\Requests\AttachmentUpdateRequest;
use Stevebauman\Maintenance\Http\Requests\AttachmentRequest;
use Stevebauman\Maintenance\Repositories\Asset\ImageRepository;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class ImageController extends BaseController
{
    /**
     * @var AssetRepository
     */
    protected $asset;

    /**
     * @var ImageRepository
     */
    protected $image;

    /**
     * Constructor.
     *
     * @param AssetRepository $asset
     * @param ImageRepository $image
     */
    public function __construct(AssetRepository $asset, ImageRepository $image)
    {
        $this->asset = $asset;
        $this->image = $image;
    }

    /**
     * Displays all images attached to the specified asset.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $asset = $this->asset->find($id);

        return view('maintenance::assets.images.index', compact('asset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int|string $assetId
     *
     * @return \Illuminate\View\View
     */
    public function create($assetId)
    {
        $asset = $this->asset->find($assetId);

        return view('maintenance::assets.images.create', compact('asset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttachmentRequest $request
     * @param int|string        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AttachmentRequest $request, $id)
    {
        $asset = $this->asset->find($id);

        $attachments = $this->image->upload($request, $asset, $asset->images());

        if($attachments) {
            $message = 'Successfully uploaded files.';

            return redirect()->route('maintenance.assets.images.index', [$asset->id])->withSuccess($message);
        } else {
            $message = 'There was an issue uploading the files you selected. Please try again.';

            return redirect()->route('maintenance.assets.images.create', [$id])->withErrors($message);
        }
    }

    /**
     * Displays the asset image.
     *
     * @param int|string $id
     * @param int|string $imageId
     *
     * @return \Illuminate\View\View
     */
    public function show($id, $imageId)
    {
        $asset = $this->asset->find($id);

        $image = $asset->images()->find($imageId);

        if($image) {
            return view('maintenance::assets.images.show', compact('asset', 'image'));
        }

        abort(404);
    }

    /**
     * Displays the form for editing an uploaded image.
     *
     * @param int|string $id
     * @param int|string $imageId
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, $imageId)
    {
        $asset = $this->asset->find($id);

        $image = $asset->images()->find($imageId);

        if($image) {
            return view('maintenance::work-orders.attachments.edit', compact('asset', 'image'));
        }

        abort(404);
    }

    /**
     * Updates the specified ticket upload.
     *
     * @param AttachmentUpdateRequest $request
     * @param int|string              $id
     * @param int|string              $imageId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AttachmentUpdateRequest $request, $id, $imageId)
    {
        $asset = $this->asset->find($id);

        $attachment = $this->image->update($request, $asset->images(), $imageId);

        if($attachment) {
            $message = 'Successfully updated attachment.';

            return redirect()->route('maintenance.assets.images.show', [$asset->id, $attachment->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this attachment. Please try again.';

            return redirect()->route('maintenance.assets.images.show', [$id, $imageId])->withErrors($message);
        }
    }

    /**
     * Processes deleting an attachment record and the file itself.
     *
     * @param int|string $id
     * @param int|string $imageId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $imageId)
    {
        $asset = $this->asset->find($id);

        $image = $asset->images()->find($imageId);

        if($image && $image->delete()) {
            $message = 'Successfully deleted attachment.';

            return redirect()->route('maintenance.work-orders.attachments.index', [$image->id])->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this attachment. Please try again.';

            return redirect()->route('maintenance.work-orders.attachments.show', [$image->id, $image->id])->withErrors($message);
        }
    }

    /**
     * Prompts the user to download the specified uploaded file.
     *
     * @param int|string $id
     * @param int|string $imageId
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id, $imageId)
    {
        $asset = $this->asset->find($id);

        $attachment = $asset->images()->find($imageId);

        if($attachment) {
            return response()->download($attachment->download_path);
        }

        abort(404);
    }
}
