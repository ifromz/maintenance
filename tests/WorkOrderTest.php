<?php

namespace Stevebauman\Maintenance\Tests;

class WorkOrderTest extends FunctionalTestCase
{
    public function testIndex()
    {
        $response = $this->call('GET', route('maintenance.work-orders.index'));

        $this->assertEquals(200, $response->getStatusCode());
    }
}
