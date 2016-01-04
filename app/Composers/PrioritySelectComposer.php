<?php

namespace App\Composers;

use Illuminate\View\View;
use App\Repositories\WorkOrder\PriorityRepository;

class PrioritySelectComposer
{
    /**
     * @var PriorityRepository
     */
    protected $priority;

    /**
     * @param PriorityRepository $priority
     */
    public function __construct(PriorityRepository $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @param $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $priorities = $this->priority->all()->lists('name', 'id')->toArray();

        /*
         * Default selected None value
         */
        $priorities[null] = 'Select a Priority';

        return $view->with('priorities', $priorities);
    }
}
