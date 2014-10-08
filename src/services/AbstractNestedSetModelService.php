<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\AbstractModelService;

abstract class AbstractNestedSetModelService extends AbstractModelService {
    
    public function create(){
        $insert = array(
            'name' => $this->getInput('name')
        );

        if($record = $this->model->create($insert)){
            return $record;
        } return false;
    }
    
}