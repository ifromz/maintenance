<?php 

namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Stevebauman\Maintenance\Controllers\AbstractController;

abstract class AbstractNestedSetController extends AbstractController {
	
	protected $service;
	
	protected $serviceValidator;
	
        /*
         * Holds the title of the nested set resource.
         * Ex. Categories or Locations
         */
        public $resource;
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$categories = $this->service->get();

		return $this->view('maintenance::categories.index', array(
                    'title' => sprintf('All %s', str_plural($this->resource)),
                    'categories' => $categories,
                    'resource' => $this->resource
                ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id = NULL){
		if($id){
                    if($category = $this->service->find($id)){
                        return $this->view('maintenance::categories.nodes.create', array(
                            'title' => sprintf('Create a %s under %s', $this->resource, $category->name),
                            'category' => $category,
                            'resource' => $this->resource
                        ));
                    }
		} else{
                    return $this->view('maintenance::categories.create', array(
                        'title' => sprintf('Create a %s', $this->resource),
                        'resource' => $this->resource
                    ));
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
			
                    $category = $this->service->setInput($this->inputAll())->create();

                    if($id){
                        $parent = $this->service->find($id);
                        $category->makeChildOf($parent);
                    }

                    $this->message = sprintf('Successfully created %s', $this->resource);
                    $this->messageType = 'success';
			
		} else{
                    $this->errors = $validator->getErrors();
		}
                
                return $this->response();
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
            $category = $this->service->find($id);
            
            return $this->view('maintenance::categories.edit', array(
                'title' => sprintf('Edit %s', $this->resource),
                'category' => $category,
                'resource' => $this->resource
            ));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
            $validator = new $this->serviceValidator;

            if($validator->passes()){

                    $this->service->setInput($this->inputAll())->update($id);
                    
                    $this->message = sprintf('Successfully edited %s. %s', $this->resource, link_to_action(currentControllerAction('index'), 'View All'));
                    $this->messageType = 'success';

            } else{
                $this->errors = $validator->getErrors();
            }
            
            return $this->response();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		$this->service->destroy($id);
		
                $this->message = sprintf('Successfully deleted %s', $this->resource);
                $this->messageType = 'success';
                $this->redirect = action(currentControllerAction('index'));

                return $this->response();
	}
	
	public function postMoveCategory($id){
            if($category = $this->service->find($id)){
                $parent = $this->input('parent_id');

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
                        
                    } 
                    
                    return Response::json($json_categories);
                    
                } else{
                    return NULL;
                }
            }
	}
	
	
}