<?php 

namespace Stevebauman\Maintenance\Services;

use Illuminate\Support\Facades\App;
use Mews\Purifier\Facades\Purifier;

abstract class AbstractModelService {
    
    /*
     * Holds the eloquent model to query
     */
    protected $model;
    
    /*
     * Holds the database facade
     */
    protected $db;
    
    /*
     * Holds the data to be inserted into the database
     */
    protected $input =  array();
    
    /*
     * Holds the exception to be thrown when a record isn't found
     */
    protected $notFoundException;
    
    public function __construct(){
        $this->db = App::make('db');
    }
    
    /**
     * Set's the input data to be inserted into DB
     * 
     * @param type $input
     */
    public function setInput($input = array()){
        $this->input = $input;
        
        return $this;
    }
    
    /**
     * Retrieves data from the input array
     * 
     * @param type $field - Field to grab from the input data
     * @param type $default - Default value to set the input to
     * @param type $clean - Clean the input before returning
     * @return null
     */
    public function getInput($field,  $default = NULL, $clean = FALSE){
        /*
         * If the field exists in the input array
         */
        if(array_key_exists($field, $this->input)){
            /*
             * If clean is set to true, clean the input and return it
             */
            if($clean){
                return $this->clean($this->input[$field]);
            } else{
                //If clean is set to false, return the input
                return $this->input[$field];
            }
        } else{
            /*
             * If key does not exist in the input array, and a 
             * default value is specified, return the default value
             */
            if($default !== NULL){
                return $default;
            } else{
                /*
                 * Return NULL if the default value is not set
                 */
                return NULL;
            }
        }
    }
    
    /**
     * Return all model records
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function get($select = array('*')){
            return $this->model->select($select)->get();
    }
	
    /**
     * Apply distinct filtering to the model
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function distinct(){
            return $this->model->distinct();
    }
	
    /**
     * Apply `with` relations to the model
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function with($with = array()){
            return $this->model->with($with);
    }
        
    /**
     * Apply `where` filtering to the model
     *
     * If no value is specified, then the operator arguement is used as the value
     * 
     * @author Steve Bauman
     *
     * @return object
     */
    public function where($column, $operator, $value = NULL){
        if(is_null($value)){
            return $this->model->where($column, $operator);
        } else{
            return $this->model->where($column, $operator, $value);
        }

    }
    
    /**
     * Create a record through eloquent mass assignment
     * 
     * @return boolean OR object
     */
    public function create(){
        $record = $this->model->create($this->input);
        if($record){
           return $record; 
        } return false;
    }
    
    /**
     * Update a record through eloquent mass assignment
     * 
     * @param type $id
     * @return boolean OR object
     */
    public function update($id){
        $record = $this->find($id);
        
        if($record->update($this->input)){
            return $record;
        } return false;
    }


    /**
     * Apply order by sorting to the model
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function orderBy($column, $direction = NULL){
            return $this->model->orderBy($column, $direction);
    }
    
    /**
     * Apply group by sorting to the model
     * 
     * @param type $column
     * @return type
     */
    public function groupBy($column){
        return $this->model->groupBy($column);
    }
	
    /**
     * Find a record by ID
     *
     * @author Steve Bauman
     *
     * @param $id (int/string)
     * @return object
     */
    public function find($id){
            if($record = $this->model->find($id)){
                    return $record;
            } else{
                    throw new $this->notFoundException;
            }
    }
    
    /**
     * Find a deleted record by ID
     * 
     * @param type $id
     * @return type
     * @throws type
     */
    public function findArchived($id){
        if($record = $this->model->withTrashed()->find($id)){
            return $record;
        } else{
            throw new $this->notFoundException;
        }
    }
    
    /**
     * Destroy a record from given ID
     *
     * @author Steve Bauman
     *
     * @param $id (int/string)
     * @return boolean
     */
    public function destroy($id){
            if($this->model->destroy($id)){
                    return true;
            } return false;
    }
    
    /**
     * Destroy a soft deleted record by ID
     * 
     * @param type $id
     */
    public function destroyArchived($id){
        $record = $this->findArchived($id);

        return $record->forceDelete();
    }
    
    public function restoreArchived($id){
        $record = $this->findArchived($id);
        
        return $record->restore();
    }
    
    /**
     * Cleans input from data removing invalid HTML tags such as scripts
     * 
     * @param type $input
     * @return type
     */
    protected function clean($input){
        if($input){
            $cleaned = Purifier::clean($input);
            
            return $cleaned;
        } else{
            return NULL;
        }
    }
    
    
    /**
     * Formats javascript plugin 'Pickadate' and 'Pickatime' date strings into PHP dates
     * 
     * @param type $date
     * @param type $time
     * @return null OR date
     */
    protected function formatDateWithTime($date, $time = NULL){
        if($date){
                return date('Y-m-d H:i:s', strtotime($date. ' ' .$time));
        } return NULL;
    }

	
}