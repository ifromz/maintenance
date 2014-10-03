<?php

/*
 * Main Layout Composer
 */
View::composer('maintenance::layouts.main', 'Stevebauman\Maintenance\Http\Composers\MainLayoutComposer');

/*
 * Notifications Composer
 */
View::composer('maintenance::layouts.main.notifications', 'Stevebauman\Maintenance\Http\Composers\MainNotificationComposer');

View::composer('maintenance::layouts.public', 'Stevebauman\Maintenance\Http\Composers\PublicLayoutComposer');

View::composer('maintenance::select.assets', 'Stevebauman\Maintenance\Http\Composers\AssetSelectComposer');

View::composer('maintenance::select.status', 'Stevebauman\Maintenance\Http\Composers\StatusSelectComposer');

View::composer('maintenance::select.users', 'Stevebauman\Maintenance\Http\Composers\UserSelectComposer');