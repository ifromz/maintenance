<?php

namespace Stevebauman\Maintenance\Models;

use Baum\Node;

/**
 * Class Category.
 */
class Category extends Node
{
    /**
     * The categories table.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The scoped nested set attributes.
     *
     * @var array
     */
    protected $scoped = ['belongs_to'];

    /**
     * The fillable category attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'belongs_to',
    ];

    /**
     * The revisionable field names.
     *
     * @var array
     */
    protected $revisionFormattedFieldNames = [
        'name' => 'Name',
    ];

    /**
     * Returns a single lined string with arrows indicating depth of the current category.
     *
     * @return string
     */
    public function getTrailAttribute()
    {
        return renderNode($this);
    }

    /**
     * Compatibility with Revisionable.
     *
     * @return string
     */
    public function identifiableName()
    {
        return $this->getTrailAttribute();
    }
}
