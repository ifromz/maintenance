<?php

namespace Stevebauman\Maintenance\Repositories\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\WorkOrder\PriorityRequest;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Priority;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class PriorityRepository extends BaseRepository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * @return Priority
     */
    public function model()
    {
        return new Priority();
    }

    /**
     * Creates a new status.
     *
     * @param PriorityRequest $request
     *
     * @return bool|Priority
     */
    public function create(PriorityRequest $request)
    {
        $priority = $this->model();

        $priority->user_id = $this->sentry->getCurrentUserId();
        $priority->name = $request->input('name');
        $priority->color = $request->input('color');

        if($priority->save()) {
            return $priority;
        }

        return false;
    }

    /**
     * Creates or retrieves a defaulted requested priority.
     *
     * @return bool|Priority
     */
    public function createDefaultRequested()
    {
        $priority = $this->model()->firstOrCreate([
            'name' => 'Requested',
            'color' => 'default',
        ]);

        if($priority) {
            return $priority;
        }

        return false;
    }

    /**
     * Updates a status.
     *
     * @param PriorityRequest $request
     * @param int|string    $id
     *
     * @return bool|Priority
     */
    public function update(PriorityRequest $request, $id)
    {
        $priority = $this->model()->findOrFail($id);

        if($priority) {
            $priority->name = $request->input('name', $priority->name);
            $priority->color = $request->input('color', $priority->color);

            if($priority->save()) {
                return $priority;
            }
        }

        return false;
    }
}
