<?php

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Controllers\BaseController;

class DashboardController extends BaseController
{
    /**
     * Dispalys the Administrator index.
     *
     * @return mixed
     */
    public function getIndex()
    {
        return view('maintenance::admin.dashboard.index', array(
            'title' => 'Administrator Dashboard'
        ));
    }
}
