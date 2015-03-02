<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\ConfigService;
use Illuminate\View\View;

/**
 * Class PublicLayoutComposer
 * @package Stevebauman\Maintenance\Composers
 */
class PublicLayoutComposer
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
        $siteTitle = $this->config->get('site.title.public', 'Maintenance');

        $view->with('siteTitle', $siteTitle);
    }

}