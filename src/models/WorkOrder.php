<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Support\Facades\Config;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Stevebauman\Maintenance\Models\BaseModel;

class WorkOrder extends BaseModel {
	
	protected $table = 'work_orders';
	
	protected $fillable = array(
            'user_id', 
            'location_id', 
            'work_order_category_id', 
            'status', 
            'priority', 
            'subject', 
            'description', 
            'started_at', 
            'completed_at', 
            'sessions',
        );
	
	public function customerUpdates(){
		return $this->belongsToMany('Stevebauman\Maintenance\Models\Update', 'work_order_customer_updates', 'work_order_id', 'update_id')->withTimestamps();
	}
        
        public function technicianUpdates(){
		return $this->belongsToMany('Stevebauman\Maintenance\Models\Update', 'work_order_technician_updates', 'work_order_id', 'update_id')->withTimestamps();
	}
        
        public function location(){
            return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
        }

	public function category(){
		return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrderCategory', 'id', 'work_order_category_id');
	}
	
	public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
        
        public function assets(){
            return $this->belongsToMany('Stevebauman\Maintenance\Models\Asset', 'work_order_assets', 'work_order_id', 'asset_id')->withTimestamps();
        }
        
        public function sessions(){
            return $this->hasMany('Stevebauman\Maintenance\Models\WorkOrderSession', 'work_order_id')->orderBy('created_at', 'DESC');
        }
        
        public function report(){
            return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrderReport', 'work_order_id');
        }
        
        public function assignments(){
            return $this->hasMany('Stevebauman\Maintenance\Models\WorkOrderAssignment', 'work_order_id', 'id');
        }
        
        /**
         * Filters work order results by priority
         * 
         * @return object
         */
        public function scopePriority($query, $priority = NULL){
            
            if(isset($priority)){
                return $query->where('priority', $priority);
            }
	}
        
        /**
         * Filters work order results by subject
         * 
         * @return object
         */
        public function scopeSubject($query, $subject = NULL){
            if($subject){
                return $query->where('subject', 'LIKE', '%'.$subject.'%');
            }
	}
        
        /**
         * Filters work order results by description
         * 
         * @return object
         */
        public function scopeDescription($query, $desc = NULL){
            if($desc){
                return $query->where('description', 'LIKE', '%'.$desc.'%');
            }
	}
        
        
        /**
         * Filters work order results by status
         * 
         * @return object
         */
        public function scopeStatus($query, $status = NULL){
            if(isset($status)){
                return $query->where('status', $status);
            }
	}
        
        /**
         * Filters work order results by category
         * 
         * @return object
         */
        public function scopeCategory($query, $category = NULL){
            if($category){
                return $query->whereHas('category', function($query) use($category){
                        $query->where('id', $category);
                });
            }
	}
        
        /**
         * Filters work order results by assets that are included
         * 
         * @return object
         */
        public function scopeAssets($query, $assets = NULL){
            if($assets){
                return $query->whereHas('assets', function($query) use($assets){
                        $query->whereIn('asset_id', $assets);
                });
            }
        }

        public function scopeUserHours($query, $user){
            if($user){
                return $query->whereHas('sessions', function($query) use ($user){
                    $query->where('user_id', $user->id);
                });
            }
        }
        
        /**
         * Checks if the current work order is complete
         * 
         * @return boolean
         */
        public function isComplete(){
            if($this->status === Config::get('maintenance::status.complete')){
                return true;
            } return false;
        }
        
        /**
         * Checks if the current work order is not complete
         * 
         * @return boolean
         */
        public function isNotComplete(){
            if($this->status != Config::get('maintenance::status.complete')){
                return true;
            } return false;
        }
        
        /**
         * Checks if the current work has workers assigned to it
         * 
         * @return boolean
         */
        public function hasWorkersAssigned(){
            if($this->assignments->count() > 0){
                return true;
            } return false;
        }
        
        /**
         * Checks if the user is currently checked into the current work order
         * 
         * @return boolean
         */
        public function userCheckedIn(){
            $record = $this->getCurrentSession();
            
            if($record){
                if($record->in && $record->out === NULL){
                    return true;
                }
            } 
            
            return false;
        }
        
        /**
         * Returns the current users work order session record
         * 
         * @return object
         */
        public function getCurrentSession(){
            $record = $this->sessions()->where('user_id', Sentry::getUser()->id)->first();
            
            return $record;
        }
        
        /**
         * Returns pretty label of the work order status
         * 
         * @return string
         */
        public function getStatusLabelAttribute(){
            return sprintf(
                    '<span class="label label-%s">%s</span>', 
                    Config::get('maintenance::status.colors.'.$this->attributes['status']),
                    trans('maintenance::statuses.'.$this->attributes['status'])
                );
        }
}