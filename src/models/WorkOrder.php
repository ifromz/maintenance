<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Support\Facades\Config;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class WorkOrder extends BaseModel {
        use SoftDeletingTrait;
    
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
        );
        
        protected $revisionFormattedFieldNames = array(
            'location_id'               => 'Location',
            'work_order_category_id'    => 'Work Order Category',
            'status'                    => 'Status',
            'priority'                  => 'Priority',
            'subject'                   => 'Subject', 
            'description'               => 'Description', 
            'started_at'                => 'Started At', 
            'completed_at'              => 'Completed At',
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
        
        public function attachments(){
		return $this->belongsToMany('Stevebauman\Maintenance\Models\Attachment', 'work_order_attachments', 'work_order_id', 'attachment_id')->withTimestamps();
	}
        
        public function parts(){
            return $this->belongsToMany('Stevebauman\Maintenance\Models\InventoryStock', 'work_order_parts', 'work_order_id', 'stock_id')->withTimestamps()->withPivot('id', 'quantity');
        }
        
        /**
         * Filters work order results by priority
         * 
         * @return object
         */
        public function scopePriority($query, $priority = NULL){
            
            if(isset($priority) && $priority != '0'){
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
            if(isset($status) && $status != 0){
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
            if(array_key_exists('status', $this->attributes)){
                return sprintf(
                    '<span class="label label-%s">%s</span>', 
                    Config::get('maintenance::status.colors.'.$this->attributes['status']),
                    trans('maintenance::statuses.'.$this->attributes['status'])
                );
            }
        }
        
        /**
         * Returns a pretty label of the work order priority
         * 
         * @return string
         */
        public function getPriorityLabelAttribute(){
            if(array_key_exists('priority', $this->attributes)){
                return sprintf(
                    '<span class="label label-%s">%s</span>' , 
                    Config::get('maintenance::priority.colors.'.$this->attributes['priority']),
                    trans('maintenance::priorities.'.$this->attributes['priority'])
                );
            }
            
        }
        
        /**
         * Set the default work order category id to null if the given value is empty
         * 
         * @param type $value
         */
        public function setWorkOrderCategoryIdAttribute($value){
            $this->attributes['work_order_category_id'] = $value ? $value : NULL;
        }
        
        
        /**
         * Set the default location id to null if the given value is empty
         * 
         * @param type $value
         */
        public function setLocationIdAttribute($value){
            $this->attributes['location_id'] = $value ? $value : NULL;
        }
}