<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\RecipeForm;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\web\Response;

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
        $recipe = false;
	if (Yii::$app->request->isAjax)  { 
	    $model->load(Yii::$app->request->post()); 
	    Yii::$app->response->format = Response::FORMAT_JSON; 
	    return ActiveForm::validate($model); 
	} elseif (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $recipe = $model->findRecipes();
            } 
        }

        return $this->render('index', [
            'model' => $model,
            'recipe' => $recipe,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }    
}