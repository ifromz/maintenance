<?php

namespace Stevebauman\Maintenance\Services;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Stevebauman\CoreHelper\Services\Auth\SentryService as BaseSentryService;

class SentryService extends BaseSentryService
{
    /**
     * Authenticate with Sentry.
     *
     * @param array $credentials
     * @param bool $remember
     *
     * @return array
     */
    public function authenticate($credentials, $remember = NULL)
    {
        $response = [
            'authenticated' => false,
            'message' => '',
        ];

        /*
         * Try to log in the user with sentry
         */
        try
        {
            Sentry::authenticate($credentials, $remember);

            $response['authenticated'] = true;

            /*
             * Credentials were valid, return authenticated response
             */
            return $response;

        } catch (WrongPasswordException $e)
        {
            $response['message'] = 'Username or Password is incorrect.';
        } catch (UserNotActivatedException $e)
        {
            $response['message'] = 'Your account has not been activated.
                Please follow the link you were emailed to activate your account.';
        } catch (UserSuspendedException $e)
        {
            $response['message'] = 'Your account has been suspended. Please try again later.';
        } catch (UserBannedException $e)
        {
            $response['message'] = 'Your account has been permanently banned.';
        } catch (UserExistsException $e)
        {
            $response['message'] = 'Username or Password is incorrect.';
        } catch (UserNotFoundException $e)
        {
            $response['message'] = 'Username or Password is incorrect.';
        }

        return $response;
    }

    /**
     * Returns true / false if the current user is logged in.
     *
     * @return bool
     */
    public function check()
    {
        return Sentry::check();
    }

    /**
     * Logout with Sentry.
     *
     * @return bool
     */
    public function logout()
    {
        return Sentry::logout();
    }

    /**
     * Create a user through Sentry and add the groups specified to the user
     * if they exist.
     *
     * @param array  $data
     * @param array  $groups
     * @param bool   $activated
     *
     * @return mixed
     */
    public function createUser(array $data, array $groups = [], $activated = true)
    {
        try
        {
            $insert = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $data['password'],
                'activated' => $activated,
            ];

            $user = Sentry::createUser($insert);

            $this->addGroupsToUser($user, $groups);

        } catch (UserExistsException $e)
        {
            $loginAttribute = config('cartalyst.sentry.users.login_attribute');

            $user = Sentry::findUserByLogin($data[$loginAttribute]);
        }

        return $user;
    }

    /**
     * Registers a user through Sentry.
     *
     * @param array $data
     * @param array $groups
     *
     * @return mixed
     */
    public function registerUser(array $data, array $groups = [])
    {
        try {
            $insert = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $data['password'],
            ];

            $user = Sentry::register($insert);

            $this->addGroupsToUser($user, $groups);

        } catch (UserExistsException $e)
        {
            $loginAttribute = config('cartalyst.sentry.users.login_attribute');

            $user = Sentry::findUserByLogin($data[$loginAttribute]);
        }

        return $user;
    }

    /**
     * Create or update a group through Sentry.
     *
     * If the permissions array is empty it will leave the current permissions intact.
     *
     * @param string $name The name for the group to find or create
     * @param array $permissions The permissions to assign the group.
     *
     * @return mixed
     */
    public function createOrUpdateGroup($name, $permissions = [])
    {
        try
        {
            /*
             * Group already exists, lets try and update the permissions
             * if we were supplied any
             */
            $group = Sentry::findGroupByName($name);

            if (! empty($permissions))
            {
                $group->permissions = $permissions;
                $group->save();
            }

        } catch (GroupNotFoundException $e)
        {
            /*
             * If the group does not exist, we'll create it and assign
             * the permissions
             */
            $group = Sentry::createGroup([
                'name' => $name,
                'permissions' => $permissions,
            ]);
        }

        return $group;
    }

    /**
     * Update a user password through sentry.
     *
     * @param string|int $id
     * @param string $password
     *
     * @return bool
     */
    public function updatePasswordById($id, $password)
    {
        $user = $this->findUserById($id);

        $user->password = $password;

        if ($user->save()) return true;

        return false;
    }

    /**
     * Updates a user through Sentry.
     *
     * @param string|int $id
     * @param array $data
     *
     * @return bool|mixed
     */
    public function update($id, $data = [])
    {
        try
        {
            $user = Sentry::findUserById($id);

            $user->first_name = array_get($data, 'first_name');
            $user->last_name = array_get($data, 'last_name');
            $user->email = array_get($data, 'email');
            $user->username = array_get($data, 'username');

            $permissions = array_get($data, 'routes');

            $sentryPermissions = [];

            // Parse the users submitted permissions
            if(count($permissions) > 0) {
                foreach($permissions as $permission) {
                    $sentryPermissions[$permission] = 1;
                }

                $user->permissions = $sentryPermissions;
            }

            if($user->save())
            {
                return $user;
            }
        } catch (UserExistsException $e)
        {
        } catch(UserNotFoundException $e)
        {
        }

        return false;
    }

    /**
     * Find a user through Sentry by their ID.
     *
     * @param string|int $id
     *
     * @return bool|mixed
     */
    public function findUserById($id)
    {
        try
        {
            $user = Sentry::findUserById($id);

            return $user;
        } catch (UserNotFoundException $e)
        {
            return false;
        }
    }

    /**
     * Find a user through Sentry by their login attribute,
     * such as a username or email.
     *
     * @param string $login
     *
     * @return bool|mixed
     */
    public function findUserByLogin($login)
    {
        try
        {
            $user = Sentry::findUserByLogin($login);

            return $user;
        } catch(UserNotFoundException $e)
        {
            return false;
        }
    }

    /**
     * Returns current authenticated user.
     *
     * @return mixed
     */
    public function getCurrentUser()
    {
        return Sentry::getUser();
    }

    /**
     * Returns current authenticated users full name
     *
     * @return string
     */
    public function getCurrentUserFullName()
    {
        $user = Sentry::getUser();

        $fullName = sprintf('%s %s', $user->first_name, $user->last_name);

        return $fullName;
    }

    /**
     * Returns current authenticated user ID
     *
     * @return int
     */
    public function getCurrentUserId()
    {
        $user = Sentry::getUser();

        return $user->id;
    }

    /**
     * Adds the array of groups to the specified user.
     *
     * @param \Cartalyst\Sentry\Users\Eloquent\User $user
     * @param array                                 $groups
     *
     * @return bool
     */
    private function addGroupsToUser($user, array $groups = [])
    {
        if (count($groups) > 0)
        {
            foreach ($groups as $group)
            {
                try
                {
                    $group = Sentry::findGroupByName($group);

                    $user->addGroup($group);

                } catch (GroupNotFoundException $e)
                {
                }
            }

            return true;
        }

        return false;
    }
}
