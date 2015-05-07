<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;
use Stevebauman\Maintenance\Services\StatusService;

/**
 * Class StatusSelectComposer.
 */
class StatusSelectComposer
{
    /**
     * @var StatusService
     */
    protected $status;

    /**
     * @param StatusService $status
     */
    public function __construct(StatusService $status)
    {
        $this->status = $status;
    }

    /**
     * @param $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $statuses = $this->status->get()->lists('name', 'id');

        /*
         * Default selected None value
         */
        $statuses[null] = 'Select a Status';

        return $view->with('statuses', $statuses);
    }
}
