<?php

namespace Stevebauman\Maintenance\Models\Extended;

use Venturecraft\Revisionable\RevisionableTrait;
use Stevebauman\Viewer\Traits\ViewableTrait;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Inventory\Models\InventoryStockMovement as BaseMovement;

/**
 * Class InventoryStockMovement
 * @package Stevebauman\Maintenance\Models\Extended
 */
class InventoryStockMovement extends BaseMovement
{
    use RevisionableTrait;

    use TableTrait;

    use ViewableTrait;

    use HasUserTrait;

    protected $viewer = 'Stevebauman\Maintenance\Viewers\Inventory\InventoryStockMovementViewer';

}