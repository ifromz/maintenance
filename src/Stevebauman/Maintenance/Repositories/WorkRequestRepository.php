<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Http\Requests\WorkRequest\Request;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\WorkRequest;

class WorkRequestRepository extends Repository
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     * @param ConfigService $config
     */
    public function __construct(SentryService $sentry, ConfigService $config)
    {
        $this->sentry = $sentry;
        $this->config = $config;
    }

    /**
     * @return WorkRequest
     */
    public function model()
    {
        return new WorkRequest();
    }

    /**
     * Creates a new work request.
     *
     * @param Request $request
     *
     * @return bool|WorkRequest
     */
    public function create(Request $request)
    {
        $workRequest = $this->model();

        $workRequest->user_id = $this->sentry->getCurrentUserId();
        $workRequest->subject = $request->input('subject');
        $workRequest->best_time = $request->input('best_time');
        $workRequest->description = $request->clean($request->input('description'));

        if($workRequest->save()) {
            $autoGenerate = $this->config->setPrefix('maintenance')->get('rules.work-orders.auto_generate_from_request', true);

            if($autoGenerate) {

            }

            return $workRequest;
        }

        return false;
    }

    /**
     * Updates a work request.
     *
     * @param Request $request
     * @param int|string $id
     *
     * @return bool|WorkRequest
     */
    public function update(Request $request, $id)
    {
        $workRequest = $this->model()->findOrFail($id);

        $workRequest->subject = $request->input('subject', $workRequest->subject);
        $workRequest->best_time = $request->input('best_time', $workRequest->best_time);
        $workRequest->description = $request->clean($request->input('description', $workRequest->description));

        if($workRequest->save()) {
            return $workRequest;
        }

        return false;
    }
}
