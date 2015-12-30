<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Http\Requests\Admin\RoleRequest;
use Stevebauman\Maintenance\Models\Role;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class RoleRepository extends BaseRepository
{
    /**
     * @return Role
     */
    public function model()
    {
        return new Role();
    }

    /**
     * Creates a new role.
     *
     * @param RoleRequest $request
     *
     * @return bool|Role
     */
    public function create(RoleRequest $request)
    {
        $role = $this->model();

        $role->name = $request->input('name');
        $role->permissions = $this->routesToPermissions($request->input('permissions', []));

        if ($role->save()) {
            $users = $request->input('users');

            if ($users) {
                $role->users()->sync($request->input('users'));
            }

            return $role;
        }

        return false;
    }

    /**
     * Updates a role.
     *
     * @param RoleRequest $request
     * @param int|string  $id
     *
     * @return bool|Role
     */
    public function update(RoleRequest $request, $id)
    {
        $role = $this->model()->findOrFail($id);

        if ($role) {
            $role->name = $request->input('name', $role->name);

            $updatedPermissions = $request->input('permissions', []);

            /*
             * Check if the permissions current on the group exist in the updated array
             */
            foreach ($role->permissions as $permission => $allowed) {
                /*
                 * If the permission currently inside the group does not
                 * exist in the updated array, we need to add it to the array
                 * and set it to 0 to tell Sentry to remove it
                 */
                if (!array_key_exists($permission, $updatedPermissions)) {
                    $updatedPermissions[$permission] = false;
                }
            }

            $role->permissions = $updatedPermissions;

            if ($role->save()) {
                $role->users()->sync($request->input('users', []));

                return $role;
            }
        }

        return false;
    }

    /**
     * Converts the submitted route array key values to 1 for sentry.
     *
     * @param null $routes
     *
     * @return array
     */
    private function routesToPermissions($routes = null)
    {
        $permissions = [];

        /*
         * If routes are provided, set the route value key to 1,
         * indicating that the user has permission in Sentry
         */
        if ($routes) {
            foreach ($routes as $route) {
                $permissions[$route] = true;
            }
        }

        return $permissions;
    }
}
