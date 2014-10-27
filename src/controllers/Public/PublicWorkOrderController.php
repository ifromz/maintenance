<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class PublicWorkorderController extends AbstractController {
    
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }
    
    public function index()
    {
        
    }
    
    public function create()
    {
        
    }
    
}