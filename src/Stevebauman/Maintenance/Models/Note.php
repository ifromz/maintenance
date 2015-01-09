<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class Note {

    use HasUserTrait;

    protected $table = 'notes';

    protected $fillable = array(
        'user_id',
        'content',
    );

}