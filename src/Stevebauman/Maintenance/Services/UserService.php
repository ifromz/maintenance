<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\User;

/**
 * Class UserService
 * @package Stevebauman\Maintenance\Services
 */
class UserService extends BaseModelService
{

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var LdapService
     */
    protected $ldap;

    /**
     * @param User $user
     * @param SentryService $sentry
     * @param LdapService $ldap
     */
    public function __construct(User $user, SentryService $sentry, LdapService $ldap)
    {
        $this->model = $user;
        $this->sentry = $sentry;
        $this->ldap = $ldap;
    }

    /**
     * Returns a filtered and paginated collection of users
     *
     * @return mixed
     */
    public function getByPageWithFilter()
    {
        return $this->model
            ->id($this->getInput('id'))
            ->name($this->getInput('name'))
            ->username($this->getInput('username'))
            ->email($this->getInput('email'))
            ->paginate(25);
    }

    public function create()
    {
        $this->dbStartTransaction();

        $activated = $this->getInput('activated');

        $insert = array(
            'username' => $this->getInput('username'),
            'email' => $this->getInput('email'),
            'password' => $this->getInput('password'),
            'permissions' => $this->getInput('permissions', array()),
            'activated' => ($activated ? true : false)
        );

        $record = $this->sentry->createUser($insert);

        if($record)
        {
            $this->dbCommitTransaction();

            return $record;
        }

        return false;
    }

    /**
     * Create or Update a User for authentication for use with ldap
     *
     * @author Steve Bauman
     *
     * @param $credentials
     * @return void
     */
    public function createOrUpdateUser($credentials)
    {
        $loginAttribute = config('cartalyst/sentry::users.login_attribute');

        $username = $credentials[$loginAttribute];
        $password = $credentials['password'];

        /*
         * If a user is found, update their password to match active-directory
         */
        $user = $this->model->where('username', $username)->first();

        if ($user)
        {
            $this->sentry->updatePasswordById($user->id, $password);
        } else
        {
            /*
             * If a user is not found, create their web account
             */
            $ldapUser = $this->ldap->user($username);

            $fullName = explode(',', $ldapUser->name);
            $lastName = (array_key_exists(0, $fullName) ? $fullName[0] : NULL);
            $firstName = (array_key_exists(1, $fullName) ? $fullName[1] : NULL);

            $data = array(
                'email' => $ldapUser->email,
                'password' => $password,
                'username' => $username,
                'last_name' => (string)$lastName,
                'first_name' => (string)$firstName,
            );

            $user = $this->sentry->createUser($data);
        }

        return $user;
    }

}