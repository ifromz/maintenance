<?php

namespace Stevebauman\Maintenance\Models;

use Baum\Node;

class BaseCategoryModel extends Node {
    
    /**
     * Compatibility with Revisionable
     * 
     * @return string
     */
    public function identifiableName()
    {
        return renderNode($this);
    }
    
    public function getTrailAttribute()
    {
        return renderNode($this);
    }
    
}