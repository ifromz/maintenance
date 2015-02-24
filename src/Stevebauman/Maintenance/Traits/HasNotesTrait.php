<?php

namespace Stevebauman\Maintenance\Traits;


trait HasNotesTrait
{
    /**
     * The morph to many notes relationship allowing any model to contain notes
     *
     * @return mixed
     */
    public function notes()
    {
        return $this->morphToMany('Stevebauman\Maintenance\Models\Note', 'noteable')->withTimestamps();
    }

}