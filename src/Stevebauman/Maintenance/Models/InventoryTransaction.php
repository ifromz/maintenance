<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Inventory\Interfaces\StateableInterface;
use Stevebauman\Inventory\Traits\InventoryTransactionTrait;

/**
 * Class InventoryTransaction.
 */
class InventoryTransaction extends BaseModel implements StateableInterface
{
    use InventoryTransactionTrait;

    protected $fillable = [
        'stock_id',
        'state',
        'quantity',
    ];

    protected $table = 'inventory_transactions';

    /**
     * The belongsTo stock relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\InventoryStock', 'stock_id', 'id');
    }

    /**
     * The hasMany histories relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryTransactionHistory', 'transaction_id', 'id');
    }
}
