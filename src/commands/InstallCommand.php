<?php namespace Stevebauman\Maintenance\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {
        
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'maintenance:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'The maintenance install command to process migrations and other installation dependencies.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
            
            $this->info('Checking Dependencies');
            
            return $this->info($this->checkDependencies());

                $this->info('Dependency check all good');
                
                $this->info('Running migrations');

            
            //Artisan::call('migrate --bench="stevebauman/maintenance"');
	}

}
