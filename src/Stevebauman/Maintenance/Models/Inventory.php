<?php

namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Stevebauman\Inventory\Traits\InventoryTrait;
use Stevebauman\Inventory\Traits\InventoryVariantTrait;
use Stevebauman\Maintenance\Traits\Scopes\HasScopeArchivedTrait;
use Stevebauman\Maintenance\Traits\Scopes\HasScopeIdTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasNotesTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasCategoryTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasEventsTrait;

/**
 * Class Inventory.
 */
class Inventory extends BaseModel
{
    use SoftDeletes;

    use InventoryTrait;
    use InventoryVariantTrait;

    use HasScopeArchivedTrait;
    use HasScopeIdTrait;
    use HasCategoryTrait;
    use HasEventsTrait;
    use HasUserTrait;
    use HasNotesTrait;

    /**
     * The database table to store inventory records.
     *
     * @var string
     */
    protected $table = 'inventories';

    /**
     * The fillable eloquent attribute array for allowing mass assignments.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'metric_id',
        'category_id',
        'name',
        'description',
        'is_assembly',
    ];

    /**
     * Revisionable field names.
     *
     * @var array
     */
    protected $revisionFormattedFieldNames = [
        'category_id' => 'Category',
        'metric_id' => 'Metric',
        'name' => 'Name',
    ];

    /**
     * The inventory viewer class.
     *
     * @var string
     */
    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryViewer';

    /**
     * The hasOne metric relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function metric()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Metric', 'id', 'metric_id');
    }

    /**
     * The hasOne SKU relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sku()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\InventorySku', 'inventory_id', 'id');
    }

    /**
     * The hasMany stocks relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStock', 'inventory_id');
    }

    /**
     * The hasMany assemblies relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assemblies()
    {
        return $this->hasMany('Stevebauman\Inventory\Models\InventoryAssembly', 'inventory_id');
    }

    /**
     * The hasMany suppliers relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function suppliers()
    {
        return $this->belongsToMany('Stevebauman\Maintenance\Models\Supplier', 'inventory_suppliers', 'inventory_id')->withTimestamps();
    }

    /**
     * Filters query by the inputted inventory item name.
     *
     * @param $query
     * @param string $name
     *
     * @return mixed
     */
    public function scopeName($query, $name = null)
    {
        if ($name) {
            return $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return $query;
    }

    /**
     * Filters query by the inputted inventory item description.
     *
     * @param $query
     * @param string $description
     *
     * @return mixed
     */
    public function scopeDescription($query, $description = null)
    {
        if ($description) {
            return $query->where('description', 'LIKE', '%'.$description.'%');
        }

        return $query;
    }
    /**
     * Filters query by the inputted inventory item stock quantity.
     *
     * @param $query
     * @param string $operator
     * @param string $stock
     *
     * @return mixed
     */
    public function scopeStock($query, $operator = null, $stock = null)
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

        return $query;
    }

    /**
     * Filters query by the inputted inventory sku.
     *
     * @param $query
     * @param string $sku
     *
     * @return mixed
     */
    public function scopeSku($query, $sku = null)
    {
        if ($sku) {
            return $query->whereHas('sku', function ($query) use ($sku) {
                return $query->where('code', 'LIKE', '%'.$sku.'%');
            });
        }

        return $query;
    }

    /**
     * Filters inventory results by showing
     * only parent inventory items.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNoVariants($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Mutator for showing the total current stock of the inventory item.
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
     * Mutator for showing the inventories metric symbol.
     *
     * @return null|string
     */
    public function getMetricSymbolAttribute()
    {
        if ($this->hasMetric()) {
            return $this->getMetricSymbol();
        }

        return;
    }
}
