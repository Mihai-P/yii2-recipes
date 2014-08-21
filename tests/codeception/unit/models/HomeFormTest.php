<?php

namespace codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\models\RecipeForm;

class HomeFormTest extends TestCase
{
    use Specify;

    public function testModel()
    {
        $model = new RecipeForm([
            'filename' => 'test_fridge.csv',
            'text' => '[
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
        ]);        
        $model->validate();
        $recipes = $model->findRecipes();

        $this->specify('model returns a result', function () use ($model, $recipes) {
            expect('model is valid', $model->validate())->true();
            expect('recipes is an array', is_array($recipes))->true();
            expect('there is 1 recipe in the result', count($recipes)==1)->true();
        });

        
        

        

        
    }
}