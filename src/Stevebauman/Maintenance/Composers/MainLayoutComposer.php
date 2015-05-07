<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\ConfigService;
use Illuminate\View\View;

/**
 * Class MainLayoutComposer.
 */
class MainLayoutComposer
{
    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param ConfigService $config
     */
    public function __construct(ConfigService $config)
    {
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $siteTitle = $this->config->get('site.title.main');

        $view->with('siteTitle', $siteTitle);
    }
}
