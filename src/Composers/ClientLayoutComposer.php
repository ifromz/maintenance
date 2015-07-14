<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;

class ClientLayoutComposer
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
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $siteTitle = $this->config->get('site.title.client');
        $currentUser = $this->sentry->getCurrentUser();

        $view->with('siteTitle', $siteTitle);
        $view->with('currentUser', $currentUser);
    }
}
