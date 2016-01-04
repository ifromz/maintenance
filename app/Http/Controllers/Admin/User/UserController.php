<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Displays a list of all users.
     *
     * @return mixed
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Displays the form for creating a user.
     *
     * @return mixed
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Processes creating a new user.
     *
     * @param CreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $user = $this->user->create($request);

        if ($user) {
            $message = 'Successfully created user.';

            return redirect()->route('maintenance.admin.users.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating a user. Please try again.';

            return redirect()->route('maintenance.admin.users.create')->withErrors($message);
        }
    }

    /**
     * Displays the user with the specified ID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->user->find($id);

        return view('admin.users.show', [
            'title' => 'Viewing User',
            'user'  => $user,
        ]);
    }

    /**
     * Displays the form for editing the user with the specified ID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->user->find($id);

        return view('admin.users.edit', [
            'title' => 'Editing User',
            'user'  => $user,
        ]);
    }

    /**
     * Processes updating the user with the specified ID.
     *
     * @param UpdateRequest $request
     * @param int|string    $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $user = $this->user->update($request, $id);

        if ($user) {
            $message = 'Successfully updated user.';

            return redirect()->route('maintenance.admin.users.index')->withSuccess($message);
        } else {
            $message = 'There was an issue updating this user. Please try again.';

            return redirect()->route('maintenance.admin.users.edit', [$id])->withErrors($message);
        }
    }

    /**
     * Deletes the user with the specified ID.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = $this->user->model()->findOrFail($id);

        if ($user->delete()) {
            $message = 'Successfully deleted user.';

            return redirect()->route('maintenance.admin.users.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this user. Please try again.';

            return redirect()->route('maintenance.admin.users.show', [$id])->withErrors($message);
        }
    }
}
