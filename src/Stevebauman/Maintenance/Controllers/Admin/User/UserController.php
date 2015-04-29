<?php

namespace Stevebauman\Maintenance\Controllers\Admin\User;

use Stevebauman\Maintenance\Validators\UserValidator;
use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class UserController
 * @package Stevebauman\Maintenance\Controllers\Admin
 */
class UserController extends BaseController
{
    /**
     * @var UserService
     */
    protected $user;

    /**
     * @var UserValidator
     */
    protected $userValidator;

    /**
     * @param UserService $user
     * @param UserValidator $userValidator
     */
    public function __construct(UserService $user, UserValidator $userValidator)
    {
        $this->user = $user;
        $this->userValidator = $userValidator;
    }

    /**
     * Displays a list of all users
     *
     * @return mixed
     */
    public function index()
    {
        $users = $this->user->setInput($this->inputAll())->getByPageWithFilter();
        
        return view('maintenance::admin.users.index', [
            'title' => 'All Users',
            'users' => $users
        ]);
    }

    /**
     * Displays the form for creating a user
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::admin.users.create', [
            'title' => 'Create a User'
        ]);
    }

    /**
     * Processes creating a new user
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store()
    {
        if($this->userValidator->passesCreate())
        {
            $user = $this->user->setInput($this->inputAll())->create();

            if($user)
            {
                $link = link_to_route('maintenance.admin.users.show', 'Show', [$user->id]);

                $this->message = "Successfully created user. $link";
                $this->messageType = 'success';
                $this->redirect = routeBack('maintenance.admin.users.index');
            } else
            {
                $this->message = 'There was an error trying to create a user, please try again.';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.admin.users.create');
            }

        } else
        {
            $this->errors = $this->userValidator->getErrors();
            $this->redirect = routeBack('maintenance.admin.users.create');
        }

        return $this->response();
    }

    /**
     * Displays the user with the specified ID
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->user->find($id);
        
        return view('maintenance::admin.users.show', [
            'title'=>'Viewing User',
            'user'=>$user
        ]);
    }

    /**
     * Displays the form for editing the user with the specified ID
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        
        return view('maintenance::admin.users.edit', [
            'title'=>'Editing User',
            'user'=>$user
        ]);
    }

    /**
     * Processes updating the user with the specified ID
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update($id)
    {
        if($this->userValidator->passesUpdate($id))
        {
            if($this->user->setInput($this->inputAll())->update($id))
            {
                $link = link_to_route('maintenance.admin.users.show', 'Show', [$id]);

                $this->message = "Successfully updated user. $link";
                $this->messageType = 'success';
                $this->redirect = routeBack('maintenance.admin.users.show', [$id]);
            } else
            {
                $this->message = 'There was an error trying to update this user. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.admin.users.edit', [$id]);
            }
        } else
        {
            $this->errors = $this->userValidator->getErrors();
            $this->redirect = routeBack('maintenance.admin.users.edit', [$id]);
        }

        return $this->response();
    }

    /**
     * Deletes the user with the specified ID
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($id)
    {
        if($this->user->destroy($id))
        {
            $this->message = 'Successfully deleted user';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.users.index');
        } else
        {
            $this->message = 'There was an issue deleting this user, please try again.';
            $this->messageType = 'danger';
            $this->redirect = routeBack('maintenance.admin.users.show', [$id]);
        }

        return $this->response();
    }
    
}