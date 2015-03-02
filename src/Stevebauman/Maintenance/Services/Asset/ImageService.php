<?php

namespace Stevebauman\Maintenance\Services\Asset;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\StorageService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class ImageService
 * @package Stevebauman\Maintenance\Services\Asset
 */
class ImageService extends BaseModelService
{

    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * @var AttachmentService
     */
    protected $attachment;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var StorageService
     */
    protected $storage;

    /**
     * @var ConfigService
     */
    protected $config;

    public function __construct(
        AssetService $asset,
        AttachmentService $attachment,
        SentryService $sentry,
        StorageService $storage,
        ConfigService $config
    )
    {
        $this->asset = $asset;
        $this->attachment = $attachment;
        $this->sentry = $sentry;
        $this->storage = $storage;
        $this->config = $config;
    }

    /**
     * Creates attachment records, attaches them to the asset images pivot table,
     * and moves the uploaded file into it's stationary position (out of the temp folder)
     *
     * @return mixed
     */
    public function create()
    {
        $this->dbStartTransaction();

        try
        {
            /*
             * Find the asset
             */
            $asset = $this->asset->find($this->getInput('asset_id'));

            /*
             * Check if any files have been uploaded
             */
            $files = $this->getInput('files');

            if ($files)
            {
                $records = array();

                /*
                 * For each file, create the attachment record, and sync asset image pivot table
                 */
                foreach ($files as $file)
                {
                    $attributes = explode('|', $file);

                    $fileName = $attributes[0];
                    $fileOriginalName = $attributes[1];

                    /*
                     * Ex. files/assets/images/1/example.png
                     */
                    $movedFilePath = $this->config->setPrefix('maintenance')->get('site.paths.assets.images') . sprintf('%s/', $asset->id);

                    /*
                     * Move the file
                     */
                    $this->storage->move(
                        $this->config->setPrefix('core-helper')->get('temp-upload-path') . $fileName,
                        $movedFilePath . $fileName
                    );

                    /*
                     * Set insert data
                     */
                    $insert = array(
                        'name' => $fileOriginalName,
                        'file_name' => $fileName,
                        'file_path' => $movedFilePath,
                        'user_id' => $this->sentry->getCurrentUserId()
                    );

                    /*
                     * Create the attachment record
                     */
                    $records[] = $this->attachment->setInput($insert)->create();

                    /*
                     * Attach the attachment record to the asset images
                     */
                    $asset->images()->attach(end($records));

                }

                $this->dbCommitTransaction();

                /*
                 *  Return attachment record on success
                 */
                return $records;

            }

            $this->dbRollbackTransaction();

            /*
             * No Files were detected to be uploaded, return false
             */
            return false;


        } catch (\Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }

}