<?php

namespace Stevebauman\Maintenance\Forms\Fields\Select;

use Stevebauman\Maintenance\Forms\Fields\BaseField;

class LocationField extends BaseField {

    public function getTemplate()
    {
        return 'maintenance::select.location';
    }

}