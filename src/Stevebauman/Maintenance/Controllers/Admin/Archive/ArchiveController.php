<?php

namespace Stevebauman\Maintenance\Controllers\Admin\Archive;

use Stevebauman\Maintenance\Controllers\BaseController;

class ArchiveController extends BaseController
{
    /**
     * Displays the Archives index.
     *
     * @return mixed
     */
    public function getIndex()
    {
        return view('maintenance::admin.archive.index', [
            'title' => 'Archive'
        ]);
    }
    
}
