<?php

Validator::resolver(function($translator, $data, $rules, $messages){
    
    $assignment = App::make('Stevebauman\Maintenance\Services\AssignmentService');
    
    return new Stevebauman\Maintenance\Validators\UserAssignmentValidator($translator, $data, $rules, $messages, $assignment);
});