<?php

namespace Stevebauman\Maintenance\Tests;

use Illuminate\Foundation\Testing\TestCase;

abstract class FunctionalTestCase extends TestCase
{
    /**
     * Creates a new App instance.
     *
     * @return mixed|\Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }
}
