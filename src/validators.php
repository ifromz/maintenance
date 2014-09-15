<?php

Validator::resolver(function($translator, $data, $rules, $messages){
    
    $assignment = App::make('Stevebauman\Maintenance\Services\AssignmentService');
    
    return new Stevebauman\Maintenance\Validators\UserAssignmentValidator($translator, $data, $rules, $messages, $assignment);
});

Validator::resolver(function($translator, $data, $rules, $messages){
    
    $inventoryStock = App::make('Stevebauman\Maintenance\Services\InventoryStockService');
    
    return new Stevebauman\Maintenance\Validators\InventoryStockLocationValidator($translator, $data, $rules, $messages, $inventoryStock);
});