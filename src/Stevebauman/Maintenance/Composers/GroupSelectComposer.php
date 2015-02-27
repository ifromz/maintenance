<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\GroupService;
use Illuminate\View\View;

/**
 * Class GroupSelectComposer
 * @package Stevebauman\Maintenance\Composers
 */
class GroupSelectComposer
{
    /**
     * @var GroupService
     */
    protected $group;

    /**
     * @param GroupService $group
     */
    public function __construct(GroupService $group)
    {
        $this->group = $group;
    }

    /**
     * @param View $view
     * @return $this
     */
    public function compose(View $view)
    {
        $groups = $this->group->get()->lists('name', 'id');

        return $view->with('allGroups', $groups);
    }

}