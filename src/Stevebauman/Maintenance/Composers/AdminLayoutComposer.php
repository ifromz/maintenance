<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Illuminate\View\View;

/**
 * Class AdminLayoutComposer.
 */
class AdminLayoutComposer
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
        $siteTitle = $this->config->get('site.title.admin');
        $currentUser = $this->sentry->getCurrentUser();

        $view->with('siteTitle', $siteTitle);
        $view->with('currentUser', $currentUser);
    }
}
