<?php

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Controllers\BaseController;

class DashboardController extends BaseController {
    
    public function getIndex()
    {
        return view('maintenance::admin.dashboard.index', array(
            'title' => 'Administrator Dashboard'
        ));
    }
    
}