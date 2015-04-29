<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Corp\Objects\User;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\LdapService;
use Illuminate\Database\Seeder;

/**
 * Class LdapUserSeeder
 * @package Stevebauman\Maintenance\Seeders
 */
class LdapUserSeeder extends Seeder
{
    /**
     * Holds the current LDAP instance
     *
     * @var LdapService
     */
    protected $ldap;

    /**
     * Holds the current Sentry instance
     *
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param LdapService $ldap
     * @param SentryService $sentry
     * @param ConfigService $config
     */
    public function __construct(LdapService $ldap, SentryService $sentry, ConfigService $config)
    {
        $this->ldap = $ldap;
        $this->sentry = $sentry;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Runs the seeding operation
     *
     * @return void
     */
    public function run()
    {
        $users = $this->ldap->users();

        foreach($users as $user)
        {
            if($this->syncFiltersEnabled())
            {
                if($this->userAllowed($user)) $this->createUser($user);

                continue;
            }
        }
    }

    /**
     * Creates a user with Sentry by the supplied corp user object
     *
     * @param User $user
     * @return bool|mixed|User
     */
    private function createUser(User $user)
    {
        if($user->username && $user->email)
        {
            $first_name = '';

            $last_name = '';

            /*
             * An LDAP user may not have a name, so we'll explode it by a comma to see if they have
             * a fully separated name
             */
            if($user->name)
            {
                $name = explode(',', $user->name);

                if(array_key_exists(0, $name)) $last_name = $name[0];

                if(array_key_exists(1, $name)) $first_name = $name[1];
            }

            $data = [
                'email'    => $user->email,
                'password' => str_random(20),
                'username' => $user->username,
                'last_name' => $last_name,
                'first_name' => $first_name,
            ];

            $groups = [];

            if($user->group)
            {
                $groups[] = $this->sentry->createOrUpdateGroup($user->group);
            }

            if($user->type)
            {
                $groups[] = $this->sentry->createOrUpdateGroup($user->type);
            }

            $user = $this->sentry->createUser($data, $groups);

            return $user;
        }

        return false;
    }

    /**
     * Check the returned values and make sure they are arrays and that they are enabled
     *
     * @param User $user
     * @return bool
     */
    private function userAllowed(User $user)
    {
        if(!in_array($user->group, $this->getAllowedGroups())) return false;

        if(!in_array($user->type, $this->getAllowedUserTypes())) return false;

        return true;
    }

    /**
     * Retrieves the allowed user group array from the maintenance config file
     *
     * @return array
     */
    private function getAllowedGroups()
    {
        return $this->config->get('site.ldap.user_sync.filters.groups');
    }

    /**
     * Retrieves the allows user types array from the maintenance config file
     *
     * @return array
     */
    private function getAllowedUserTypes()
    {
        return $this->config->get('site.ldap.user_sync.filters.types');
    }

    /**
     * Returns config option of whether or not sync filters are enabled
     *
     * @return bool
     */
    private function syncFiltersEnabled()
    {
        return $this->config->get('site.ldap.user_sync.filters.enabled');
    }

}