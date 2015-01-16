<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasLocationTrait;
use Stevebauman\Inventory\Traits\InventoryStockTrait;

class InventoryStock extends BaseModel
{

    use InventoryStockTrait;

    use HasLocationTrait;

    /**
     * The database table to store inventory stock records
     *
     * @var string
     */
    protected $table = 'inventory_stocks';

    /**
     * The fillable eloquent attribute array for allowing mass assignments
     *
     * @var array
     */
    protected $fillable = array(
        'inventory_id',
        'location_id',
        'quantity'
    );

    protected $revisionFormattedFieldNames = array(
        'location_id' => 'Location',
        'quantity' => 'Quantity',
    );

    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryStockViewer';

    /*
    * The belongsTo item relationship
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function item()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Inventory', 'inventory_id', 'id');
    }

    /**
     * The hasMany movements relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStockMovement', 'stock_id');
    }

}