<?php

namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Stevebauman\Inventory\Traits\InventoryTrait;
use Stevebauman\Maintenance\Traits\HasScopeArchivedTrait;
use Stevebauman\Maintenance\Traits\HasNotesTrait;
use Stevebauman\Maintenance\Traits\HasScopeIdTrait;
use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Maintenance\Traits\HasCategoryTrait;
use Stevebauman\Maintenance\Traits\HasEventsTrait;

/**
 * Class Inventory
 * @package Stevebauman\Maintenance\Models
 */
class Inventory extends BaseModel
{
    use SoftDeletingTrait;
    use InventoryTrait;
    use HasScopeArchivedTrait;
    use HasScopeIdTrait;
    use HasCategoryTrait;
    use HasEventsTrait;
    use HasUserTrait;
    use HasNotesTrait;

    /**
     * The database table to store inventory records
     *
     * @var string
     */
    protected $table = 'inventories';

    /**
     * The fillable eloquent attribute array for allowing mass assignments
     *
     * @var array
     */
    protected $fillable = array(
        'user_id',
        'metric_id',
        'category_id',
        'name',
        'description'
    );

    /**
     * Revisionable field names
     *
     * @var array
     */
    protected $revisionFormattedFieldNames = array(
        'category_id' => 'Category',
        'metric_id' => 'Metric',
        'name' => 'Name',
    );

    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryViewer';

    /**
     * The hasOne metric relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function metric()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Metric', 'id', 'metric_id');
    }

    /**
     * The hasOne SKU relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sku()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\InventorySku', 'inventory_id', 'id');
    }

    /**
     * The hasMany stocks relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStock', 'inventory_id');
    }

    /**
     * Filters query by the inputted inventory item name
     *
     * @param $query
     * @param null $name
     * @return mixed
     */
    public function scopeName($query, $name = NULL)
    {
        if ($name) {
            return $query->where('name', 'LIKE', '%' . $name . '%');
        }
    }

    /**
     * Filters query by the inputted inventory item description
     *
     * @param $query
     * @param null $description
     * @return mixed
     */
    public function scopeDescription($query, $description = NULL)
    {
        if ($description) {
            return $query->where('description', 'LIKE', '%' . $description . '%');
        }
    }
    /**
     * Filters query by the inputted inventory item stock quantity
     *
     * @param $query
     * @param null $operator
     * @param null $stock
     * @return mixed
     */
    public function scopeStock($query, $operator = NULL, $stock = NULL)
    {
        if ($operator && $stock) {
            return $query->whereHas('stocks', function ($query) use ($operator, $stock) {
                if ($output = $this->getOperator($operator)) {
                    return $query->where('quantity', $output[0], $stock);
                } else {
                    return $query;
                }
            });
        }
    }

    /**
     * Mutator for showing the total current stock of the inventory item
     *
     * @return int|string
     */
    public function getCurrentStockAttribute()
    {
        $stock = $this->getTotalStock();

        if ($this->hasMetric()) {
            return sprintf('%s %s', $stock, $this->getMetricSymbol());
        }

        return $stock;
    }

    /**
     * Mutator for showing the inventories metric symbol
     *
     * @return null|string
     */
    public function getMetricSymbolAttribute()
    {
        if ($this->hasMetric()) {
            return $this->getMetricSymbol();
        }

        return NULL;
    }

}