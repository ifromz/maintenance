<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Group;
use Stevebauman\Maintenance\Services\SentryGroupService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class GroupService extends AbstractModelService {
    
    public function __construct(Group $group, SentryGroupService $sentryGroup){
        $this->model = $group;
        $this->sentryGroup = $sentryGroup;
    }
    
    /**
     * Uses Sentry to find the group to keep Sentry functions intact
     * 
     * @param integer $id
     * @return type
     */
    public function find($id){
        return $this->sentryGroup->find($id);
    }
    
    /**
     * Uses maintenance model for update instead of Sentry's update. This is
     * due to sentry not removing permissions unless they are specified to be
     * removed.
     * 
     * @param integer $id
     * @return boolean
     */
    public function update($id) {
        $record = $this->model->find($id);
        
        $insert = array(
            'name' => $this->getInput('name'),
            'permissions' => $this->getInput('permissions')
        );
        
        if($record->update($insert)){
            return $record;
        }
        
        return false;
    }
    
}