<?php

namespace Stevebauman\Maintenance\Traits;


trait HasNotesTrait {

    public function notes()
    {
        return $this->morphToMany('Stevebauman\Maintenance\Models\Note', 'noteable')->withTimestamps();
    }

}