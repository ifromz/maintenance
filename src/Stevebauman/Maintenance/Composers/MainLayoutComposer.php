<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\ConfigService;
use Illuminate\View\View;

class MainLayoutComposer
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
     * Applies site wide variables to main layout.
     *
     * @param $view
     */
    public function compose(View $view)
    {
        $siteTitle = $this->config->get('site.title.main');
        $currentUser = $this->sentry->getCurrentUser();

        $view->with('siteTitle', $siteTitle);
        $view->with('currentUser', $currentUser);
    }
}
