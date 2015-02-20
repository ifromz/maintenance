<?php

namespace Stevebauman\Maintenance\Forms\Fields\Select;

use Stevebauman\Maintenance\Forms\Fields\BaseField;

class WorkOrderCategoryField extends BaseField {

    public function getTemplate()
    {
        return 'maintenance::select.work-order-category';
    }

}