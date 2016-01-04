<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Validators\AccessCheckValidator;

class AccessController extends Controller
{
    /**
     * @var UserService
     */
    protected $user;

    /**
     * @var AccessCheckValidator
     */
    protected $accessValidator;

    /**
     * @param UserService          $user
     * @param AccessCheckValidator $accessValidator
     */
    public function __construct(UserService $user, AccessCheckValidator $accessValidator)
    {
        $this->user = $user;
        $this->accessValidator = $accessValidator;
    }

    /**
     * Checks if the user with the specified ID has access to the
     * inputted permission.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function postCheck($id)
    {
        if ($this->accessValidator->passes()) {
            $user = $this->user->find($id);

            $permission = $this->input('permission');

            if ($user->hasAccess($permission)) {
                $this->message = sprintf('This user <b>has access</b> to %s', $permission);
                $this->messageType = 'success';
                $this->redirect = route('maintenance.admin.users.show', [$user->id]);
            } else {
                $this->message = sprintf('This user <b>does not have access</b> to %s', $permission);
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.admin.users.show', [$user->id]);
            }
        } else {
            $this->errors = $this->accessValidator->getErrors();
            $this->redirect = route('maintenance.admin.users.show', [$id]);
        }

        return $this->response();
    }
}
