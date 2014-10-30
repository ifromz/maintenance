<?php

namespace Stevebauman\Maintenance\Notifiers;

interface NotifierInterface {
    
    public function handleRevision($revision);
    
}