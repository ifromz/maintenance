<?php namespace Stevebauman\Maintenance\Seeders;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {
    
    public function run(){
        
        $manager = Sentry::getGroupProvider()->create(array(
            'name' => 'Manager',
            'permissions' => array(
                'maintenance.api.calendar.events.index'     => 1,
                'maintenance.api.calendar.events.create'    => 1,
                'maintenance.api.calendar.events.store'     => 1,
                'maintenance.api.calendar.events.show'      => 1,
                'maintenance.api.calendar.events.edit'      => 1,
                'maintenance.api.calendar.events.update'    => 1,
                'maintenance.api.calendar.events.destroy'   => 1,
            ),
        ));
        
        $worker = Sentry::getGroupProvider()->create(array(
            'name' => 'Worker',
            'permissions' => array(
                'maintenance.api.calendar.events.index'     => 1,
                'maintenance.api.calendar.events.create'    => 1,
                'maintenance.api.calendar.events.store'     => 1,
                'maintenance.api.calendar.events.show'      => 1,
                'maintenance.api.calendar.events.edit'      => 1,
                'maintenance.api.calendar.events.update'    => 1,
                'maintenance.api.calendar.events.destroy'   => 1,
            ),
        ));
        
        $student = Sentry::getGroupProvider()->create(array(
            'name' => 'Student',
            'permissions' => array(
                'maintenance.api.calendar.events.index'     => 1,
                'maintenance.api.calendar.events.create'    => 0,
                'maintenance.api.calendar.events.store'     => 0,
                'maintenance.api.calendar.events.show'      => 1,
                'maintenance.api.calendar.events.edit'      => 0,
                'maintenance.api.calendar.events.update'    => 0,
                'maintenance.api.calendar.events.destroy'   => 0,
            ),
        ));
        
    }
    
}