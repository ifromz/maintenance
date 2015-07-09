<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Models\Attachment;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class ImageController extends BaseController
{
    /**
     * @var AssetRepository
     */
    protected $asset;

    /**
     * Constructor.
     *
     * @param AssetRepository $asset
     */
    public function __construct(AssetRepository $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Returns a new grid instance of all available asset images.
     *
     * @param int|string $id
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($id)
    {
        $columns = [
            'attachments.id',
            'attachments.user_id',
            'attachments.name',
            'attachments.file_name',
            'attachments.file_path',
            'attachments.created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 10,
        ];

        $transformer = function(Attachment $attachment) use ($id)
        {
            return [
                'id' => $attachment->id,
                'user' => ($attachment->user ? $attachment->user->full_name : '<em>System</em>'),
                'name' => $attachment->name,
                'icon' => $attachment->icon,
                'file_name' => $attachment->file_name,
                'created_at' => $attachment->created_at,
                'view_url' => route('maintenance.assets.images.show', [$id, $attachment->id]),
            ];
        };

        return $this->asset->gridImages($id, $columns, $settings, $transformer);
    }
}
