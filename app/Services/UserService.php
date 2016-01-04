<?php

namespace App\Services;

use Adldap\Contracts\Adldap;
use Adldap\Models\Group;
use Adldap\Models\User as LdapUser;
use App\Models\User;

class UserService extends BaseModelService
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param User          $user
     * @param SentryService $sentry
     * @param Adldap        $adldap
     * @param ConfigService $config
     */
    public function __construct(
        User $user,
        SentryService $sentry,
        Adldap $adldap,
        ConfigService $config
    ) {
        $this->model = $user;
        $this->sentry = $sentry;
        $this->adldap = $adldap;
        $this->config = $config;
    }

    /**
     * Returns a filtered and paginated collection of users.
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

    /**
     * Creates a user through sentry.
     *
     * @return bool|mixed
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $activated = $this->getInput('activated');

            $insert = [
                'username'    => $this->getInput('username'),
                'email'       => $this->getInput('email'),
                'password'    => $this->getInput('password'),
                'permissions' => $this->getInput('permissions', []),
                'activated'   => ($activated ? true : false),
            ];

            $record = $this->sentry->createUser($insert);

            /*
             * Due to sentry restrictions, we'll update
             * the additional user information manually
             */
            $modelRecord = $this->model->find($record->id);

            $insertAdditional = [
                'first_name' => $this->getInput('first_name'),
                'last_name'  => $this->getInput('last_name'),
            ];

            $modelRecord->update($insertAdditional);

            if ($record) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Create or Update a User for authentication for use with ldap.
     *
     * @param array $credentials
     *
     * @return \Cartalyst\Sentry\Users\Eloquent\User
     */
    public function createOrUpdateLdapUser(array $credentials)
    {
        $loginAttribute = $this->config->setPrefix('cartalyst.sentry')->get('users.login_attribute');

        $username = $credentials[$loginAttribute];
        $password = $credentials['password'];

        // If a user is found, update their password to match active-directory
        $user = $this->model->where('username', $username)->first();

        if ($user) {
            $this->sentry->updatePasswordById($user->id, $password);
        } else {
            // If a user is not found in the database, create their web account
            $ldapUser = $this->adldap->users()->find($username);

            if ($ldapUser instanceof LdapUser) {
                $data = [
                    'email'      => $ldapUser->getEmail(),
                    'username'   => $username,
                    'password'   => $password,
                    'last_name'  => $ldapUser->getLastName(),
                    'first_name' => $ldapUser->getFirstName(),
                    'activated'  => 1,
                ];

                // Default all group
                $roles = ['all' => 'all'];

                // Go through each user group and determine their permissions.
                foreach ($ldapUser->getGroups() as $group) {
                    if ($group instanceof Group) {
                        $name = $group->getName();

                        if (in_array($name, config('maintenance.groups.ldap.administrators'))) {
                            $roles['administrators'] = 'administrators';
                        } elseif (in_array($name, config('maintenance.groups.ldap.workers'))) {
                            $roles['workers'] = 'workers';
                        } else {
                            $roles['client'] = 'client';
                        }
                    }
                }

                $user = $this->sentry->createUser($data, $roles);
            }
        }

        return $user;
    }

    /**
     * Processes updating a user.
     *
     * @param int|string $id
     *
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function update($id)
    {
        try {
            $this->dbStartTransaction();

            // Update the user through Sentry first.
            $this->sentry->update($id, $this->input);

            // Now we'll update the extra user details Sentry doesn't manage.
            $user = $this->model->find($id);

            $insert = [
                'first_name' => $this->getInput('first_name'),
                'last_name'  => $this->getInput('last_name'),
            ];

            if ($user->update($insert)) {
                $this->dbCommitTransaction();

                return $user;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
