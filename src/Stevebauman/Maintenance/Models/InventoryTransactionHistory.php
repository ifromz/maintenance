<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Inventory\Traits\InventoryTransactionHistoryTrait;

/**
 * Class InventoryTransactionHistory
 * @package Stevebauman\Maintenance\Models
 */
class InventoryTransactionHistory extends BaseModel
{
    use InventoryTransactionHistoryTrait;

    protected $fillable = array(
        'transaction_id',
        'state_before',
        'state_after',
        'quantity_before',
        'quantity_after',
    );

    protected $table = 'inventory_transaction_histories';

    /**
     * The belongsTo transaction relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\InventoryTransaction', 'transaction_id', 'id');
    }
}