<?php

namespace Stevebauman\Maintenance\Tests;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Stevebauman\Maintenance\Tests\AbstractTestCase;

class WorkOrderControllerTest extends AbstractTestCase {
    
    public function setUp() {
        parent::setUp();
        
        $user = Sentry::findUserById(1);
        Sentry::setUser($user);
    }
    
    public function testIndex()
    {
        $this->call('GET', 'work-orders');
        
        $this->assertViewHas('workOrders');
    }
    
    public function testCreate()
    {
        $this->call('GET', 'work-orders/create');
    }
    
    public function testStoreSuccess()
    {
        $input = array(
            'status' => 1,
            'priority' => 1,
            'subject' => 'Testing Work Order Creation',
            'description' => 'Testing'
        );
        
        $this->call('POST', 'work-orders', $input);
        
        $this->assertRedirectedToRoute('maintenance.work-orders.index', null, ['flash']);
    }
    
}