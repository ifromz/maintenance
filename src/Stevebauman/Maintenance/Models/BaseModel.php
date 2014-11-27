<?php namespace Stevebauman\Maintenance\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent {
    
    /*
     * Provides easy table generation
     */
    use \Stevebauman\EloquentTable\TableTrait;
    
    /*
     * Provides reusable views when an object is returned
     */
    use \Stevebauman\Viewer\ViewableTrait;
    
    /*
     * Revisionable Trait for storing revisions on all models that extend
     * from this class
     */
    use \Venturecraft\Revisionable\RevisionableTrait;
    
    /*
     * Tell revisionable to not keep a revision of deleted_at columns
     */
    protected $dontKeepRevisionOf = array('deleted_at');
    
    /**
     * Formats the created_at timestamp
     * 
     * @param string $created_at
     * @return string
     */
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('M dS Y - h:ia'); 
    }
    
    /**
     * Formats the deleted_at timestamp
     * 
     * @param string $deleted_at
     * @return string
     */
    public function getDeletedAtAttribute($deleted_at)
    {
        return Carbon::parse($deleted_at)->format('M dS Y - h:ia');
    }
    
    /**
     * Accessor for retrieving a limited description for display on tables
     * 
     * @return mixed
     */
    public function getLimitedDescriptionAttribute()
    {
        if(array_key_exists('description', $this->attributes)) {
            
            /*
             * Strip tags due to HTML formatting that may be inside the discription
             * that could ruin the display of the table
             */
            return str_limit(strip_tags($this->attributes['description']), 30);
        }
        
        return NULL;
    }
    
    /**
     * 
     * 
     * @param string $string
     * @return boolean OR array
     */
    protected function getOperator($string)
    {
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
     * @param object $query
     * @param integer/string $id
     * @return object
     */
    public function scopeId($query, $id = NULL)
    {
        if($id){
            return $query->where('id', $id);
        }
    }
    
    /**
     * Scopes a query to show only soft deleted records
     * 
     * @param object $query
     * @param boolean $archived
     * @return object
     */
    public function scopeArchived($query, $archived = false)
    {
        if($archived){
            return $query->onlyTrashed();
        }
    }
    
    /**
     * Allows all models extending from BaseModel to have notifications
     * 
     * @return object
     */
    public function notifications()
    {
        return $this->morphMany('Stevebauman\Maintenance\Models\Notification', 'notifiable');
    }
    
    /**
     * Allows all columns on the current database table to be sorted through
     * query scope
     * 
     * @param object $query
     * @param string $field
     * @param string $sort
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
     * Returns the current models database table
     * 
     * @return string
     */
    public function getCurrentTable()
    {
        return $this->table;
    }
}
