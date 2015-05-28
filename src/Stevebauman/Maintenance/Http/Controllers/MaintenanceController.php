<?php

namespace Stevebauman\Maintenance\Controllers;

/**
 * Class MaintenanceController.
 */
class MaintenanceController extends BaseController
{
    /**
     * Displays the maintenance management dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('maintenance::dashboard.index', [
            'title' => 'Dashboard',
        ]);
    }
}
