<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Http\Requests\Admin\User\CreateRequest;
use Stevebauman\Maintenance\Http\Requests\Admin\User\UpdateRequest;
use Stevebauman\Maintenance\Models\User;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\LdapService;
use Stevebauman\Maintenance\Services\SentryService;

class UserRepository extends Repository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @var LdapService
     */
    protected $ldap;

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     * @param ConfigService $config
     * @param LdapService   $ldap
     */
    public function __construct(SentryService $sentry, ConfigService $config, LdapService $ldap)
    {
        $this->sentry = $sentry;
        $this->config = $config;
        $this->ldap = $ldap;
    }

    /**
     * @return User
     */
    public function model()
    {
        return new User();
    }

    /**
     * Creates a new user.
     *
     * @param CreateRequest $request
     *
     * @return bool|User
     */
    public function create(CreateRequest $request)
    {
        $attributes = [
            'username'    => $request->input('username'),
            'email'       => $request->input('email'),
            'first_name'  => $request->input('first_name'),
            'last_name'   => $request->input('last_name'),
            'password'    => $request->input('password'),
            'permissions' => $request->input('permissions', []),
            'activated'   => $request->input('activated', false),
        ];

        $user = $this->sentry->createUser($attributes);

        if ($user) {
            return $user;
        }

        return false;
    }

    /**
     * Updates the specified user.
     *
     * @param UpdateRequest $request
     * @param int|string    $id
     *
     * @return bool|User
     */
    public function update(UpdateRequest $request, $id)
    {
        $attributes = [
            'username'    => $request->input('username'),
            'email'       => $request->input('email'),
            'first_name'  => $request->input('first_name'),
            'last_name'   => $request->input('last_name'),
            'permissions' => $request->input('permissions', []),
            'activated'   => $request->input('activated', false),
        ];

        $user = $this->sentry->update($id, $attributes);

        if ($user) {
            return $user;
        }

        return false;
    }

    /**
     * Creates or updates a user using LDAP and Sentry.
     *
     * @param array $credentials
     *
     * @return mixed
     */
    public function createOrUpdateLdapUser(array $credentials)
    {
        $loginAttribute = $this->config->setPrefix('cartalyst.sentry')->get('users.login_attribute');

        $username = $credentials[$loginAttribute];
        $password = $credentials['password'];

        // If a user is found, update their password to match active-directory
        $user = $this->model()->where('username', $username)->first();

        if ($user) {
            $this->sentry->updatePasswordById($user->id, $password);
        } else {
            // If a user is not found, create their web account
            $ldapUser = $this->ldap->user($username);

            $fullName = explode(',', $ldapUser->name);
            $lastName = (array_key_exists(0, $fullName) ? $fullName[0] : null);
            $firstName = (array_key_exists(1, $fullName) ? $fullName[1] : null);

            $data = [
                'email'      => $ldapUser->email,
                'password'   => $password,
                'username'   => $username,
                'last_name'  => (string) $lastName,
                'first_name' => (string) $firstName,
                'activated'  => 1,
            ];

            $user = $this->sentry->createUser($data, ['all_users', 'customers', 'workers']);
        }

        return $user;
    }
}
