<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class WorkOrderPartController extends AbstractController {
        
        public function __construct(WorkOrderService $workOrder, InventoryService $inventory){
            $this->workOrder = $workOrder;
            $this->inventory = $inventory;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($workOrder_id)
	{   
            $workOrder = $this->workOrder->find($workOrder_id);
            $items = $this->inventory->setInput($this->inputAll())->getByPageWithFilter();
            
            return $this->view('maintenance::work-orders.parts.index', array(
                'title' => 'Add parts to Work Order: '.$workOrder->subject,
                'workOrder' => $workOrder,
                'items' => $items,
            ));
            
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($workOrder_id)
	{
           
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	public function destroy($id)
	{
		//
	}


}
