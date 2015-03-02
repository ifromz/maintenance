<?php 

namespace Stevebauman\Maintenance\Controllers\Asset\Image;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\StorageService;
use Stevebauman\Maintenance\Controllers\BaseUploadController;

/**
 * Processes the upload from PLUpload and store's it inside a temporary location.
 * A json view response is definable here you can customize the layout of the dynamic uploads. 
 *
 */
class UploadController extends BaseUploadController
{
    /**
     * @param ConfigService $config
     * @param StorageService $storage
     */
	public function __construct(ConfigService $config, StorageService $storage)
    {
        parent::__construct($config, $storage);

        $this->responseView = 'maintenance::partials.asset-upload';
	}
	
}