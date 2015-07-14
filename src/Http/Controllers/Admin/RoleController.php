<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin;

use Stevebauman\Maintenance\Http\Requests\Admin\RoleRequest;
use Stevebauman\Maintenance\Repositories\RoleRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * Constructor.
     *
     * @param RoleRepository $role
     */
    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * Displays the view of all the user roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::admin.roles.index');
    }

    /**
     * Displays the view to create a user role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::admin.roles.create');
    }

    /**
     * Processes the creation of a user role.
     *
     * @param RoleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $role = $this->role->create($request);

        if($role) {
            $message = 'Successfully created role.';

            return redirect()->route('maintenance.admin.roles.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating a new role. Please try again.';

            return redirect()->route('maintenance.admin.roles.create')->withErrors($message);
        }
    }

    /**
     * Displays the specified user role.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = $this->role->model()->findOrFail($id);

        return view('maintenance::admin.roles.show', compact('role'));
    }

    /**
     * Displays the form to edit the specified user role.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->role->model()->findOrFail($id);

        return view('maintenance::admin.roles.edit', compact('role'));
    }

    /**
     * Processes updating the specified user role.
     *
     * @param RoleRequest $request
     * @param int|string   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, $id)
    {
        $role = $this->role->update($request, $id);

        if($role) {
            $message = 'Successfully updated role.';

            return redirect()->route('maintenance.admin.roles.show', [$role->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this role. Please try again.';

            return redirect()->route('maintenance.admin.roles.edit', [$id])->withSuccess($message);
        }
    }

    /**
     * Processes deleting the specified user role.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $role = $this->role->model()->findOrFail($id);

        $role->users()->detach();

        if($role->delete()) {
            $message = 'Successfully deleted role.';

            return redirect()->route('maintenance.admin.roles.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this role. Please try again.';

            return redirect()->route('maintenance.admin.roles.show', [$role->id])->withSuccess($message);
        }
    }
}
