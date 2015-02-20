<?php

namespace Stevebauman\Maintenance\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class BaseForm
 * @package Stevebauman\Maintenance\Forms
 */
class BaseForm extends Form {

    public function setFormOptions($formOptions)
    {
        $this->addCustomField('select-work-order-category', 'Stevebauman\Maintenance\Forms\Fields\Select\WorkOrderCategoryField');

        $this->addCustomField('select-location', 'Stevebauman\Maintenance\Forms\Fields\Select\LocationField');

        $this->addCustomField('select-priority', 'Stevebauman\Maintenance\Forms\Fields\Select\PriorityField');

        $this->addCustomField('select-status', 'Stevebauman\Maintenance\Forms\Fields\Select\StatusField');

        $this->addCustomField('select-assets', 'Stevebauman\Maintenance\Forms\Fields\Select\AssetsField');

        return parent::setFormOptions($formOptions);
    }

    public function btnSaveAttributes()
    {
        return array(
            'class' => 'btn btn-primary',
        );
    }

}