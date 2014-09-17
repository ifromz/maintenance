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
	
	public function create($data){
		$insert = array(
			'user_id'           => $this->sentry->getCurrentUserId(),
			'location_id'       => ($data['location_id'] ? $data['location_id'] : NULL),
			'category_id'       => $data['category_id'],
			'name'              => $this->clean($data['name']),
			'condition'         => $data['condition'],
			'vendor'            => $this->clean($data['vendor']),
			'make'              => $this->clean($data['make']),
			'model'             => $this->clean($data['model']),
			'size'              => $this->clean($data['size']),
			'weight'            => $this->clean($data['weight']),
			'serial'            => $this->clean($data['serial']),
			'aquired_at'        => $data['aquired_at'],
		);
		
		if($record = $this->model->create($insert)){
			return $record;
		} return false;
	}
	
	public function update($id, $data){
		
		if($record = $this->find($id)){
			$edit = array(
				'location_id'       => ($data['location_id'] ? $data['location_id'] : NULL),
				'category_id'       => $data['category_id'],
				'name'              => $this->clean($data['name']),
				'condition'         => $data['condition'],
                                'vendor'            => $this->clean($data['vendor']),
                                'make'              => $this->clean($data['make']),
                                'model'             => $this->clean($data['model']),
                                'size'              => $this->clean($data['size']),
                                'weight'            => $this->clean($data['weight']),
                                'serial'            => $this->clean($data['serial']),
				'aquired_at'        => $data['aquired_at'],
			);
			
			if($record->update($edit)){
				return $record;
			} return false;
		}
		
	}
	
}