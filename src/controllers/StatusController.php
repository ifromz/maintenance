<?php namespace Stevebauman\Maintenance\Controllers;

use View;
use Config;
use Input;
use Request;
use Response;
use Redirect;
use Stevebauman\Maintenance\Controllers\BaseController;
use Stevebauman\Maintenance\Services\StatusService;
use Stevebauman\Maintenance\Validators\StatusValidator;

class StatusController extends BaseController {
	
	public function __construct(StatusService $status, StatusValidator $statusValidator){
		$this->status = $status;
		$this->statusValidator = $statusValidator;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$statuses = $this->status->get();
		
		$this->layout = View::make('maintenance::statuses.index', compact('statuses'));
		$this->layout->title = 'All Statuses';
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		$colors = Config::get('maintenance::status.colors');
		
		$this->layout = View::make('maintenance::statuses.create', compact('colors'));
		$this->layout->title = 'Create Status';
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		$validator = new $this->statusValidator;
		
		if($validator->passes()){
			
			$data = array(
				'name' => Input::get('name'),
				'color' => Input::get('color'),
			);
			
			$this->status->create($data);
			
			if(Request::ajax()){
				return Response::json(array(
					'statusCreated' => true,
					'message' => 'Successfully created status',
					'messageType' => 'success'
				));
			} else{
				
			}
		} else{
			if(Request::ajax()){
				return Response::json(array(
					'statusCreated' => false,
					'errors' => $validator->getJsonErrors(),
				));
			} else{
				
			}
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		if($status = $this->status->find($id)){
			$colors = Config::get('maintenance::status.colors');
			
			$this->layout = View::make('maintenance::statuses.create', compact('colors'));
			$this->layout->title = 'Create Status';
		} else{
			
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		if($this->status->destroy($id)){
			if(Request::ajax()){
				return Response::json(array(
					'statusDeleted' => true,
					'message' => 'Successfully deleted status',
					'messageType', 'success'
				));
			} else{
				return Redirect::route('maintenance.statuses.index')
					->with('message', 'Successfully deleted status')
					->with('messageType', 'success');
			}
		} else{
			
		}
	}


}
