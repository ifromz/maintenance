<?php

namespace Stevebauman\Maintenance\Commands;

use Stevebauman\Maintenance\Services\SentryService;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a superuser for the maintenance application';

    /**
     * The Sentry service for creating a new user
     *
     * @var SentryService
     */
    protected $sentry;

    public function __construct(SentryService $sentry){

        $this->sentry = $sentry;

        parent::__construct();
    }

    public function fire()
    {
        $user = array(

            'first_name' => $this->askFirstName(),
            'last_name' => $this->askLastName(),
            'email' => $this->askEmail(),
            'username' => $this->askUsername(),
            'password' => $this->askPassword(),
            'permissions' => array('superuser' => 1),

        );

        $newUser = $this->sentry->createUser($user);

        if($newUser) {

            $this->info('Successfully created user');

        } else {

            $this->error('There was an error trying to create a user, please try again.');

        }
    }

    private function askFirstName()
    {
        return $this->ask('What will you use as the administrators first name? ');
    }

    private function askLastName()
    {
        return $this->ask('What will you use as the administrators last name? ');
    }

    private function askUsername()
    {
        return $this->ask('What will you use as the administrators username? ');
    }

    private function askEmail()
    {
        return $this->ask('What will you use as the administrators email? ');
    }

    private function askPassword()
    {
        return $this->ask('What will you use as the administrators password? ');
    }


}