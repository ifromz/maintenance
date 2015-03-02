<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\StorageService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\AttachmentService as BaseAttachmentService;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class AttachmentService
 * @package Stevebauman\Maintenance\Services\WorkOrder
 */
class AttachmentService extends BaseModelService
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var BaseAttachmentService
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

    /**
     * @param WorkOrderService $workOrder
     * @param BaseAttachmentService $attachment
     * @param SentryService $sentry
     * @param ConfigService $config
     */
    public function __construct(
        WorkOrderService $workOrder,
        BaseAttachmentService $attachment,
        SentryService $sentry,
        StorageService $storage,
        ConfigService $config
    )
    {
        $this->workOrder = $workOrder;
        $this->attachment = $attachment;
        $this->sentry = $sentry;
        $this->storage = $storage;
        $this->config = $config;
    }

    /**
     * Creates attachment records, attaches them to the asset images pivot table,
     * and moves the uploaded file into it's stationary position (out of the temp folder)
     *
     * @return array|bool
     */
    public function create()
    {
        $this->dbStartTransaction();

        try
        {
            /*
             * Find the work order
             */
            $workOrder = $this->workOrder->find($this->getInput('work_order_id'));

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
                    $movedFilePath = $this->config->setPrefix('maintenance')->get('site.paths.work-orders.attachments')
                        . sprintf('%s/', $workOrder->id);

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
                    $record = $this->attachment->setInput($insert)->create();

                    if ($record)
                    {
                        /*
                         * Attach the attachment record to the asset images
                         */
                        $workOrder->attachments()->attach($record);

                        $records[] = $record;

                    } else
                    {
                        $this->dbRollbackTransaction();
                    }
                }

                $this->dbCommitTransaction();

                /*
                 *  Return attachment records on success
                 */
                return $records;

            }

        } catch (\Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }

}