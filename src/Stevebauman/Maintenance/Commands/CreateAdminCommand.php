<?php

namespace Stevebauman\Maintenance\Commands;

use Stevebauman\Maintenance\Services\SentryService;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
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
     * The Sentry service for creating a new user.
     *
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;

        parent::__construct();
    }

    /**
     * Execute the command.
     */
    public function fire()
    {
        $user = [
            'first_name' => $this->askFirstName(),
            'last_name' => $this->askLastName(),
            'email' => $this->askEmail(),
            'username' => $this->askUsername(),
            'password' => $this->askPassword(),
            'permissions' => ['superuser' => 1],
        ];

        $newUser = $this->sentry->createUser($user);

        if ($newUser) {
            $this->info('Successfully created user');
        } else {
            $this->error('There was an error trying to create a user, please try again.');
        }
    }

    /**
     * Ask for the administrators first name.
     *
     * @return string
     */
    private function askFirstName()
    {
        return $this->ask('What will you use as the administrators first name? ');
    }

    /**
     * Ask for the administrators last name.
     *
     * @return string
     */
    private function askLastName()
    {
        return $this->ask('What will you use as the administrators last name? ');
    }

    /**
     * Ask for the administrators username.
     *
     * @return string
     */
    private function askUsername()
    {
        return $this->ask('What will you use as the administrators username? ');
    }

    /**
     * Ask for the administrators email.
     *
     * @return string
     */
    private function askEmail()
    {
        return $this->ask('What will you use as the administrators email? ');
    }

    /**
     * Ask for the administrators password.
     *
     * @return string
     */
    private function askPassword()
    {
        return $this->ask('What will you use as the administrators password? ');
    }
}
