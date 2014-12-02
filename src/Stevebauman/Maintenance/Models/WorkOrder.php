<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\WorkOrderCategory;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class WorkOrder extends BaseModel {
    
        use SoftDeletingTrait;
    
	protected $table = 'work_orders';
	
        protected $viewer = 'Stevebauman\Maintenance\Viewers\WorkOrderViewer';
        
	protected $fillable = array(
            'user_id', 
            'location_id', 
            'work_order_category_id', 
            'status_id', 
            'priority_id', 
            'subject', 
            'description', 
            'started_at', 
            'completed_at',
        );
        
        protected $revisionFormattedFieldNames = array(
            'location_id'               => 'Location',
            'work_order_category_id'    => 'Work Order Category',
            'status_id'                 => 'Status',
            'priority_id'               => 'Priority',
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
        
        public function status(){
            return $this->hasOne('Stevebauman\Maintenance\Models\Status', 'id', 'status_id');
        }
        
        public function priority(){
            return $this->hasOne('Stevebauman\Maintenance\Models\Priority', 'id', 'priority_id');
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
        
        public function notifiableUsers(){
            return $this->hasMany('Stevebauman\Maintenance\Models\WorkOrderNotification', 'work_order_id', 'id');
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
            
            if($priority){
                return $query->where('priority_id', $priority);
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
            if($status){
                return $query->where('status_id', $status);
            }
	}
        
        /**
         * Filters work order results by category
         * 
         * @return object
         */
        public function scopeCategory($query, $category_id = NULL){
            
            if($category_id){
                
                /*
                 * Get descendants and self work order category nodes
                 */
                $categories = WorkOrderCategory::find($category_id)->getDescendantsAndSelf();
                
                /*
                 * Perform a subquery on main query
                 */
                $query->where(function ($query) use ($categories) {
                    
                    /*
                     * For each category, apply a orWhere query to the subquery
                     */
                    foreach($categories as $category){
                        $query->orWhere('work_order_category_id', $category->id);
                    }
                    
                    return $query;
                    
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
                    return $query->whereIn('asset_id', $assets);
                });
            }
        }

        public function scopeUserHours($query, $user){
            if($user){
                return $query->whereHas('sessions', function($query) use ($user){
                    return $query->where('user_id', $user->id);
                });
            }
        }
        
        public function scopeAssignedUser($query, $user_id)
        {
            if($user_id){
                return $query->whereHas('assignments', function($query) use ($user_id){
                    return $query->where('to_user_id', $user_id);
                });
            }
        }
        
        /**
         * Checks if the current work order is complete by checking if a report
         * has been filled out
         * 
         * @return boolean
         */
        public function isComplete(){
            if($this->report){
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
         * Returns the current users work order notifications
         * 
         * @return object
         */
        public function getUserNotifications()
        {
            $record = $this->notifiableUsers()->where('user_id', Sentry::getUser()->id)->first();
            
            return $record; 
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
         * Alias for getUserNotificiations()
         * 
         * @return object
         */
        public function getNotifyAttribute(){
            return $this->getUserNotifications();
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