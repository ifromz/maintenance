<?php

View::composer('maintenance::layouts.main', 'Stevebauman\Maintenance\Http\Composers\MainLayoutComposer');

View::composer('maintenance::layouts.public', 'Stevebauman\Maintenance\Http\Composers\PublicLayoutComposer');

View::composer('maintenance::select.assets', 'Stevebauman\Maintenance\Http\Composers\AssetSelectComposer');

View::composer('maintenance::select.status', 'Stevebauman\Maintenance\Http\Composers\StatusSelectComposer');

View::composer('maintenance::select.users', 'Stevebauman\Maintenance\Http\Composers\UserSelectComposer');