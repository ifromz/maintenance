<?php namespace Stevebauman\Maintenance\Services;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\App;
use Mews\Purifier\Facades\Purifier;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;

abstract class AbstractModelService {
    
    protected $model;
    
    protected $db;
    
    public function __construct(){
        $this->db = App::make('db');
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
                    throw new RecordNotFoundException('No record was found with the given ID.');
            }
    }
	
    /**
     * Create a new record with mass assignment
     *
     * @author Steve Bauman
     *
	 * @param $data (array)
     * @return object or boolean
     */
    public function create($data){
            if($record = $this->model->create($data)){
                    return $record;
            } return false;
    }
	
    /**
     * Update a record with mass assignment
     *
     * @author Steve Bauman
     *
	 * @param $id (int/string), $data (array)
     * @return object or boolean
     */
    public function update($id, $data){
            $record = $this->model->find($id);
            if($record->update($data)){
                    return $record;
            } return false;
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
     * Cleans input from data removing invalid HTML tags such as scripts
     * 
     * @param type $input
     * @return type
     */
    protected function clean($input){
        if($input){
            return Purifier::clean($input, array(
                'AutoFormat.AutoParagraph' => false,
            ));
        } else{
            return NULL;
        }
    }
    
    /**
     * Returns input from the client. If clean is set to true, the input will be
     * ran through the purifier before it is returned.
     * 
     * @param type $input
     * @param type $clean
     * @return null OR Input
     */
    protected function input($input, $clean = FALSE){
        if(Input::has($input)){
            if($clean){
                return $this->clean(Input::get($input));
            } else{
                return Input::get($input);
            }
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