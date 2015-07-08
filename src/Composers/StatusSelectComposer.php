<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;
use Stevebauman\Maintenance\Repositories\WorkOrder\StatusRepository;

class StatusSelectComposer
{
    /**
     * @var StatusRepository
     */
    protected $status;

    /**
     * @param StatusRepository $status
     */
    public function __construct(StatusRepository $status)
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
        $statuses = $this->status->all()->lists('name', 'id')->toArray();

        /*
         * Default selected None value
         */
        $statuses[null] = 'Select a Status';

        return $view->with('statuses', $statuses);
    }
}
