<?php 

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Controllers\BaseController;

class UserController extends BaseController {
    
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }
    
    public function index()
    {
        $users = $this->user->setInput($this->inputAll())->getByPageWithFilter();
        
        return view('maintenance::admin.users.index', array(
            'title' => 'All Users',
            'users' => $users
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
        $user = $this->user->find($id);
        
        return view('maintenance::admin.users.show', array(
            'title'=>'Viewing User',
            'user'=>$user
        ));
    }
    
    public function edit($id)
    {
        
        $user = $this->user->find($id);
        
        return view('maintenance::admin.users.edit', array(
            'title'=>'Editing User',
            'user'=>$user
        ));
        
    }
    
    public function update($id)
    {
        
    }
    
    public function destroy($id)
    {
        
    }
    
}