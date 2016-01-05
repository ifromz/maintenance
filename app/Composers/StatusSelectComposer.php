<?php

namespace App\Composers;

use App\Repositories\WorkOrder\StatusRepository;
use Illuminate\View\View;

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
