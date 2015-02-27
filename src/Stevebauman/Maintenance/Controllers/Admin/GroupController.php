<?php 

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Validators\GroupValidator;
use Stevebauman\Maintenance\Services\GroupService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class GroupController
 * @package Stevebauman\Maintenance\Controllers\Admin
 */
class GroupController extends BaseController {

    /**
     * @var GroupService
     */
    protected $group;

    /**
     * @var GroupValidator
     */
    private $groupValidator;

    public function __construct(GroupService $group, GroupValidator $groupValidator)
    {
        $this->group = $group;
        $this->groupValidator = $groupValidator;
    }

    /**
     * Displays the view of all the user groups
     *
     * @return mixed
     */
    public function index()
    {
        $groups = $this->group->get();

        return view('maintenance::admin.groups.index', array(
            'title' => 'All Groups',
            'groups' => $groups
        ));
    }

    /**
     * Displays the view to create a user group
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::admin.groups.create', array(
            'title' => 'Create a Group'
        ));
    }

    /**
     * Processes the creation of a user group
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store()
    {
        if($this->groupValidator->passes()){
            
            $data = $this->inputAll();
            $data['permissions'] = $this->routesToPermissions($this->input('routes'));
            
            $record = $this->group->setInput($data)->create();
            
            if($record)
            {
                $this->message = sprintf('Successfully created group. %s', link_to_route('maintenance.admin.groups.show', 'Show', array($record->id)));
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.groups.index');
            } else
            {
                $this->message = 'There was an error trying to create the group, please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.admin.groups.create');
            }

        } else
        {
            $this->errors = $this->groupValidator->getErrors();
            $this->redirect = routeBack('maintenace.admin.groups.create');
        }
        
        return $this->response();
    }

    /**
     * Displays the specified user group
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $group = $this->group->find($id);
        
        return view('maintenance::admin.groups.show', array(
            'title'=>'Viewing Group',
            'group'=>$group
        ));
    }

    /**
     * Displays the form to edit the specified user group
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $group = $this->group->find($id);
        
        return view('maintenance::admin.groups.edit', array(
            'title'=>'Editing Group',
            'group'=>$group
        ));
    }

    /**
     * Processes updating the specified user group
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update($id)
    {
        if($this->groupValidator->passes())
        {
            $data = $this->inputAll();
            $data['permissions'] = $this->routesToPermissions($this->input('routes'));
            
            $record = $this->group->setInput($data)->update($id);
            
            if($record)
            {
                $this->message = sprintf('Successfully updated group. %s', link_to_route('maintenance.admin.groups.show', 'Show', array($record->id)));
                $this->messageType = 'success';
                $this->redirect = routeBack('maintenance.admin.groups.index');
            } else
            {
                $this->message = 'There was an error updating this group, please try again.';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.admin.groups.edit', array($id));
            }
            
        } else
        {
            $this->errors = $this->groupValidator->getErrors();
            $this->redirect = routeBack('maintenance.admin.groups.edit', array($id));
        }
        
        return $this->response();

    }

    /**
     * Processes deleting the specified user group
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($id)
    {
        $group = $this->group->find($id);

        $group->users()->detach();

        if($group->delete())
        {
            $this->message = 'Successfully deleted group';
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.admin.groups.index');
        } else
        {
            $this->message = 'There was an issue trying to delete this group, please try again.';
            $this->messageType = 'danger';
            $this->redirect = routeBack('maintenance.admin.groups.show', array($group->id));
        }

        return $this->response();
    }

    /**
     * Converts the submitted route array key values to 1 for sentry
     *
     * @param null $routes
     * @return array
     */
    private function routesToPermissions($routes = NULL)
    {
        $permissions = array();
        
        /*
         * If routes are provided, set the route value key to 1,
         * indicating that the user has permission in Sentry
         */
        if($routes) foreach($routes as $route) $permissions[$route] = 1;
        
        return $permissions;
    }
    
}