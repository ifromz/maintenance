<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin;

use Stevebauman\Maintenance\Http\Requests\Admin\GroupRequest;
use Stevebauman\Maintenance\Repositories\GroupRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * @var GroupRepository
     */
    protected $group;

    /**
     * Constructor.
     *
     * @param GroupRepository $group
     */
    public function __construct(GroupRepository $group)
    {
        $this->group = $group;
    }

    /**
     * Displays the view of all the user groups.
     *
     * @return mixed
     */
    public function index()
    {
        return view('maintenance::admin.groups.index');
    }

    /**
     * Displays the view to create a user group.
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::admin.groups.create', [
            'title' => 'Create a Group',
        ]);
    }

    /**
     * Processes the creation of a user group.
     *
     * @param GroupRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GroupRequest $request)
    {
        $group = $this->group->create($request);

        if($group) {
            $message = 'Successfully created group.';

            return redirect()->route('maintenance.admin.groups.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating a new group. Please try again.';

            return redirect()->route('maintenance.admin.groups.create')->withErrors($message);
        }
    }

    /**
     * Displays the specified user group.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $group = $this->group->model()->findOrFail($id);

        return view('maintenance::admin.groups.show', compact('group'));
    }

    /**
     * Displays the form to edit the specified user group.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $group = $this->group->model()->findOrFail($id);

        return view('maintenance::admin.groups.edit', compact('group'));
    }

    /**
     * Processes updating the specified user group.
     *
     * @param GroupRequest $request
     * @param int|string   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GroupRequest $request, $id)
    {
        $group = $this->group->update($request, $id);

        if($group) {
            $message = 'Successfully updated group.';

            return redirect()->route('maintenance.admin.groups.show', [$group->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this group. Please try again.';

            return redirect()->route('maintenance.admin.groups.edit', [$id])->withSuccess($message);
        }
    }

    /**
     * Processes deleting the specified user group.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $group = $this->group->model()->findOrFail($id);

        if($group) {
            $group->users()->detach();

            if($group->delete()) {
                $message = 'Successfully deleted group.';

                return redirect()->route('maintenance.admin.groups.index')->withSuccess($message);
            } else {
                $message = 'There was an issue deleting this group. Please try again.';

                return redirect()->route('maintenance.admin.groups.show', [$group->id])->withSuccess($message);
            }
        } else {
            abort(404);
        }
    }
}
