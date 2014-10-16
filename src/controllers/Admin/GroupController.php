<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\GroupValidator;
use Stevebauman\Maintenance\Services\GroupService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class GroupController extends AbstractController {
    
    public function __construct(GroupService $group, GroupValidator $groupValidator)
    {
        $this->group = $group;
        $this->groupValidator = $groupValidator;
    }
    
    public function index()
    {
        $groups = $this->group->get();

        return $this->view('maintenance::admin.groups.index', array(
            'title' => 'All Groups',
            'groups' => $groups
        ));
    }
    
    public function create()
    {
        return $this->view('maintenance::admin.users.create', array(
            'title' => 'Create a User'
        ));
    }
    
    public function store()
    {
        
    }
    
    public function show($id)
    {
        $group = $this->group->find($id);
        
        return $this->view('maintenance::admin.groups.show', array(
            'title'=>'Viewing Group',
            'group'=>$group
        ));
    }
    
    public function edit($id)
    {
        $group = $this->group->find($id);
        
        return $this->view('maintenance::admin.groups.edit', array(
            'title'=>'Editing Group',
            'group'=>$group
        ));
    }
    
    public function update($id)
    {
        $validator = new $this->groupValidator;
        
        if($validator->passes()){
        
            $routes = $this->input('routes');
            
            $permissions = array();
            
            if($routes){
                foreach($routes as $route){
                    $permissions[$route] = 1;
                }
            }
            
            $data = $this->inputAll();
            $data['permissions'] = $permissions;

            if($this->group->setInput($data)->update($id)){
                $this->message = 'Successfully updated group';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.groups.index');
            } else{
                $this->message = 'Successfully updated group';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.groups.edit', array($id));
            }
            
        } else{
            $this->errors = $validator->getErrors();
        }
        
        return $this->response();

    }
    
    public function destroy($id)
    {
        
    }
    
}