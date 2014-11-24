<?php

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Controllers\AbstractController;

class DashboardController extends AbstractController {
    
    public function getIndex()
    {
        return $this->view('maintenance::admin.dashboard.index', array(
            'title' => 'Administrator Dashboard'
        ));
    }
    
}