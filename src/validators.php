<?php

/*
 * Validator Registrations
 */

use Illuminate\Support\Facades\Validator;

/*
 * Validates Work Order Assignments to make sure if the user has already been assigned to the work order.
 */
Validator::resolver(function ($translator, $data, $rules, $messages) {

    $assignment = App::make('Stevebauman\Maintenance\Services\WorkOrder\AssignmentService');

    return new Stevebauman\Maintenance\Validators\UserAssignmentValidator($translator, $data, $rules, $messages, $assignment);
});

/*
 * Validates Stock Locations to make sure that only one stock can be added per location
 */
Validator::extend('stock_location', 'Stevebauman\Maintenance\Validators\InventoryStockLocationValidator@validateStockLocation');

Validator::replacer('stock_location', function ($message, $attribute, $rule, $parameters) {
    return 'This location already has a stock entry for this item.';
});

/*
 * Validates the Adding of parts to a work order to make sure
 * there's enough quantity in the inventory that the user has entered.
 */
Validator::extend('enough_quantity', 'Stevebauman\Maintenance\Validators\WorkOrder\PartStockQuantityValidator@validateEnoughQuantity');

Validator::replacer('enough_quantity', function ($message, $attribute, $rule, $parameters) {
    return 'The amount you entered is greater than the available stock.';
});

/*
 * Validates Work Order Reports to make sure only one is filled out.
 */
Validator::extend('unique_report', 'Stevebauman\Maintenance\Validators\WorkOrder\ReportUniqueValidator@validateUniqueReport');

Validator::replacer('unique_report', function ($message, $attribute, $rule, $parameters) {
    return 'This work order already has a completion report.';
});

/*
 * Validates Event Reports to make sure only one is filled out.
 */
Validator::extend('unique_event_report', 'Stevebauman\Maintenance\Validators\Event\UniqueReportValidator@validateUniqueReport');

Validator::replacer('unique_event_report', function ($message, $attribute, $rule, $parameters) {
    return 'This event already has a completion report.';
});

/*
 * Validates text to make sure it's a positive number.
 */
Validator::extend('positive', 'Stevebauman\Maintenance\Validators\PositiveNumberValidator@validatePositive');

Validator::replacer('positive', function ($message, $attribute, $rule, $parameters) {
    return sprintf('The %s must contain a positive number', $attribute);
});

/*
 * Validates the submitted value if it is greater than the validation parameter.
 */
Validator::extend('greater_than', 'Stevebauman\Maintenance\Validators\GreaterThanNumberValidator@validateGreaterThan');

Validator::replacer('greater_than', function ($message, $attribute, $rule, $parameters) {
    return sprintf('The %s must be greater than %s', $attribute, $parameters[0]);
});

/*
 * Validates the submitted value if its less than the validation parameter.
 */
Validator::extend('less_than', 'Stevebauman\Maintenance\Validators\LessThanNumberValidator@validateLessThan');

Validator::replacer('less_than', function ($message, $attribute, $rule, $parameters) {
    return sprintf('The %s must be less than %s', $attribute, $parameters[0]);
});

/*
 * Validates that the current user only has one session open
 */
Validator::extend('session_start', 'Stevebauman\Maintenance\Validators\WorkOrder\SessionStartValidator@validateSessionStart');

Validator::replacer('session_start', function () {
    return "You already have an open session, you must close it to begin a new one.";
});

/*
 * Validates that the current user can only close their session once
 */
Validator::extend('session_end', 'Stevebauman\Maintenance\Validators\WorkOrder\SessionEndValidator@validateSessionEnd');

Validator::replacer('session_end', function () {
    return "This session has already ended. You must create a new session.";
});
