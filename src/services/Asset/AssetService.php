<?php namespace Stevebauman\Maintenance\Services;

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
	
	public function getByPage(){
		return $this->model
			->paginate(25);
	}
        
        public function getMakes($make = NULL){
		return $this->model
			->select('make')
			->distinct()
			->where('make', 'LIKE', '%'.$make.'%')
			->get();
	}
	
	public function getModels($model = NULL){
		return $this->model
			->distinct()
			->select('model')
			->where('model', 'LIKE', '%'.$model.'%')
			->get();
	}
	
	public function getSerials($serial = NULL){
		return $this->model
			->distinct()
			->select('serial')
			->where('serial', 'LIKE', '%'.$serial.'%')
			->get();
	}
	
	public function create(){
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
		
		if($record = $this->model->create($insert)){
			return $record;
		} return false;
	}
	
	public function update($id){
		$record = $this->find($id);
                
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
                        
                if($record->update($edit)){
                        return $record;
                } return false;
		
	}
	
}