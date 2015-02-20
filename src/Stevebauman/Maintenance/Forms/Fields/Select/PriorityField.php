<?php

namespace Stevebauman\Maintenance\Forms\Fields\Select;

use Stevebauman\Maintenance\Forms\Fields\BaseField;

class PriorityField extends BaseField {

    public function getTemplate()
    {
        return 'maintenance::select.priority';
    }

}