<?php

namespace Stevebauman\Maintenance\Traits;


trait CanBuildTreeTrait {

    /**
     * @param $categories
     * @return mixed
     */
    public function buildTree($categories = array())
    {
        return $this->model->buildTree($categories);
    }

}