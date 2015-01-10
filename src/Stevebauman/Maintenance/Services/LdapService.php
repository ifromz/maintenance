<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Corp\Facades\Corp;

class LdapService
{

    /**
     * Authenticate with Corp
     *
     * @author Steve Bauman
     *
     * @param $username , $password
     * @return boolean
     */
    public function authenticate($username, $password)
    {
        if (Corp::auth($username, $password)) {
            return true;
        }

        return false;
    }

    /**
     * Returns an array of all users in the current LDAP connection
     *
     * @return array
     */
    public function users()
    {
        return Corp::users();
    }

    /**
     * Returns Corp user object
     *
     * @param string $username
     * @return object
     */
    public function user($username)
    {
        return Corp::user($username);
    }

    /**
     * Return an LDAP user email address
     *
     * @author Steve Bauman
     *
     * @param $username
     * @return mixed
     */
    public function getUserEmail($username)
    {
        $user = Corp::user($username);

        if ($user) {
            return $user->email;
        }

        return false;
    }

    /**
     * Return an LDAP user full name
     *
     * @author Steve Bauman
     *
     * @param $username
     * @return mixed
     */
    public function getUserFullName($username)
    {
        $user = Corp::user($username);

        if ($user) {
            return $user->name;
        }

        return false;
    }
}