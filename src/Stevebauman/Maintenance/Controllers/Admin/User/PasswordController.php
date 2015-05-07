<?php

namespace Stevebauman\Maintenance\Controllers\Admin\User;

use Stevebauman\Maintenance\Validators\PasswordValidator;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class PasswordController.
 */
class PasswordController extends BaseController
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var PasswordValidator
     */
    protected $passwordValidator;

    /**
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry, PasswordValidator $passwordValidator)
    {
        $this->sentry = $sentry;

        $this->passwordValidator = $passwordValidator;
    }

    /**
     * Updates the specified users password.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update($id)
    {
        if ($this->passwordValidator->passes()) {
            if ($this->sentry->updatePasswordById($id, $this->input('password'))) {
                $this->message = 'Successfully updated password';
                $this->messageType = 'success';
                $this->redirect = routeBack('maintenance.admin.users.show', [$id]);
            } else {
                $this->message = 'There was an issue resseting this users password. Please try again';
                $this->messageType = 'danger';
                $this->redirect = routeBack('maintenance.admin.users.show', [$id]);
            }
        } else {
            $this->errors = $this->passwordValidator->getErrors();
            $this->redirect = route('maintenance.admin.users.show', [$id]);
        }

        return $this->response();
    }
}
