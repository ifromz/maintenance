<?php

namespace App\Services;

use Adldap\Contracts\Adldap;

class LdapService
{
    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * Constructor.
     *
     * @param Adldap $adldap
     */
    public function __construct(Adldap $adldap)
    {
        $this->adldap = $adldap;
    }

    /**
     * Authenticate with Corp.
     *
     * @author Steve Bauman
     *
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public function authenticate($username, $password)
    {
        return $this->adldap->authenticate($username, $password);
    }

    /**
     * Returns an array of all users in the current LDAP connection.
     *
     * @return array
     */
    public function users()
    {
        return $this->adldap->users()->all();
    }

    /**
     * Finds a user.
     *
     * @param string $username
     *
     * @return \Adldap\Models\User
     */
    public function user($username)
    {
        return $this->adldap->users()->find($username);
    }

    /**
     * Return an LDAP user email address.
     *
     * @author Steve Bauman
     *
     * @param $username
     *
     * @return mixed
     */
    public function getUserEmail($username)
    {
        $user = $this->user($username);

        if ($user) {
            return $user->email;
        }

        return false;
    }

    /**
     * Return an LDAP user full name.
     *
     * @author Steve Bauman
     *
     * @param $username
     *
     * @return mixed
     */
    public function getUserFullName($username)
    {
        $user = $this->user($username);

        if ($user) {
            return $user->name;
        }

        return false;
    }
}
