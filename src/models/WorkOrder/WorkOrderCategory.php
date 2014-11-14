<?php namespace Stevebauman\Maintenance\Models;

use Baum\Node;

class WorkOrderCategory extends Node {
    
    protected $table = 'work_order_categories';
    
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
