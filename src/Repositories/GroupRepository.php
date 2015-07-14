<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Http\Requests\Admin\GroupRequest;
use Stevebauman\Maintenance\Models\Group;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class GroupRepository extends BaseRepository
{
    /**
     * @return Group
     */
    public function model()
    {
        return new Group();
    }

    /**
     * Creates a new group.
     *
     * @param GroupRequest $request
     *
     * @return bool|Group
     */
    public function create(GroupRequest $request)
    {
        $group = $this->model();

        $group->name = $request->input('name');
        $group->permissions = $this->routesToPermissions($request->input('permissions', []));

        if($group->save()) {
            $users = $request->input('users');

            if ($users) {
                $group->users()->sync($request->input('users'));
            }

            return $group;
        }

        return false;
    }

    /**
     * Updates a group.
     *
     * @param GroupRequest $request
     * @param int|string   $id
     *
     * @return bool|Group
     */
    public function update(GroupRequest $request, $id)
    {
        $group = $this->model()->findOrFail($id);

        if($group) {
            $group->name = $request->input('name', $group->name);

            $updatedPermissions = $request->input('permissions', []);

            /*
             * Check if the permissions current on the group exist in the updated array
             */
            foreach ($group->permissions as $permission => $allowed) {
                /*
                 * If the permission currently inside the group does not
                 * exist in the updated array, we need to add it to the array
                 * and set it to 0 to tell Sentry to remove it
                 */
                if (!array_key_exists($permission, $updatedPermissions)) {
                    $updatedPermissions[$permission] = 0;
                }
            }

            $group->permissions = $updatedPermissions;

            if($group->save()) {
                $group->users()->sync($request->input('users', []));

                return $group;
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
                $permissions[$route] = 1;
            }
        }

        return $permissions;
    }
}
