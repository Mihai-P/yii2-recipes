<?php

use codeception\_pages\HomePage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that the home form opens');

$homePage = HomePage::openBy($I);

$I->see('Home', 'h1');
$I->see('Json Response');
$I->see('Submit', 'button');