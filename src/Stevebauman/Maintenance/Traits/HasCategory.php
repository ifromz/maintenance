<?php

namespace Stevebauman\Maintenance\Traits;

use Stevebauman\Maintenance\Traits\HasScopeCategory;

trait HasCategory {

    use HasScopeCategory;

    public function category()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Category', 'id', 'category_id');
    }

}