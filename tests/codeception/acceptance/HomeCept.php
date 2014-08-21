<?php

use codeception\_pages\HomePage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that the recipe form works');

$homePage = HomePage::openBy($I);

$I->amOnPage(Yii::$app->homeUrl);
$I->see('Home', 'h1');
$I->see('Json Response');
$I->see('Submit', 'button');

$I->amGoingTo('submit form with no data');
$homePage->submit([]);
$I->expectTo('see validations errors');
$I->see('Home', 'h1');
$I->see('CSV File cannot be blank.');
$I->see('Please complete either the url or the text');


$I->amGoingTo('submit form with a file but a wrong json');
$homePage->submit([
    'text'          =>  'tester\r\ntest2',
    'filename'          =>  'test_fridge.csv',
]);
$I->expectTo('see that the file is attached but errors exist');
$I->see('The Json is invalid.');
$I->dontSee('CSV File cannot be blank.');
$I->see('You have already uploaded the file test_fridge.csv');



$I->amGoingTo('submit form with a file but an invalid url');
$homePage->submit([
    'text'          =>  '',
    'url'          =>  'tester',
    'filename'          =>  'test_fridge.csv',
]);
$I->expectTo('see an URL error');
$I->see('Url is not a valid URL');


$I->amGoingTo('submit form with a file but an url that does not return a json');
$homePage->submit([
    'text'          =>  '',
    'url'          =>  'http://google.com',
    'filename'          =>  'test_fridge.csv',
]);
$I->expectTo('see an URL & Json error');
$I->see('The URL did not return a valid Json response.');

$I->amGoingTo('submit form with valid data');

$homePage->submit([
    'text'          =>  '[
    {
        "name": "grilled cheese on toast",
        "ingredients": [
            { "item":"bread", "amount":"2", "unit":"slices"},
            { "item":"cheese", "amount":"2", "unit":"slices"}
        ]
    }
    ,
    {
        "name": "salad sandwich",
        "ingredients": [
            { "item":"bread", "amount":"2", "unit":"slices"},
            { "item":"mixed salad", "amount":"100", "unit":"grams"}
        ]
    }
]',
    'url'          =>  '',
    'filename'          =>  'test_fridge.csv',
]);
$I->expectTo('see a recipe');
$I->see('You can cook a grilled cheese on toast');