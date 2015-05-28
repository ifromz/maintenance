<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin\Setting;

use Stevebauman\Maintenance\Http\Controllers\Controller;

/**
 * Class SettingsController.
 */
class SettingsController extends Controller
{
    /**
     * Displays all of the available setting groups.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::admin.settings.index', [
            'title' => 'Settings',
        ]);
    }
}
