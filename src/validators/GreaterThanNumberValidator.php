<?php

namespace Stevebauman\Maintenance\Validators;

class GreaterThanNumberValidator {
    
    public function validateGreaterThan($attribute, $number, $parameters){
        
        if(is_numeric($number)){
            if($number > $parameters[0]){
                return true;
            }
            
            return false;
        }
        
    }
    
}