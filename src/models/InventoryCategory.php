<?php namespace Stevebauman\Maintenance\Models;

use Baum\Node;

class InventoryCategory extends Node {

    protected $table = 'inventory_categories';
    
    /**
     * Compatibility with Revisionable
     * 
     * @return string
     */
    public function identifiableName()
    {
        return renderNode($this);
    }
    
}
