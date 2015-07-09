<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasRevisionsTrait;
use Baum\Node;

class Location extends Node
{
    use HasRevisionsTrait;

    /**
     * The locations table.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The fillable location attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The columns to keep revisions of.
     *
     * @var array
     */
    protected $revisionColumns = [
        'name',
    ];

    /**
     * The revision formatted field name attributes.
     *
     * @var array
     */
    protected $revisionColumnsFormatted = [
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
