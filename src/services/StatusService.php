<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Status;
use Stevebauman\Maintenance\Services\SentryService;

class StatusService extends AbstractModelService {
	
	public function __construct(Status $status, SentryService $sentry){
		$this->model = $status;
		$this->sentry = $sentry;
	}
	
	public function create($data){
		$insert = array(
			'user_id' => $this->sentry->getCurrentUser()->id,
			'name' => $data['name'],
			'color' => $data['color'],
		);
		
		if($record = $this->model->create($insert)){
			return $record;
		} return false;
	}
	
	public function dropdown(){
		$statuses = $this->get()->lists('name', 'id');
		$statuses['0'] = 'None';
		
		return $statuses;
	}
	
}