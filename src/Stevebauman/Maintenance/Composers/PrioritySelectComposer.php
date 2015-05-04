<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;
use Stevebauman\Maintenance\Services\PriorityService;

/**
 * Class PrioritySelectComposer
 * @package Stevebauman\Maintenance\Composers
 */
class PrioritySelectComposer
{

    /**
     * @var PriorityService
     */
    protected $priority;

    /**
     * @param PriorityService $priority
     */
    public function __construct(PriorityService $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param $view
     * @return mixed
     */
    public function compose(View $view)
    {
        $priorities = $this->priority->get()->lists('name', 'id');

        /*
         * Default selected None value
         */
        $priorities[null] = 'Select a Priority';

        return $view->with('priorities', $priorities);
    }

}
