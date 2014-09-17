<?php namespace Stevebauman\Maintenance\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $table = 'events';
    
    protected $fillable = array(
        'user_id', 
        'title', 
        'description', 
        'start',
        'end',
        'allDay',
        'color',
        'background_color',
        'recur_frequency',
        'recur_count',
        'recur_filter_days',
        'recur_filter_months',
        'recur_filter_years',
    );
    
    public function user(){
        return $this->hasOne('Stevebauman\Maintenance\Models\User');
    }
    
    public function assets(){
        return $this->belongsToMany('Stevebauman\Maintenance\Models\Asset', 'asset_events', 'event_id', 'asset_id');
    }
    
    public function isRecurring(){
        if(isset($this->recur_frequency)){
            return true;
        } return false;
    }
    
    public function recurringEnds(){
        if(isset($this->recur_count)){
            return true;
        } return false;
    }
    
    public function getRecurStartAttribute(){
        $recurStart = Carbon::parse($this->attributes['start']);
        
        if(isset($this->attributes['recur_frequency'])){
            
            switch($this->attributes['recur_frequency']){
                 case 'DAILY':
                     return $recurStart->addDay();
                case 'WEEKLY':
                    return $recurStart->addWeek();
                case 'MONTHLY':
                    return $recurStart->addMonth();
                default:
                    return $recurStart->addYear();
            }
            
        } return NULL;
    }
    
    public function getRecurEndAttribute(){
        $recurStart = Carbon::parse($this->attributes['end']);
        
        if(isset($this->attributes['recur_frequency'])){
            
            switch($this->attributes['recur_frequency']){
                 case 'DAILY':
                     return $recurStart->addDay();
                case 'WEEKLY':
                    return $recurStart->addWeek();
                case 'MONTHLY':
                    return $recurStart->addMonth();
                default:
                    return $recurStart->addYear();
            }
            
        } return NULL;
    }
    
    public function getRecurLimitAttribute(){
        
        switch($this->attributes['recur_frequency']){
            case 'DAILY':
                return 42;
           case 'WEEKLY':
               return 6;
           case 'MONTHLY':
               return 2;
           default:
               return 1;
       }
        
    }
    
}
