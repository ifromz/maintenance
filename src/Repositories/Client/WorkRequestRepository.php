<?php

namespace Stevebauman\Maintenance\Repositories\Client;

use Stevebauman\Maintenance\Http\Requests\WorkRequest\Request as WorkRequest;
use Stevebauman\Maintenance\Repositories\CurrentUserRepository;

class WorkRequestRepository
{
    /**
     * @var CurrentUserRepository
     */
    protected $currentUser;

    /**
     * @param CurrentUserRepository $currentUser
     */
    public function __construct(CurrentUserRepository $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function model()
    {
        return $this->currentUser->model()->workRequests();
    }

    /**
     * Creates a user work request.
     *
     * @param WorkRequest $request
     *
     * @return bool|\Stevebauman\Maintenance\Models\WorkRequest
     */
    public function create(WorkRequest $request)
    {
        $attributes = [
            'subject' => $request->input('subject'),
            'description' => $request->clean($request->input('description')),
            'best_time' => $request->input('best_time'),
        ];

        $workRequest = $this->model()->create($attributes);

        if($workRequest) {
            return $workRequest;
        }

        return false;
    }

    /**
     * Updates a users work request.
     *
     * @param WorkRequest $request
     * @param int|string $id
     *
     * @return bool|\Stevebauman\Maintenance\Models\WorkRequest
     */
    public function update(WorkRequest $request, $id)
    {
        $workRequest = $this->model()->find($id);

        if($workRequest) {
            $attributes = [
                'subject' => $request->input('subject', $workRequest->subject),
                'description' => $request->clean($request->input('description', $workRequest->description)),
                'best_time' => $request->input('best_time', $workRequest->best_time),
            ];

            if($workRequest->update($attributes)) {
                return $workRequest;
            }
        }

        return false;
    }

    /**
     * Deletes a work request.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $workRequest = $this->model()->find($id);

        if($workRequest) {
            $workRequest->delete();

            return true;
        }

        return false;
    }
}
