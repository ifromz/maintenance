<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Validators\AbstractValidator;

class CalendarEventValidator extends AbstractValidator {
    
    protected $rules = array(
        'title' => 'required|max:250',
        'description' => 'min:5|max:2000',
        'start_date' => 'required|max:25',
        'end_date' => 'required|max:25',
        'recur_frequency' => 'required_with:recur_limit,recur_days,recur_months',
        'recur_limit' => 'integer|max:2000',
        'recur_days' => '',
        'recur_months' => '',
    );
    
}