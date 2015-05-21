<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;

class RecordsPerPageSelectComposer
{
    /**
     * @param View $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $amounts = [
            '10' => '10',
            '25' => '25',
            '50' => '50',
            '100' => '100'
        ];

        return $view->with('amounts', $amounts);
    }
}
