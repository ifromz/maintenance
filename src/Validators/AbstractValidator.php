<?php namespace Stevebauman\Maintenance\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;

abstract class AbstractValidator {
		
	protected $input;
 	
	protected $errors;
	
        protected $rules;
        
 	public function __construct($input = NULL){
            $this->input = $input ?: Input::all();
	}
        
	public function passes(){
            $validation = Validator::make($this->input, $this->rules);
 
            if($validation->passes()) return true;
     
            $this->errors = $validation->messages();
		
            return false;
  	}
 
 	public function getErrors(){
            if(Request::ajax()){
                    return $this->errors->getMessages();
            } else{
                    return $this->errors;
            }
  	}
        
        public function setRules($rules){
            $this->rules = $rules;
        }
        
        public function ignore($field, $table, $column, $ignore = 'NULL'){
            $this->rules[$field] .= sprintf('|unique:%s,%s,%s', $table, $column, $ignore);
        }
        
        
	
}