<?php 
$I = new FunctionalTester($scenario);
$user = Sentry::findUserById(1);
Sentry::login($user, false);
$I->wantTo('Make sure dashboard works');
$I->amOnRoute('maintenance.dashboard.index');
$I->see('Dashboard');
