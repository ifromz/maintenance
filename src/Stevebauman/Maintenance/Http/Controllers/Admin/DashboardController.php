<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin;

use Stevebauman\Maintenance\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Displays the administrators dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('maintenance::admin.dashboard.index');
    }
}
