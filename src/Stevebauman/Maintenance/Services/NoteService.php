<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Note;
use Stevebauman\Maintenance\Services\BaseModelService;

class NoteService extends BaseModelService
{

    public function __construct(Note $note)
    {
        $this->model = $note;
    }

}