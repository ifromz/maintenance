<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Update;
use Stevebauman\Maintenance\Services\SentryService;

class UpdateService extends AbstractModelService {
	
	public function __construct(Update $update, SentryService $sentry){
		$this->model = $update;
		$this->sentry = $sentry;
	}
	
	public function create(){
		$insert = array(
                        'user_id' => $this->sentry->getCurrentUserId(),
			'content' => $this->getInput('update_content', NULL, true)
		);
		
		if($record = $this->model->create($insert)){
			return $record;
		} return false;
	}
}