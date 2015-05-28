<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin\Archive;

use Stevebauman\Maintenance\Http\Controllers\Controller;

/**
 * Class ArchiveController.
 */
class ArchiveController extends Controller
{
    /**
     * Displays the Archives index.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('maintenance::admin.archive.index', [
            'title' => 'Archive',
        ]);
    }
}
