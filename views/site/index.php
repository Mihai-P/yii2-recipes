<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use dosamigos\fileinput\FileInput;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
        if (is_array($recipes)) {
            if(count($recipes) > 0) {
                foreach($recipes as $recipe) { 
        ?>
            <div class="alert alert-success">
                You can cook a <?=$recipe['name'] ?>
            </div>
        <?php 
                }
            } else {
        ?>
            <div class="alert alert-danger">
                You cannot cook anything with what you have in the fridge.
            </div>
        <?php 
            }
        } 
    ?>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'recipe-form', 
                'options' => ['enctype'=>'multipart/form-data'],
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
                'validateOnChange' => false,
            ]); ?>
                <?= $form->field($model, 'filename', array('template' => "{input}"))->hiddenInput() ?>
                <?php  echo $form->field($model, 'file')->widget(FileInput::className(), [
                    'model' => $model,
                    'options' => ['accept' => 'text/csv']
                ])->hint($model->filename ? 'You have already uploaded the file ' . $model->filename . ' - ' . Html::a('remove', '#recipeform-filename', ['class' => 'remove-filename']) : '') ?>
                
                <?//= $form->field($model, 'file')->fileInput()->hint($model->filename ? 'You have already uploaded the file ' . $model->filename . ' - ' . Html::a('remove', '#recipeform-filename', ['class' => 'remove-filename']) : '') ?>
                <?= $form->field($model, 'url')->hint('Insert either the URL of the actual JSON response') ?>
                <?= $form->field($model, 'text')->textArea(['rows' => 12]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'recipe-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-7">
            <p>There are quite a few improvements that can be done, especially on the validation of both the CSV file and the Json. For the CSV file I validate:</p>
            <h2>CSV</h2>
            <p>For the CSV file I validate:</p>
            <ul>
                <li>That the file is a CSV file</li>
                <li>That it can be opened by a CSV parser</li>
                <li>That it has 4 columns all the time</li>
            </ul>
            <p>Other possible validations (that can be done easily with a model):</p>
            <ul>
                <li>That each column has the appropriate type</li>
            </ul>
            <p>If the row has an expired date I ignore it directly as it will not be used in any recipe.</p>
            <p>If the user uploads a file but there are errors on the rest of page I remember the uploaded file for convenience.</p>
            <h2>JSON</h2>
            <p>For the Json input I validate:</p>
            <ul>
                <li>That it has a proper Json format</li>
            </ul>
            <p>Other possible validations (that can be done easily with a model):</p>
            <ul>
                <li>That it has the exact structure that was in the scope.</li>
            </ul>
            <h2>Recipes</h2>
            <p>I ignore the unit types because I do not know any rules to tranform an item from 1 unit type to another. I assumed that each item has only 1 possible unit type.</p>
            <p>For huge lists of recipes and fridge contents there are better ways to find the recipes that match.</p>
            <p>You can see the test results in the top menu</p>
        </div>
    </div>
</div>
