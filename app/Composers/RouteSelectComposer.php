<?php

namespace App\Composers;

use App\Services\ConfigService;
use Illuminate\View\View;

class RouteSelectComposer
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
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $allRoutes = [];

        $routes = $this->config->get('permissions.administrators', []);

        foreach ($routes as $route => $bool) {
            $allRoutes[$route] = $route;
        }

        return $view->with('allRoutes', $allRoutes);
    }
}
