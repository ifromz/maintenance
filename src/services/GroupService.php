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
     * Creates a new Sentry group using Eloquent
     * 
     * @return boolean OR object
     */
    public function create(){
        
        $insert = array(
            'name' => $this->getInput('name'),
            'permissions' => ($this->getInput('permissions') ? json_encode($this->getInput('permissions')) : NULL)
        );
        
        $record = $this->model->create($insert);
        
        if($record){
            
            $users = $this->getInput('users');
            
            if($users){
                $record->users()->sync($this->getInput('users'));
            }
            
            return $record;
            
        } 
        
        return false;
    }
    
    /**
     * Uses maintenance model for update instead of Sentry's update. This is
     * due to sentry not removing permissions unless they are specified to be
     * removed. This essentially 'syncs' the permissions for the group specified
     * 
     * @param integer $id
     * @return boolean OR object
     */
    public function update($id) {
        $record = $this->model->find($id);
        
        $insert = array(
            'name' => $this->getInput('name'),
            'permissions' => ($this->getInput('permissions') ? json_encode($this->getInput('permissions')) : NULL)
        );
        
        if($record->update($insert)){
            
            $users = $this->getInput('users');
            
            if($users){
                $record->users()->sync($this->getInput('users'));
            }
            
            return $record;
        }
        
        return false;
    }
    
}