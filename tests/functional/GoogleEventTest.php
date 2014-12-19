<?php

use Stevebauman\Maintenance\Services\Google\EventService;
use Stevebauman\EloquentTable\TableCollection;
use Stevebauman\CalendarHelper\CalendarHelper;

class GoogleEventTest extends \Codeception\TestCase\Test
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testGet()
    {
        $calendar = new CalendarHelper;
        
        $collection = new TableCollection;
        
        $eventService = new EventService($calendar, $collection);
        
        $this->assertInstanceOf(get_class($collection), $eventService->get());
    }
    
    public function testGetRecurrences()
    {
        
    }

}