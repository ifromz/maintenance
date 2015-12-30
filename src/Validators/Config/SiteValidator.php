<?php

namespace Stevebauman\Maintenance\Validators\Config;

use Stevebauman\Maintenance\Validators\BaseValidator;

class SiteValidator extends BaseValidator
{
    /**
     * The site validation rules.
     *
     * @var array
     */
    protected $rules = [
        'title'               => 'required|max:30',
        'admin_title'         => 'required|max:30',
        'work_order_calendar' => '',
        'asset_calendar'      => '',
        'inventory_calendar'  => '',
    ];
}
