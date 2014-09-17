<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Http\Requests\AssignmentRequest;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class AssignmentController extends BaseController {
    
        public function __construct(AssignmentRequest $assignment){
            $this->assignment = $assignment;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($workOrder_id){
            return $this->assignment->index($workOrder_id);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($workOrder_id){
            return $this->assignment->create($workOrder_id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($workOrder_id){
            return $this->assignment->store($workOrder_id, Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
	public function destroy($workOrder_id, $assignment_id)
	{
            return $this->assignment->destroy($workOrder_id, $assignment_id);
	}


}
