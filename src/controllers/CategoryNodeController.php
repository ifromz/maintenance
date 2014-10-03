<?php namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Stevebauman\Maintenance\Services\CategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Controllers\BaseController;

class CategoryNodeController extends BaseController {
	
	public function __construct(CategoryService $category, CategoryValidator $categoryValidator){
		$this->category = $category;
		$this->categoryValidator = $categoryValidator;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($category_id){
		if($category = $this->category->find($category_id)){
			$icons = Config::get('maintenance::category.icons');
			
			$this->layout = View::make('maintenance::categories.nodes.create')
				->with(compact('category'))
				->with(compact('icons'));
			$this->layout->title = sprintf('Create Sub-Category <small>%s</small>', renderNode($category));
		} else{
			
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($category_id){
		if($category = $this->category->find($category_id)){
			$validator = new $this->categoryValidator;
			
			if($validator->passes()){
				
				$subcategory = $this->category->create($this->inputAll());
				$subcategory->makeChildOf($category);
				
				if(Request::ajax()){
					return Response::json(array(
						'category_created' => true,
						'message' => Lang::get('maintenance::messages/category.create.success'),
						'messageType' => 'success',
					));
				} else{
					
				}
			} else{
				return Response::json(array(
					'category_created' => false,
					'errors' => $validator->getJsonErrors(),
				));
			}
		}
	}


}
