<?php namespace Stevebauman\Maintenance\Controllers;

use View;
use Validator;
use Request;
use Response;
use Redirect;
use Input;
use Config;
use Lang;
use Stevebauman\Maintenance\Controllers\BaseController;

abstract class AbstractNestedSetController extends BaseController {
	
	protected $service;
	
	protected $serviceValidator;
	
	public $indexTitle;
	
	public $createTitle;
	
	public $editTitle;
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$categories = $this->service->get();

		$this->layout = View::make('maintenance::categories.index', compact('categories'));
		$this->layout->title = $this->indexTitle;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id = NULL){
		if($id){
			if($category = $this->service->find($id)){
				$this->layout = View::make('maintenance::categories.nodes.create', compact('category'));
				$this->layout->title = sprintf('%s under %s', $this->createTitle, $category->name);
			}
		} else{
			$this->layout = View::make('maintenance::categories.create');
			$this->layout->title = $this->createTitle;
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id = NULL){
		$validator = new $this->serviceValidator;
		
		if($validator->passes()){
			
			$data = array(
				'name' => Input::get('name'),
			);
			
			$category = $this->service->create($data);
			
			if($id){
				if($parent = $this->service->find($id)){
					$category->makeChildOf($parent);
				}
			}
			
			return Response::json(array(
				'categoryCreated' => true,
				'message' => Lang::get('maintenance::messages/category.create.success'),
				'messageType' => 'success',
			));
			
		} else{
			return Response::json(array(
				'categoryCreated' => false,
				'errors' => $validator->getJsonErrors(),
			));
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		if($category = $this->service->find($id)){
			$this->layout = View::make('maintenance::categories.edit', compact('category'));
			$this->layout->title = $this->editTitle;
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		if($category = $this->service->find($id)){
			$validator = new $this->serviceValidator;
			
			if($validator->passes()){
				$data = array(
					'name' => Input::get('name'),
				);
				
				$category->update($data);
				
				return Response::json(array(
					'categoryEdited' => true,
					'message' => Lang::get('maintenance::messages/category.edit.success'),
					'messageType' => 'success'
				));
				
			} else{
				if(Request::ajax()){
					return Response::json(array(
						'categoryEdited' => false,
						'errors' => $validator->getJsonErrors(),
					));
				}
			}
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		$this->service->destroy($id);
		
		if(Request::ajax()){
			return Response::json(array(
				'categoryDeleted' => true,
				'message' => 'Successfully deleted category',
				'messageType' => 'success'
			));
		} else{
			return Redirect::action(currentControllerAction('index'))
				->with('message', 'Successfully deleted work order category')
				->with('messageType', 'success');
		}
	}
	
	public function postMoveCategory($id){
		if($category = $this->service->find($id)){
			$parent = Input::get('parent_id');
			
			if($parent == '#'){
				$category->makeRoot();
				
				return Response::json(array(
					'categoryMoved' => true,
				));
			} else{
				if($parent_category = $this->service->find($parent)){
					$category->makeChildOf($parent_category);
					
					return Response::json(array(
						'categoryMoved' => true,
					));
				}
			}
		}
	}
	
	/**
	 * Returns category list in JSON for jsTree
	 *
	 * @return Response
	 */
	public function getJson(){
		if(Request::ajax()){
			$categories = $this->service->orderBy('name', 'ASC')->get();
			
			if($categories->count() > 0){
				$json_categories = array();
				foreach($categories as $category){
					$json_categories[] = array(
						'id'=>(string)$category->id,
						'parent'=>($category->parent_id ? (string)$category->parent_id : '#'),
						'text'=>(string)$category->name,
						 "class" => "jstree-drop",
						 'data-jstree'=> array(
							'icon'=>$category->icon,
						),
					);
				} return Response::json($json_categories);
			} else{
				return NULL;
			}
		}
	}
	
	
}