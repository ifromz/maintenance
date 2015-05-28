<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin\Archive;

use Stevebauman\Maintenance\Http\Controllers\BaseController;

/**
 * Class ArchiveController.
 */
class ArchiveController extends BaseController
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
