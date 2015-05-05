<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\Login\LoginValidator;
use Stevebauman\Maintenance\Validators\Login\RegisterValidator;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Services\LdapService;
use Stevebauman\Maintenance\Services\AuthService;

/**
 * Class AuthController
 * @package Stevebauman\Maintenance\Controllers
 */
class AuthController extends BaseController
{
    /**
     * @var LoginValidator
     */
    protected $loginValidator;

    /**
     * @var RegisterValidator
     */
    protected $registerValidator;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var UserService
     */
    protected $user;

    /**
     * @var AuthService
     */
    protected $auth;

    /**
     * @var LdapService
     */
    protected $ldap;

    /**
     * Constructor.
     *
     * @param LoginValidator $loginValidator
     * @param RegisterValidator $registerValidator
     * @param ConfigService $config
     * @param SentryService $sentry
     * @param UserService $user
     * @param AuthService $auth
     * @param LdapService $ldap
     */
    public function __construct(
        LoginValidator $loginValidator,
        RegisterValidator $registerValidator,
        ConfigService $config,
        SentryService $sentry,
        UserService $user,
        AuthService $auth,
        LdapService $ldap
    )
    {
        /*
         * Setup validators
         */
        $this->loginValidator = $loginValidator;
        $this->registerValidator = $registerValidator;

        /*
         * Setup services
         */
        $this->config = $config->setPrefix('maintenance');
        $this->sentry = $sentry;
        $this->user = $user;
        $this->auth = $auth;
        $this->ldap = $ldap;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('maintenance::login.index', [
            'title' => 'Sign In',
        ]);
    }

    /**
     * Processes logging in a user.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postLogin()
    {
        if ($this->loginValidator->passes()) {
            $data = $this->inputAll();

            if ($this->config->get('site.ldap.enabled') === true) {
                /*
                 * Check if the user exists on active directory
                 */
                if ($this->ldap->getUserEmail($data['email'])) {
                    /*
                     * Try authentication
                     */
                    if ($this->auth->ldapAuthenticate($data)) {
                        /*
                         * If authentication is good, update their
                         * web profile in case of a password update in AD
                         */
                        $user = $this->user->createOrUpdateLdapUser($data);

                        $data['email'] = $user->email;
                    }
                }
            }

            /*
             * Authenticate with sentry
             */
            $response = $this->auth->sentryAuthenticate(
                array_only($data, ['email', 'password']),
                (array_key_exists('remember', $data) ? $data['remember'] : null)
            );

            /*
             * Check the authenticated response
             */
            if ($response['authenticated'] === true) {
                /*
                 * Successfully logged in
                 */
                $this->message = 'Successfully logged in. Redirecting...';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.dashboard.index');

            } else {
                /*
                 * Login failed, return the response from Sentry
                 */
                $this->message = $response['message'];
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.login');
            }
        } else {
            $this->errors = $this->loginValidator->getErrors();
            $this->redirect = route('maintenance.login');
        }

        return $this->response();
    }

    /**
     * Show the form for registering an account.
     *
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        return view('maintenance::register.index', [
            'title' => 'Register',
        ]);
    }

    /**
     * Processes registering for an account.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postRegister()
    {
        if ($this->registerValidator->passes())
        {
            $data = $this->inputAll();

            /*
             * We'll create a random unique username since
             * the username attribute is only for LDAP logins
             */
            $data['username'] = uniqid();

            if($this->sentry->createUser($data))
            {
                $this->message = 'Successfully created account. You can now login.';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.login');
            } else
            {
                $this->message = 'There was an error registering for an account. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.register');
            }
        } else
        {
            $this->errors = $this->registerValidator->getErrors();
            $this->redirect = route('maintenance.register');
        }

        return $this->response();
    }

    /**
     * Processes logging out a user.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->auth->sentryLogout();

        $this->message = 'Successfully logged out';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.login');

        return $this->response();
    }
}
