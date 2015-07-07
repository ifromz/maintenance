<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class AssignedController extends BaseController
{
    /**
     * Displays the all assigned work orders for the current user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::work-orders.assigned.index');
    }
}
