<?php namespace Stevebauman\Maintenance\Seeders;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder {
    
    public function run(){
        //$this->call('Stevebauman\Maintenance\Seeders\PermissionSeeder');
        
        //$this->command->info('Permissions table successfully seeded');
        
        if(Config::get('maintenance::site.ldap.user_sync.enabled') === true){
            
            $this->call('Stevebauman\Maintenance\Seeders\UserSeeder');
            
            $this->command->info('Users table successfully seeded');
        }
    }
}