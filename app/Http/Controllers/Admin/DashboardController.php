<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Displays the administrators dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('admin.dashboard.index');
    }
}
