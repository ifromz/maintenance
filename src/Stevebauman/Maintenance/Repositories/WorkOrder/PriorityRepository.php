<?php

namespace Stevebauman\Maintenance\Repositories\WorkOrder;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\Priority;
use Stevebauman\Maintenance\Repositories\Repository;

class PriorityRepository extends Repository
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
}
