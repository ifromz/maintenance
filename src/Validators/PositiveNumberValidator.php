<?php namespace Stevebauman\Maintenance\Validators;

class PositiveNumberValidator  {
    
     public function validatePositive($attribute, $value, $params, $validator){
        if (preg_match('#^\d+(\.(\d{2}))?$#', $value))
        {
            return true;
        } return false;
     }
    
}