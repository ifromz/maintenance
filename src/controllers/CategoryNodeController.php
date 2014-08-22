<?php namespace Stevebauman\Maintenance\Controllers;

use View;
use Validator;
use Request;
use Response;
use Redirect;
use Input;
use Config;
use Lang;
use Stevebauman\Maintenance\Services\CategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;

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
				
				$data = array(
					'name' => Input::get('name'),
					'icon' => Input::get('icon'),
				);
				
				$subcategory = $this->category->create($data);
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
