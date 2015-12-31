<?php

namespace Stevebauman\Maintenance\Seeders;

use Adldap\Models\Group;
use Illuminate\Database\Seeder;
use Adldap\Models\User;
use Adldap\Contracts\Adldap;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;

class LdapUserSeeder extends Seeder
{
    /**
     * Holds the current LDAP instance.
     *
     * @var Adldap
     */
    protected $adldap;

    /**
     * Holds the current Sentry instance.
     *
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param Adldap        $adldap
     * @param SentryService $sentry
     * @param ConfigService $config
     */
    public function __construct(Adldap $adldap, SentryService $sentry, ConfigService $config)
    {
        $this->adldap = $adldap;
        $this->sentry = $sentry;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Runs the seeding operation.
     */
    public function run()
    {
        $users = $this->adldap->users()->all();

        foreach ($users as $user) {
            if ($this->syncFiltersEnabled()) {
                if ($this->userAllowed($user)) {
                    $this->createUser($user);
                }

                continue;
            }
        }
    }

    /**
     * Creates a user with Sentry by the supplied corp user object.
     *
     * @param User $user
     *
     * @return bool|User
     */
    private function createUser(User $user)
    {
        $username = $user->getAccountName();
        $email = $user->getEmail();

        if ($username && $email) {
            $data = [
                'email'      => $email,
                'password'   => str_random(20),
                'username'   => $username,
                'last_name'  => $user->getLastName(),
                'first_name' => $user->getFirstName(),
            ];

            $roles = [];

            foreach ($user->getGroups() as $group) {
                if ($group instanceof Group) {
                    $roles[] = $this->sentry->createOrUpdateRole($group->getName());
                }
            }

            $user = $this->sentry->createUser($data, $roles);

            return $user;
        }

        return false;
    }

    /**
     * Check the returned values and make sure
     * they are arrays and that they are enabled.
     *
     * @param User $user
     *
     * @return bool
     */
    private function userAllowed(User $user)
    {
        if (!in_array($user->group, $this->getAllowedGroups())) {
            return false;
        }

        if (!in_array($user->type, $this->getAllowedUserTypes())) {
            return false;
        }

        return true;
    }

    /**
     * Retrieves the allowed user group array from the maintenance config file.
     *
     * @return array
     */
    private function getAllowedGroups()
    {
        return $this->config->get('site.ldap.user_sync.filters.groups');
    }

    /**
     * Retrieves the allows user types array from the maintenance config file.
     *
     * @return array
     */
    private function getAllowedUserTypes()
    {
        return $this->config->get('site.ldap.user_sync.filters.types');
    }

    /**
     * Returns config option of whether or not sync filters are enabled.
     *
     * @return bool
     */
    private function syncFiltersEnabled()
    {
        return $this->config->get('site.ldap.user_sync.filters.enabled');
    }
}
