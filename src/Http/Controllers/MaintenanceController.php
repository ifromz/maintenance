<?php

namespace Stevebauman\Maintenance\Http\Controllers;

class MaintenanceController extends Controller
{
    /**
     * Displays the maintenance management dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('maintenance::dashboard.index');
    }
}
