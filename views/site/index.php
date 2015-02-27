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
        if($recipe!==false) {
            if (is_array($recipe)) {
    ?>
                <div class="alert alert-success">
                    You can cook a <?=$recipe['name'] ?>
                </div>
    <?php 
            } else {
    ?>
                <div class="alert alert-danger">
                    Order Takeout.
                </div>
    <?php 
            } 
        }
    ?>
<style>
/* REQUIRED FIELDS */
div.required label.control-label:after {
    content: " *";
    color: red;
}
</style>
    <div class="row">
	<?php $form = ActiveForm::begin([
	    'id' => 'recipe-form', 
	    'validateOnChange' => true,
	    'enableClientValidation' => false,
	    'enableAjaxValidation' => true,
	]); ?>
	    <?= $form->field($model, 'title')->dropDownList(['Mr.', 'Mrs.', 'Miss'], ['prompt' => '']) ?>
	    <?= $form->field($model, 'firstname') ?>
	    <?= $form->field($model, 'lastname') ?>
	    
	    <?= $form->field($model, 'url')->hint('Insert either the URL or the actual JSON response') ?>
	    <?= $form->field($model, 'text')->textArea(['rows' => 12]) ?>
	    <div class="form-group">
		<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'recipe-button']) ?>
	    </div>
	<?php ActiveForm::end(); ?>
    </div>
</div>
