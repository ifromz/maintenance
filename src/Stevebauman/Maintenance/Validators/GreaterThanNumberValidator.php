<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class GreaterThanNumberValidator
 * @package Stevebauman\Maintenance\Validators
 */
class GreaterThanNumberValidator
{
    
    /**
     * Validates a form field to make sure the inputted number is greater
     * than the set number
     * 
     * @param string $attribute
     * @param string $number
     * @param array $parameters
     * @return boolean
     */
    public function validateGreaterThan($attribute, $number, $parameters){
        
        if(is_numeric($number))
        {
            if($number > $parameters[0]) return true;
        }
        
        return false;
    }
    
}