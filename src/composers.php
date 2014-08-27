<?php

View::composer('maintenance::layouts.main', 'Stevebauman\Maintenance\Composers\MainLayoutComposer');

View::composer('maintenance::select.assets', 'Stevebauman\Maintenance\Composers\AssetSelectComposer');

View::composer('maintenance::select.status', 'Stevebauman\Maintenance\Composers\StatusSelectComposer');