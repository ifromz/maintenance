<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Traits\HasEventsTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class Inventory extends BaseModel {
    
	use SoftDeletingTrait;
        
        use HasEventsTrait;
        
        protected $table = 'inventories';
        
	protected $viewer = 'Stevebauman\Maintenance\Viewers\InventoryViewer';
        
        protected $fillable = array(
            'user_id', 
            'metric_id', 
            'inventory_category_id', 
            'name', 
            'description'
        );
        
        protected $revisionFormattedFieldNames = array(
            'asset_category_id' => 'Category',
            'metric_id'     => 'Metric',
            'name'          => 'Name',
        );
        
        public function metric()
        {
            return $this->hasOne('Stevebauman\Maintenance\Models\Metric', 'id', 'metric_id');
        }
        
        public function stocks()
        {
            return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStock', 'inventory_id')->orderBy('quantity', 'DESC');
        }
        
        public function user()
        {
            return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
        
        public function category()
        {
            return $this->hasOne('Stevebauman\Maintenance\Models\InventoryCategory', 'id', 'inventory_category_id');
	}
        
        /*
         * Filters query by the inputted inventory item name
         */
        public function scopeName($query, $name = NULL)
        {
            if($name){
                return $query->where('name', 'LIKE', '%'.$name.'%');
            }
        }
        
        /*
         * Filters query by the inputted inventory item description
         */
        public function scopeDescription($query, $description = NULL)
        {
            if($description){
                return $query->where('description', 'LIKE', '%'.$description.'%');
            }
        }
        
        /*
         * Filters query by the inputted inventory item stock quantity
         */
        public function scopeStock($query, $operator = NULL, $stock = NULL)
        {
            if($operator && $stock){
                
                return $query->whereHas('stocks', function($query) use ($operator, $stock){
                    
                    if($output = $this->getOperator($operator)){
                        
                        return $query->where('quantity', $output[0], $stock); 
                        
                    } else{
                        return $query;
                    }
                   
                });
            }
        }
        
        /**
         * Filters inventory results by specified category
         * 
         * @return object
         */
        public function scopeCategory($query, $category_id = NULL){
            
            if($category_id){
                
                /*
                 * Get descendants and self inventory category nodes
                 */
                $categories = Category::find($category_id)->getDescendantsAndSelf();
                
                /*
                 * Perform a subquery on main query
                 */
                $query->where(function ($query) use ($categories) {
                    
                    /*
                     * For each category, apply a orWhere query to the subquery
                     */
                    foreach($categories as $category){
                        $query->orWhere('category_id', $category->id);
                    }
                    
                    return $query;
                    
                });
                
            }
	}
        
        /*
         * Mutator for showing the total current stock of the inventory item
         */
        public function getCurrentStockAttribute()
        {
            if($this->stocks->count() > 0){
                
                $stock = $this->stocks->sum('quantity');
                
                if($this->metric_symbol){
                    return sprintf('%s %s', $stock, $this->metric_symbol);
                } 
                
                return $stock;
                
            } return 0;
        }
        
        public function getMetricSymbolAttribute()
        {
            if($this->metric){
                return $this->metric->symbol;
            }
            
            return NULL;
        }
}