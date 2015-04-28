<?php

use Illuminate\Support\Facades\Event;

/*
 * Event listeners for generation notifications
 */
Event::subscribe('Stevebauman\Maintenance\Listeners\WorkOrderListener');