<?php 

/**
 * Handles asset interactions
 * 
 * @author Steve Bauman <sbauman@bwbc.gc.ca>
 */

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\AssetNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Asset;
use Stevebauman\Maintenance\Services\AbstractModelService;

class AssetService extends AbstractModelService {
	
	public function __construct(Asset $asset, SentryService $sentry, AssetNotFoundException $notFoundException){
		$this->model = $asset;
		$this->sentry = $sentry;
                $this->notFoundException = $notFoundException;
	}
	
        /**
         * Returns all assets paginated
         * 
         * @return type Collection
         */
	public function getByPageWithFilter($archived = NULL){
		return $this->model
                        ->name($this->getInput('name'))
                        ->condition($this->getInput('condition'))
                        ->category($this->getInput('category'))
                        ->location($this->getInput('location'))
                        ->sort($this->getInput('field'), $this->getInput('sort'))
                        ->archived($archived)
			->paginate(25);
	}
        
        /**
         * Returns common makes that are inputted into the DB for
         * auto-complete functionality
         * 
         * @param type $make
         * @return type Collection
         */
        public function getMakes($make = NULL){
		return $this->model
			->select('make')
			->distinct()
			->where('make', 'LIKE', '%'.$make.'%')
			->get();
	}
	
        /**
         * Returns common models that are inputted into the DB for
         * auto-complete functionality
         * 
         * @param type $model
         * @return type Collection
         */
	public function getModels($model = NULL){
		return $this->model
			->distinct()
			->select('model')
			->where('model', 'LIKE', '%'.$model.'%')
			->get();
	}
	
        /**
         * Returns common serials that are inputted into the DB for
         * auto-complete functionality
         * 
         * @param type $serial
         * @return type Collection
         */
	public function getSerials($serial = NULL){
		return $this->model
			->distinct()
			->select('serial')
			->where('serial', 'LIKE', '%'.$serial.'%')
			->get();
	}
	
        /**
         * Creates an asset
         * 
         * @return boolean OR object
         */
	public function create(){
                
                /*
                 * Set insert data
                 */
		$insert = array(
			'user_id'           => $this->sentry->getCurrentUserId(),
                        'category_id'       => $this->getInput('category_id'),
			'location_id'       => $this->getInput('location_id'),
			'name'              => $this->getInput('name', NULL, true),
			'condition'         => $this->getInput('condition'),
			'vendor'            => $this->getInput('vendor', NULL, true),
			'make'              => $this->getInput('make', NULL, true),
			'model'             => $this->getInput('model', NULL, true),
			'size'              => $this->getInput('size', NULL, true),
			'weight'            => $this->getInput('weight', NULL, true),
			'serial'            => $this->getInput('serial', NULL, true),
			'aquired_at'        => $this->formatDateWithTime($this->getInput('aquired_at')),
		);
		
                /*
                 * Create the record and return it upon success
                 */
		if($record = $this->model->create($insert)){
			return $record;
		} 
                
                /*
                 * Failed to create record, return false
                 */
                return false;
	}
	
        /**
         * Updates an asset record
         * 
         * @param type $id
         * @return boolean OR object
         */
	public function update($id){
            
                /*
                 * Find the asset record
                 */
		$record = $this->find($id);
                
                /*
                 * Set update data
                 */
                $edit = array(
                        'location_id'       => $this->getInput('location_id', $record->location_id),
                        'category_id'       => $this->getInput('category_id', $record->category_id),
                        'name'              => $this->getInput('name', $record->name, true),
                        'condition'         => $this->getInput('condition', $record->condition),
                        'vendor'            => $this->getInput('vendor', $record->vendor, true),
                        'make'              => $this->getInput('make', $record->make, true),
                        'model'             => $this->getInput('model', $record->model, true),
                        'size'              => $this->getInput('size', $record->size, true),
                        'weight'            => $this->getInput('weight', $record->weight, true),
                        'serial'            => $this->getInput('serial', $record->serial, true),
                        'aquired_at'        => ($this->formatDateWithTime($this->getInput('aquired_at')) ?: $record->aquired_at),
                );
                
                /*
                 * Update the record and return it upon success
                 */
                if($record->update($edit)){
                    return $record;
                } 
                
                /*
                 * Failed to update record, return false;
                 */
                return false;
		
	}
        
}