<?php namespace Stevebauman\Maintenance\Models;

use Baum\Node;

class Location extends Node {

    protected $table = 'locations';
    
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
