<?php namespace Stevebauman\Maintenance\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent {
    
    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at)->format('M dS Y - h:ia'); 
    }
    
    
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
     * Allows all models attached to BaseModel to have notifications
     * 
     * @return type
     */
    public function notifications(){
        return $this->morphMany('Stevebauman\Maintenance\Models\Notification', 'notifiable');
    }
}
