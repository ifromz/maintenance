<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Repositories\GroupRepository;
use Illuminate\View\View;

class GroupSelectComposer
{
    /**
     * @var GroupRepository
     */
    protected $group;

    /**
     * @param GroupRepository $group
     */
    public function __construct(GroupRepository $group)
    {
        $this->group = $group;
    }

    /**
     * @param View $view
     *
     * @return $this
     */
    public function compose(View $view)
    {
        $groups = $this->group->all()->lists('name', 'id');

        return $view->with('allGroups', $groups);
    }
}
