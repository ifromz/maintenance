<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Handle Revision Events
 */
Event::subscribe('Stevebauman\Maintenance\Listeners\RevisionListener');

Event::subscribe('Stevebauman\Maintenance\Listeners\WorkOrderListener');