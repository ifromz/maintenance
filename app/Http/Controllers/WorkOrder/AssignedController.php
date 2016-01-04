<?php

namespace App\Http\Controllers\WorkOrder;

use App\Http\Controllers\Controller as BaseController;

class AssignedController extends BaseController
{
    /**
     * Displays the all assigned work orders for the current user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('work-orders.assigned.index');
    }
}
