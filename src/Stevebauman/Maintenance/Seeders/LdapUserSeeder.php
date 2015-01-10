<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\LdapService;
use Illuminate\Database\Seeder;

class LdapUserSeeder extends Seeder {

    /*
     * Holds the current LDAP instance
     */
    private $ldap;

    /*
     * Holds the current Sentry instance
     */
    private $sentry;

    public function __construct(LdapService $ldap, SentryService $sentry)
    {
        $this->ldap = $ldap;
        $this->sentry = $sentry;
    }

    /**
     * Runs the seeding operation
     */
    public function run()
    {
        $users = $this->ldap->users();

        foreach($users as $user) {

            if($this->syncFiltersEnabled()) {

                if($this->userAllowed($user)) {

                    $this->createUser($user);

                } else {

                    continue;

                }

            }

        }
    }

    /**
     * Creates a user with Sentry
     *
     * @param \Stevebauman\Corp\Objects\User $user
     */
    private function createUser(\Stevebauman\Corp\Objects\User $user)
    {
        if($user->username && $user->email) {

            $first_name = '';

            $last_name = '';

            /*
             * An LDAP user may not have a name, so we'll explode it by a comma to see if they have
             * a fully separated name
             */
            if($user->name) {
                $name = explode(',', $user->name);

                if(array_key_exists(0, $name)) {
                    $last_name = $name[0];
                }

                if(array_key_exists(1, $name)) {
                    $first_name = $name[1];
                }
            }

            $data = array(
                'email'    => $user->email,
                'password' => str_random(20),
                'username' => $user->username,
                'last_name' => $last_name,
                'first_name' => $first_name,
            );

            $groups = array();

            if($user->group) {
                $groups[] = $this->sentry->createOrUpdateGroup($user->group);
            }

            if($user->type) {
                $groups[] = $this->sentry->createOrUpdateGroup($user->type);
            }

            $this->sentry->createUser($data, $groups);

        }
    }

    /**
     * Check the returned values and make sure they are arrays and that they are enabled
     *
     * @param \Stevebauman\Corp\Objects\User $user
     * @return boolean
     */
    private function userAllowed(\Stevebauman\Corp\Objects\User $user)
    {
        if(!in_array($user->group, $this->getAllowedGroups())){
            return false;
        }

        if(!in_array($user->type, $this->getAllowedUserTypes())){
            return false;
        }

        return true;
    }

    /**
     * Retrieves the allowed user group array from the maintenance config file
     *
     * @return array
     */
    private function getAllowedGroups()
    {
        return config('maintenance::site.ldap.user_sync.filters.groups');
    }

    /**
     * Retrieves the allows user types array from the maintenance config file
     *
     * @return array
     */
    private function getAllowedUserTypes()
    {
        return config('maintenance::site.ldap.user_sync.filters.types');
    }

    /**
     * Returns config option of wether or not sync filters are enabled or not
     *
     * @return boolean
     */
    private function syncFiltersEnabled()
    {
        return config('maintenance::site.ldap.user_sync.filters.enabled');
    }

}