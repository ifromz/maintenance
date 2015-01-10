<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\StatusService;

/**
 * Class StatusSelectComposer
 * @package Stevebauman\Maintenance\Composers
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
     * @return mixed
     */
    public function compose($view)
    {
        $statuses = $this->status->get()->lists('name', 'id');

        /*
         * Default selected None value
         */
        $statuses[NULL] = 'Select a Status';

        return $view->with('statuses', $statuses);
    }

}
