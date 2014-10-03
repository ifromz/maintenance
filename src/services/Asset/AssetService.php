<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Models\Asset;

class AssetService extends AbstractModelService {
	
	public function __construct(Asset $asset, SentryService $sentry){
		$this->model = $asset;
		$this->sentry = $sentry;
	}
	
	public function getByPage(){
		return $this->model
			->paginate(25);
	}
	
	public function create(){
		$insert = array(
			'user_id'           => $this->sentry->getCurrentUserId(),
			'location_id'       => $this->input('location_id'),
			'category_id'       => $this->input('category_id'),
			'name'              => $this->input('name', true),
			'condition'         => $this->input('condition'),
			'vendor'            => $this->input('vendor', true),
			'make'              => $this->input('make', true),
			'model'             => $this->input('model', true),
			'size'              => $this->input('size', true),
			'weight'            => $this->input('weight', true),
			'serial'            => $this->input('serial', true),
			'aquired_at'        => $this->input('aquired_at'),
		);
		
		if($record = $this->model->create($insert)){
			return $record;
		} return false;
	}
	
	public function update($id){
		
		if($record = $this->find($id)){
			$edit = array(
				'location_id'       => $this->input('location_id'),
				'category_id'       => $this->input('category_id'),
				'name'              => $this->input('name', true),
				'condition'         => $this->input('condition'),
                                'vendor'            => $this->input('vendor', true),
                                'make'              => $this->input('make', true),
                                'model'             => $this->input('model', true),
                                'size'              => $this->input('size', true),
                                'weight'            => $this->input('weight', true),
                                'serial'            => $this->input('serial', true),
				'aquired_at'        => $this->input('aquired_at'),
			);
                        
			if($record->update($edit)){
				return $record;
			} return false;
		}
		
	}
	
}