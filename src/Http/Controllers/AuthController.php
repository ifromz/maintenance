<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Http\Requests\Auth\RegisterRequest;
use Stevebauman\Maintenance\Http\Requests\Auth\LoginRequest;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\UserService;
use Stevebauman\Maintenance\Services\LdapService;
use Stevebauman\Maintenance\Services\AuthService;

/**
 * Class AuthController.
 */
class AuthController extends Controller
{
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
     * @param ConfigService     $config
     * @param SentryService     $sentry
     * @param UserService       $user
     * @param AuthService       $auth
     * @param LdapService       $ldap
     */
    public function __construct(
        ConfigService $config,
        SentryService $sentry,
        UserService $user,
        AuthService $auth,
        LdapService $ldap
    ) {
        $this->config = $config->setPrefix('maintenance');
        $this->sentry = $sentry;
        $this->user = $user;
        $this->auth = $auth;
        $this->ldap = $ldap;
    }

    /**
     * Displays the login page.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('maintenance::auth.login.index');
    }

    /**
     * Processes logging in a user.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->all();

        // Check if LDAP authentication is enabled
        if ($this->config->get('site.ldap.enabled') === true) {
            $user = $this->ldapAuthenticate($credentials);

            if(is_a($user, 'Cartalyst\Sentry\Users\Eloquent\User')) {
                $credentials['email'] = $user->email;
            }
        }

        // Authenticate with sentry
        $response = $this->auth->sentryAuthenticate(
            array_only($credentials, ['email', 'password']),
            (array_key_exists('remember', $credentials) ? $credentials['remember'] : null)
        );

        // Check the authenticated response
        if ($response['authenticated'] === true) {
            // Successfully logged in
            $message = 'Successfully logged in.';

            return redirect()->route('maintenance.work-requests.index')->withSuccess($message);
        } else {
            // Login failed, return error response
            return redirect()->route('maintenance.login')->withErrors($response['message']);
        }
    }

    /**
     * Show the form for registering an account.
     *
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        return view('maintenance::auth.register.index');
    }

    /**
     * Processes registering for an account.
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegisterRequest $request)
    {
        $data = $request->all();

        /*
         * We'll create a random unique username since
         * the username attribute is only for LDAP logins
         */
        $data['username'] = uniqid();

        // Create the user with default groups of all users and customers
        if ($this->sentry->registerUser($data, ['all_users', 'customers'])) {
            $message = 'Successfully created account. You can now login.';

            return redirect()->route('maintenance.login')->withSuccess($message);
        } else {
            $message = 'There was an issue registering you an account. Please try again.';

            return redirect()->route('maintenance.login')->withErrors($message);
        }
    }

    /**
     * Processes logging out a user.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->auth->sentryLogout();

        return redirect()->route('maintenance.login');
    }

    /**
     * Performs LDAP authentication with the specified
     * credentials. If authentication is passed, the LDAP
     * user is then created with their entered password.
     * Their web account will password will also be updated
     * on the fly in case of a change in active directory.
     *
     * @param array $credentials
     *
     * @return bool|\Cartalyst\Sentry\Users\Eloquent\User
     */
    private function ldapAuthenticate(array $credentials)
    {
        // Check if the user exists on active directory
        if ($this->ldap->getUserEmail($credentials['email'])) {
            // Try LDAP authentication
            if ($this->auth->ldapAuthenticate($credentials)) {
                /*
                 * If authentication is passed, update their
                 * web profile in case of a password update in AD
                 */
                return $this->user->createOrUpdateLdapUser($credentials);
            }
        }

        return false;
    }
}
