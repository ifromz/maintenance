<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Note;

class NoteService extends BaseModelService
{

    public function __construct(Note $note)
    {
        $this->model = $note;
    }

}