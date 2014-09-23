<?php

Validator::resolver(function($translator, $data, $rules, $messages){
    
    $assignment = App::make('Stevebauman\Maintenance\Services\WorkOrderAssignmentService');
    
    return new Stevebauman\Maintenance\Validators\UserAssignmentValidator($translator, $data, $rules, $messages, $assignment);
});


Validator::extend('stock_location', 'Stevebauman\Maintenance\Validators\InventoryStockLocationValidator@validateStockLocation');

Validator::replacer('stock_location', function($message, $attribute, $rule, $parameters){
    return "This location already has a stock entry for this item.";
});

Validator::extend('unique_report', 'Stevebauman\Maintenance\Validators\WorkOrderReportUniqueValidator@validateUniqueReport');

Validator::replacer('unique_report', function($message, $attribute, $rule, $parameters){
    return "This work order already has a completion report.";
});

Validator::extend('positive', 'Stevebauman\Maintenance\Validators\PositiveNumberValidator@validatePositive');

Validator::replacer('positive', function($message, $attribute, $rule, $parameters){
    return sprintf('The %s must contain a positive number', $attribute);
});