<?php namespace Stevebauman\Maintenance\Http\Composers;

use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Services\CategoryService;

class MainLayoutComposer {
        
        public function __construct(CategoryService $category){
            $this->category = $category;
        }
    
	public function compose($view){
            $siteTitle = Config::get('maintenance::site.title.backend', 'Maintenance');
            
            $siteCategoryRoots = $this->category->roots();
            
            $view->with('siteTitle', $siteTitle);
            $view->with('siteCategoryRoots', $siteCategoryRoots);
	}
	
}