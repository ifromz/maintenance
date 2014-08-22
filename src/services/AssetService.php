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
			'user_id' 			=> $this->sentry->getCurrentUserId(),
			'location_id' 		=> ($data['location_id'] ? $data['location_id'] : NULL),
			'asset_category_id' => $data['asset_category_id'],
			'name' 				=> $data['name'],
			'condition' 		=> $data['condition'],
			'vendor' 			=> $data['vendor'],
			'make' 				=> $data['make'],
			'model' 			=> $data['model'],
			'size' 				=> $data['size'],
			'weight' 			=> $data['weight'],
			'serial' 			=> $data['serial'],
			'aquired_at' 		=> $data['aquired_at'],
		);
		
		if($record = $this->model->create($insert)){
			return $record;
		} return false;
	}
	
	public function update($id, $data){
		
		if($record = $this->find($id)){
			$edit = array(
				'location_id' 		=> ($data['location_id'] ? $data['location_id'] : NULL),
				'asset_category_id' => $data['asset_category_id'],
				'name' 				=> $data['name'],
				'condition' 		=> $data['condition'],
				'vendor' 			=> $data['vendor'],
				'make' 				=> $data['make'],
				'model' 			=> $data['model'],
				'size' 				=> $data['size'],
				'weight' 			=> $data['weight'],
				'serial' 			=> $data['serial'],
				'aquired_at' 		=> $data['aquired_at'],
			);
			
			if($record->update($edit)){
				return $record;
			} return false;
		}
		
	}
	
}