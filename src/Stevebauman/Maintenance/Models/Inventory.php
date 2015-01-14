<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasNotesTrait;
use Stevebauman\Maintenance\Traits\HasScopeIdTrait;
use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Maintenance\Traits\HasCategory;
use Stevebauman\Maintenance\Traits\HasEventsTrait;
use Stevebauman\Inventory\Models\Inventory as BaseInventory;

class Inventory extends BaseInventory
{

    use HasEventsTrait;
    use HasCategory;
    use HasUserTrait;
    use HasNotesTrait;
    use HasScopeIdTrait;

    protected $viewer = 'Stevebauman\Maintenance\Viewers\InventoryViewer';

    protected $revisionFormattedFieldNames = array(
        'category_id' => 'Category',
        'metric_id' => 'Metric',
        'name' => 'Name',
    );

    public function metric()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Metric', 'id', 'metric_id');
    }

    public function stocks()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStock', 'inventory_id')->orderBy('quantity', 'DESC');
    }

}