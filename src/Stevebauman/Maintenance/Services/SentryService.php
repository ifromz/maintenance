<?php

namespace Stevebauman\Maintenance\Services;

use Illuminate\Support\Facades\Config;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

class SentryService
{

    /**
     * Authenticate with Sentry
     *
     * @author Steve Bauman
     *
     * @param $credentials , $remember
     * @return Array
     */
    public function authenticate($credentials, $remember = NULL)
    {
        $response = array(
            'authenticated' => false,
            'message' => '',
        );

        // Try to log in the user with sentry
        try {

            Sentry::authenticate($credentials, $remember);
            $response['authenticated'] = true;

            // Log in was goood, return authenticated response
            return $response;

        } catch (WrongPasswordException $e) {
            $response['message'] = 'Username or Password is incorrect.';
        } catch (UserNotActivatedException $e) {
            $response['message'] = 'User has not been activated';
        } catch (UserSuspendedException $e) {
            $response['message'] = 'Your account has been suspended. Please try again later.';
        } catch (UserBannedException $e) {
            $response['message'] = 'Your account has been permanetly banned';
        } catch (UserExistsException $e) {
            $response['message'] = 'Username or Password is incorrect.';
        } catch (UserNotFoundException $e) {
            $response['message'] = 'Username or Password is incorrect.';
        }

        return $response;
    }

    /**
     * Logout with Sentry
     *
     * @author Steve Bauman
     *
     * @return void
     */
    public function logout()
    {
        Sentry::logout();
    }

    /**
     * Create a user through Sentry
     *
     * @author Steve Bauman
     *
     * @param $data
     * @return void
     */
    public function createUser($data, $groups = NULL)
    {
        try {

            $user = Sentry::getUserProvider()->create(array(
                'email' => $data['email'],
                'password' => $data['password'],
                'username' => $data['username'],
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
            ));

            $activationCode = $user->getActivationCode();
            $user->attemptActivation($activationCode);

            if (isset($groups)) {

                foreach ($groups as $group) {

                    try {

                        $group = Sentry::findGroupByName($group);

                        $user->addGroup($group);

                    } catch (GroupNotFoundException $e) {

                    }
                }

            }


        } catch (UserExistsException $e) {
            $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');

            $user = Sentry::findUserByLogin($data[$login_attribute]);

        }

        return $user;
    }


    /**
     * Create or update a group through Sentry
     *
     * @author Steve Bauman
     *
     * @param string $name The name for the group to find or create
     * @param array $permissions The permissions to assign the group.
     * If the array is empty it will leave the current permissions intact.
     */
    public function createOrUpdateGroup($name, $permissions = array())
    {

        try {

            $group = Sentry::findGroupByName($name);

            if (!empty($permissions)) {
                $group->permissions = $permissions;
                $group->save();
            }

        } catch (GroupNotFoundException $e) {

            $group = Sentry::createGroup(array(
                'name' => $name,
                'permissions' => $permissions,
            ));

        }

        return $group;
    }

    /**
     * Update a user password through sentry
     *
     * @author Steve Bauman
     *
     * @param $id , $password
     * @return boolean
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
     * Find a user through Sentry
     *
     * @author Steve Bauman
     *
     * @param $id
     * @return mixed
     */
    public function findUserById($id)
    {
        try {

            $user = Sentry::findUserById($id);

            return $user;

        } catch (UserNotFoundException $e) {
            return false;
        }
    }

    /**
     * Returns current authenticated user
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function getCurrentUser()
    {
        return Sentry::getUser();
    }


    /**
     * Returns current authenticated users full name
     *
     * @author Steve Bauman
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
     * @author Steve Bauman
     *
     * @return integer
     */
    public function getCurrentUserId()
    {
        $user = Sentry::getUser();

        return $user->id;
    }

}