<?php 

namespace Stevebauman\Maintenance\Controllers\Admin;

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
        return $this->view('maintenance::admin.groups.create', array(
            'title' => 'Create a User'
        ));
    }
    
    public function store()
    {
        $validator = new $this->groupValidator;
        
        if($validator->passes()){
            
            $data = $this->inputAll();
            $data['permissions'] = $this->routesToPermissions($this->input('routes'));
            
            $record = $this->group->setInput($data)->create();
            
            if($record){
                $this->message = sprintf('Successfully created group. %s', link_to_route('maintenance.admin.groups.show', 'Show', array($record->id)));
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.groups.index');
            } else{
                $this->message = 'There was an error trying to create the group, please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.admin.groups.create');
            }
            
            return $this->response();
            
        } else{
            $this->errors = $validator->getErrors();
        }
        
        return $this->response();
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
            

            $data = $this->inputAll();
            $data['permissions'] = $this->routesToPermissions($this->input('routes'));

            if($record = $this->group->setInput($data)->update($id)){
                $this->message = sprintf('Successfully updated group. %s', link_to_route('maintenance.admin.groups.show', 'Show', array($record->id)));
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
    
    /**
     * Converts the submitted route array key values to 1 for sentry
     * permissions
     * 
     * @param array $routes
     */
    private function routesToPermissions($routes = NULL)
    {
        $permissions = array();
        
        /*
         * If routes are provided
         */
        if($routes){
            foreach($routes as $route){
                
                /*
                 * Set the route value key to 1, indicating that the user has
                 * permission in Sentry
                 */
                $permissions[$route] = 1;
            }
        }
        
        return $permissions;
    }
    
}