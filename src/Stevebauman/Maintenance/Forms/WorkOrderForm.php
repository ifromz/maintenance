<?php

namespace Stevebauman\Maintenance\Forms;

/**
 * Class WorkOrderForm
 * @package Stevebauman\Maintenance\Forms
 */
class WorkOrderForm extends BaseForm {

    public function buildForm()
    {
        $this
            ->add('category', 'select-work-order-category', array(
                'label' => 'Category',
            ))
            ->add('location', 'select-location', array(
                'label' => 'Location',
            ))
            ->add('status', 'select-status', array(
                'label' => 'Status',
            ))
            ->add('priority', 'select-priority', array(
                'label' => 'Priority',
            ))
            ->add('assets', 'select-assets', array(
                'label' => 'Assets Involved'
            ))
            ->add('subject', 'text', array(
                'label' => 'Subject',
                'attr' => array(
                    'placeholder' => 'Enter Subject',
                ),
            ))
            ->add('description', 'textarea', array(
                'label' => 'Description',
            ))
            ->add('Save', 'submit', array(
                'attr' => $this->btnSaveAttributes()
            ));
    }

}