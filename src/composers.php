<?php

View::composer('maintenance::layouts.main', 'Stevebauman\Maintenance\Composers\MainLayoutComposer');

View::composer('maintenance::layouts.public', 'Stevebauman\Maintenance\Composers\PublicLayoutComposer');

View::composer('maintenance::select.assets', 'Stevebauman\Maintenance\Composers\AssetSelectComposer');

View::composer('maintenance::select.status', 'Stevebauman\Maintenance\Composers\StatusSelectComposer');

View::composer('maintenance::select.users', 'Stevebauman\Maintenance\Composers\UserSelectComposer');