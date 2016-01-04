<?php

namespace App\Services;

use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SentryService
{
    /**
     * Authenticate with Sentry.
     *
     * @param array $credentials
     * @param bool  $remember
     *
     * @return array
     */
    public function authenticate($credentials, $remember = null)
    {
        $response = [
            'authenticated' => false,
            'message'       => '',
        ];

        if (Sentinel::authenticate($credentials, $remember)) {
            $response['authenticated'] = true;

            /*
             * Credentials were valid, return authenticated response
             */
            return $response;
        } else {
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
        return auth()->check();
    }

    /**
     * Logout with Sentry.
     *
     * @return bool
     */
    public function logout()
    {
        return auth()->logout();
    }

    /**
     * Create a user through Sentry and add the roles specified to the user
     * if they exist.
     *
     * @param array $data
     * @param array $roles
     * @param bool  $activated
     *
     * @return mixed
     */
    public function createUser(array $data, array $roles = [], $activated = true)
    {
        $insert = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'username'   => $data['username'],
            'password'   => $data['password'],
            'activated'  => $activated,
        ];

        $user = Sentinel::create($insert);

        $this->addRolesToUser($user, $roles);

        return $user;
    }

    /**
     * Registers a user through Sentry.
     *
     * @param array $data
     * @param array $roles
     *
     * @return mixed
     */
    public function registerUser(array $data, array $roles = [])
    {
        $insert = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'username'   => $data['username'],
            'password'   => $data['password'],
        ];

        $user = Sentinel::register($insert);

        $this->addRolesToUser($user, $roles);

        return $user;
    }

    /**
     * Create or update a group through Sentry.
     *
     * If the permissions array is empty it will leave the current permissions intact.
     *
     * @param string $name        The name for the group to find or create
     * @param array  $permissions The permissions to assign the group.
     *
     * @return \App\Models\Role
     */
    public function createOrUpdateRole($name, $permissions = [])
    {
        $role = Sentinel::findRoleByName($name);

        if ($role) {
            if (!empty($permissions)) {
                $role->permissions = $permissions;
                $role->save();
            }
        } else {
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name'        => $name,
                'slug'        => $name,
                'permissions' => $permissions,
            ]);
        }

        return $role;
    }

    /**
     * Update a user password through sentry.
     *
     * @param string|int $id
     * @param string     $password
     *
     * @return bool
     */
    public function updatePasswordById($id, $password)
    {
        $user = $this->findUserById($id);

        $user->password = $password;

        if ($user->save()) {
            return true;
        }

        return false;
    }

    /**
     * Updates a user through Sentry.
     *
     * @param string|int $id
     * @param array      $data
     *
     * @return bool|mixed
     */
    public function update($id, $data = [])
    {
        $user = Sentinel::findUserById($id);

        $user->first_name = array_get($data, 'first_name');
        $user->last_name = array_get($data, 'last_name');
        $user->email = array_get($data, 'email');
        $user->username = array_get($data, 'username');

        $permissions = array_get($data, 'routes');

        $sentryPermissions = [];

        // Parse the users submitted permissions
        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $sentryPermissions[$permission] = 1;
            }

            $user->permissions = $sentryPermissions;
        }

        if ($user->save()) {
            return $user;
        }

        return false;
    }

    /**
     * Find a user through Sentry by their ID.
     *
     * @param int|string $id
     *
     * @return bool|\App\Models\User
     */
    public function findUserById($id)
    {
        return User::find($id);
    }

    /**
     * Returns current authenticated user.
     *
     * @return mixed
     */
    public function getCurrentUser()
    {
        return auth()->user();
    }

    /**
     * Returns current authenticated users full name.
     *
     * @return null|string
     */
    public function getCurrentUserFullName()
    {
        $user = Sentinel::getUser();

        if ($user) {
            $fullName = sprintf('%s %s', $user->first_name, $user->last_name);

            return $fullName;
        }

        return;
    }

    /**
     * Returns current authenticated user ID.
     *
     * @return null|int
     */
    public function getCurrentUserId()
    {
        $user = $this->getCurrentUser();

        if ($user) {
            return $user->id;
        }

        return;
    }

    /**
     * Adds the array of roles to the specified user.
     *
     * @param \App\Models\User $user
     * @param array                                $roles
     *
     * @return bool
     */
    private function addRolesToUser($user, array $roles = [])
    {
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                $role = Sentinel::findRoleByName($role);

                if ($role) {
                    $user->addRole($role);
                }
            }

            return true;
        }

        return false;
    }
}
