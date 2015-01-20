<?php

namespace Stevebauman\Maintenance\Commands;

use Illuminate\Console\Command;

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
	protected $description = 'Installs the maintenance application';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Checking Dependencies');

		$this->call('maintenance:check-depends');

		$this->info('Checking Database Schema');

		$this->call('maintenance:check-schema');

		$this->info('Running migrations');

		$this->call('maintenance:run-migrations');

		$this->info('Maintenance has been successfully installed');

		if($this->confirm('Do you want us to seed the database? [yes|no]', true)) {

			$this->info('Running Seeds');

			$this->call('maintenance:run-seeds');

		}

		if($this->confirm('Do you want to create an administrator? [yes|no]', true)) {

			$this->call('maintenance::create-admin');

		}

	}

}
