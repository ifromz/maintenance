<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\AbstractNestedSetModelService;

class CategoryService extends AbstractNestedSetModelService {
	
	public function __construct(Category $category){
		$this->model = $category;
	}
        
        public function roots(){
            return $this->model->roots()->get();
        }
	
}