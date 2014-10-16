<?php

namespace Stevebauman\Maintenance\Services;

use Cartalyst\Sentry\Groups\Eloquent\Group;
use Stevebauman\Maintenance\Services\AbstractModelService;

class SentryGroupService extends AbstractModelService {
    
    public function __construct(Group $group){
        $this->model = $group;
    }
    
}