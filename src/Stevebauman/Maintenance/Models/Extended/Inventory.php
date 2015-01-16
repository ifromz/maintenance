<?php

namespace Stevebauman\Maintenance\Models\Extended;

use Venturecraft\Revisionable\RevisionableTrait;
use Stevebauman\Viewer\Traits\ViewableTrait;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Maintenance\Traits\HasScopeArchivedTrait;
use Stevebauman\Maintenance\Traits\HasNotesTrait;
use Stevebauman\Maintenance\Traits\HasScopeIdTrait;
use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Maintenance\Traits\HasCategory;
use Stevebauman\Maintenance\Traits\HasEventsTrait;
use Stevebauman\Inventory\Models\Inventory as BaseInventory;

/**
 * Class Inventory
 * @package Stevebauman\Maintenance\Models\Extended
 */
class Inventory extends BaseInventory
{

    use RevisionableTrait;

    use TableTrait;

    use ViewableTrait;

    use HasScopeArchivedTrait;
    use HasEventsTrait;
    use HasCategory;
    use HasUserTrait;
    use HasNotesTrait;
    use HasScopeIdTrait;

    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryViewer';

    protected $dontKeepRevisionOf = array('deleted_at');

    public function metric()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Extended\Metric', 'id', 'metric_id');
    }

    public function stocks()
    {
        return $this->hasMany('Stevebauman\Maintenance\Models\Extended\InventoryStock', 'inventory_id')->orderBy('quantity', 'DESC');
    }

}