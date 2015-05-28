<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin;

use Stevebauman\Maintenance\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Dispalys the Administrator index.
     *
     * @return mixed
     */
    public function getIndex()
    {
        return view('maintenance::admin.dashboard.index', [
            'title' => 'Administrator Dashboard',
        ]);
    }
}
