<?php

namespace Stevebauman\Maintenance\Controllers;

/**
 * Class MaintenanceController
 * @package Stevebauman\Maintenance\Controllers
 */
class MaintenanceController extends BaseController
{
    /**
     * Displays the maintenance management dashboard
     *
     * @return mixed
     */
	public function getIndex()
    {
        return view('maintenance::dashboard.index', array(
            'title' => 'Dashboard'
        ));
	}
}