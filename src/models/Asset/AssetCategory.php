<?php namespace Stevebauman\Maintenance\Models;

use Baum\Node;

class AssetCategory extends Node {

    protected $table = 'asset_categories';
    
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
