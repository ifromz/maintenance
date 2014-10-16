<?php namespace Stevebauman\Maintenance\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent {
    
    /**
     * Formats the created_at timestamp
     * 
     * @param type $created_at
     * @return type
     */
    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at)->format('M dS Y - h:ia'); 
    }
    
    /**
     * 
     * 
     * @param type $string
     * @return boolean OR array
     */
    protected function getOperator($string){
        $allowed_operators = array('>', '<', '=', '>=', '<=');
        $output = preg_split("/[\[\]]/", $string);

        if(is_array($output)){
                if(array_key_exists('1', $output) && array_key_exists('2', $output)){
                        if(in_array($output[1], $allowed_operators)){
                                return array($output[1], $output[2]);
                        }
                } else{
                    return $output;
                }
        }
        return false;
    }
    
    /**
     * Allows all tables extending from the base model to be scoped by ID
     * 
     * @param type $query
     * @param type $id
     * @return type
     */
    public function scopeId($query, $id = NULL){
        if($id){
            return $query->where('id', $id);
        }
    }
    
    /**
     * Allows all columns on the current database table to be sorted through
     * query scope
     * 
     * @param type $query
     * @param type $field
     * @param type $sort
     * @return object
     */
    public function scopeSort($query, $field = NULL, $sort = NULL){
        
        /*
         * Make sure both the field and sort variables are present
         */
        if($field && $sort){
            /*
             * Retrieve all column names for the current model table
             */
            $columns = Schema::getColumnListing($this->table);

            /*
             * Make sure the field inputted is available on the current table
             */
            if(in_array($field, $columns)){

                /*
                 * Make sure the sort input is equal to asc or desc
                 */
                if($sort === 'asc' || $sort === 'desc'){
                    /*
                     * Return the query sorted
                     */
                    return $query->orderBy($field, $sort);
                }
            }
        }
        
        /*
         * Default order by created at field
         */
        return $query->orderBy('created_at', 'desc');
        
    }
    
    /**
     * Allows all models extending from BaseModel to have notifications
     * 
     * @return type
     */
    public function notifications(){
        return $this->morphMany('Stevebauman\Maintenance\Models\Notification', 'notifiable');
    }
}
