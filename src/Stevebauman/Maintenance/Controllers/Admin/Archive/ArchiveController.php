<?php

namespace Stevebauman\Maintenance\Controllers\Admin;

use Stevebauman\Maintenance\Controllers\AbstractController;

class ArchiveController extends AbstractController {
    
    public function getIndex()
    {
        return view('maintenance::admin.archive.index', array(
            'title' => 'Archive'
        ));
    }
    
}