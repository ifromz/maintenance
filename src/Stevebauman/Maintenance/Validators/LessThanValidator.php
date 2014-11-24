<?php

namespace Stevebauman\Maintenance\Validators;

class LessThanNumberValidator {
    
    public function validateLessThan($attribute, $number, $parameters){
        
        if(is_numeric($number)){
            if($number < $parameters[0]){
                return true;
            }
            
            return false;
        }
        
    }
    
}