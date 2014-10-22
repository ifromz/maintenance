<?php namespace Stevebauman\Maintenance\Models;

use Baum\Node;

class Category extends Node {

    protected $table = 'categories';
    
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
