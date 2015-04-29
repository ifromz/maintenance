<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\PasswordValidator;
use Stevebauman\Maintenance\Validators\Login\RequestResetValidator;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\MailService;
use Stevebauman\Maintenance\Services\SentryService;

/**
 * Class ResetPasswordController
 * @package Stevebauman\Maintenance\Controllers\Client
 */
class PasswordController extends BaseController
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var MailService
     */
    protected $mail;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @var RequestResetValidator
     */
    protected $requestResetValidator;

    /**
     * @var PasswordValidator
     */
    protected $passwordValidator;

    /**
     * @param SentryService $sentry
     * @param MailService $mail
     * @param ConfigService $config
     * @param RequestResetValidator $requestResetValidator
     * @param PasswordValidator $passwordValidator
     */
    public function __construct(
        SentryService $sentry,
        MailService $mail,
        ConfigService $config,
        RequestResetValidator $requestResetValidator,
        PasswordValidator $passwordValidator
    )
    {
        $this->sentry = $sentry;
        $this->mail = $mail;
        $this->config = $config;
        $this->requestResetValidator = $requestResetValidator;
        $this->passwordValidator = $passwordValidator;
    }

    /**
     * Requests for a password reset
     */
    public function getRequest()
    {
        return view('maintenance::login.password.request', [
            'title' => 'Reset Your Password',
        ]);
    }

    /**
     * Sends an email to the user with their password reset link
     */
    public function postRequest()
    {
        if($this->requestResetValidator->passes())
        {
            $user = $this->sentry->findUserByLogin($this->input('email'));

            if($user)
            {
                $sent = $this->mail->send('maintenance::emails.reset-password', [
                    'user' => $user,
                    'code' => $user->getResetPasswordCode(),
                ], function($message) use ($user)
                {
                    $adminEmail = $this->config->get('mail.from.address');
                    $adminName = $this->config->get('mail.from.name');

                    $message
                        ->to($user->email, $user->first_name)
                        ->from($adminEmail, $adminName)
                        ->subject('Reset Your Password');
                });

                if($sent)
                {
                    $this->message = "We've sent you an email to reset your password.";
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.login.forgot-password');
                } else
                {
                    $this->message = "There was an issue trying to send your password reset request. Please try again later.";
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.login.forgot-password');
                }
            } else
            {
                $this->message = 'The email/username you entered does not exist, please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.login.forgot-password');
            }
        } else
        {
            $this->errors = $this->requestResetValidator->getErrors();
            $this->redirect = route('maintenance.login.forgot-password');
        }

        return $this->response();
    }

    /**
     * Displays the form for updating a user password
     *
     * @param string|int $id
     * @param string|int $key
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getReset($id, $key)
    {
        $user = $this->sentry->findUserById($id);

        if($user->checkResetPasswordCode($key))
        {
            return view('maintenance::login.password.reset', [
                'title' => 'Reset Your Password',
                'user' => $user,
                'code' => $key
            ]);
        } else
        {
            $this->redirect = route('maintenance.login');

            return $this->response();
        }
    }

    /**
     * Processes the password update
     *
     * @param string|int $id
     * @param string|int $key
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function postReset($id, $key)
    {
        if($this->passwordValidator->passes())
        {
            $user = $this->sentry->findUserById($id);

            if ($user->checkResetPasswordCode($key))
            {
                if ($user->attemptResetPassword($key, $this->input('password')))
                {
                    $link = link_to_route('maintenance.login', 'login');

                    $this->message = "Successfully updated your password, you can now $link.";
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.login');
                } else
                {
                    $this->message = 'You have already updated your password.';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.login');
                }
            } else
            {
                $this->message = 'You have already reset your password.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.login');
            }
        } else
        {
            $this->errors = $this->passwordValidator->getErrors();
            $this->redirect = route('maintenance.login');
        }

        return $this->response();
    }
}