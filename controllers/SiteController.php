<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\RecipeForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new RecipeForm();
        $recipes = false;
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $recipes = $model->findRecipes();
            } 
        }

        return $this->render('index', [
            'model' => $model,
            'recipes' => $recipes,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }    
}