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

    /**
     * Returns a new grid instance of all available groups.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'name',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'throttle' => 10,
            'threshold' => 10,
        ];

        $transformer = function($group)
        {
            return [
                'name' => $group->name,
                'view_url' => route('maintenance.admin.groups.show', [$group->id]),
            ];
        };

        return $this->group->grid($columns, $settings, $transformer);
    }
}
