<?php

namespace Stevebauman\Maintenance\Repositories\WorkOrder;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class Repository extends BaseRepository
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
     * @return WorkOrder
     */
    public function model()
    {
        return new WorkOrder();
    }
}