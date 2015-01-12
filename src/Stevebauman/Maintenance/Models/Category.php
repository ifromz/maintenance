<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseCategoryModel;

/**
 * Class Category
 * @package Stevebauman\Maintenance\Models
 */
class Category extends BaseCategoryModel {

    protected $table = 'categories';

    protected $scoped = array('belongs_to');

    protected $fillable = array(
        'name',
        'belongs_to',
    );

}