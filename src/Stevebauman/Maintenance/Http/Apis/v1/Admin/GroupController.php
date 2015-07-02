<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Admin;

use Stevebauman\Maintenance\Repositories\GroupRepository;
use App\Http\Controllers\Controller as BaseController;

class GroupController extends BaseController
{
    /**
     * @var GroupRepository
     */
    protected $group;

    /**
     * Constructor.
     *
     * @param GroupRepository $group
     */
    public function __construct(GroupRepository $group)
    {
        $this->group = $group;
    }

    public function grid()
    {
        
    }
}
