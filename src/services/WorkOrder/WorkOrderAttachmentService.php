<?php 

/**
 * Handles Asset Image uploads
 * 
 * @author Steve Bauman <sbauman@bwbc.gc.ca>
 */

namespace Stevebauman\Maintenance\Services;

use Dmyers\Storage\Storage;
use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class WorkOrderAttachmentService extends AbstractModelService {
	
	public function __construct(WorkOrderService $workOrder, AttachmentService $attachment, SentryService $sentry){
		$this->workOrder = $workOrder;
		$this->attachment = $attachment;
                $this->sentry = $sentry;
	}
	
        /**
         * Creates attachment records, attaches them to the asset images pivot table,
         * and moves the uploaded file into it's stationary position (out of the temp folder)
         * 
         * @return boolean OR object
         */
        public function create()
        {
            
            $this->dbStartTransaction();
            
            try {
            
                /*
                 * Find the asset
                 */
                $asset = $this->workOrder->find($this->getInput('work_order_id'));

                /*
                 * Check if any files have been uploaded
                 */
                $files = $this->getInput('files');

                if($files){

                    $records = array();

                    /*
                     * For each file, create the attachment record, and sync asset image pivot table
                     */
                    foreach($files as $file){

                        $attributes = explode('|', $file);

                        $fileName = $attributes[0];
                        $fileOriginalName = $attributes[1];

                        /*
                         * Ex. files/assets/images/1/example.png
                         */
                        $movedFilePath = Config::get('maintenance::site.paths.work-orders.attachments').sprintf('%s/', $asset->id);

                        /*
                         * Move the file
                         */
                        Storage::move(Config::get('maintenance::site.paths.temp').$fileName, $movedFilePath.$fileName);

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

                        if($record){

                            /*
                             * Attach the attachment record to the asset images
                             */
                            $asset->attachments()->attach($record);

                            $records[] = $record;

                        } else {

                            $this->dbRollbackTransaction();

                        }
                    }

                   $this->dbCommitTransaction();

                    /*
                     *  Return attachment records on success
                     */
                    return $records;

                }
                
                /*
                 * No Files were detected to be uploaded, return false
                 */
                return false;
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
            
        }
            
}