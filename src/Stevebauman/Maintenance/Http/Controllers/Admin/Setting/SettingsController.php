<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin\Setting;

use Stevebauman\Maintenance\Http\Controllers\BaseController;

/**
 * Class SettingsController.
 */
class SettingsController extends BaseController
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
