<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
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
	    
            <?= $form->field($model, 'mobile') ?>
	    <?= $form->field($model, 'phone')->hint('Insert either the mobile or the phone number') ?>
	    
            <?= $form->field($model, 'preferred')->radioList(['mobile', 'phone']) ?>
        
            <h2>Delivery Address</h2>
            <?= $form->field($model, 'unit') ?>
            <?= $form->field($model, 'number') ?>
            <?= $form->field($model, 'street_type')->dropDownList(['Str', 'Alea', 'something else'], ['prompt' => '']) ?>
            <?= $form->field($model, 'street') ?>
            <?= $form->field($model, 'suburb') ?>
            <?= $form->field($model, 'state')->dropDownList(['NSW', 'QLD', 'ACT'], ['prompt' => '']) ?>
            <?= $form->field($model, 'country') ?>
            
            <h2>Billing Address</h2>
            <?= $form->field($model, 'r_unit') ?>
            <?= $form->field($model, 'r_number') ?>
            <?= $form->field($model, 'r_street_type')->dropDownList(['Str', 'Alea', 'something else'], ['prompt' => '']) ?>
            <?= $form->field($model, 'r_street') ?>
            <?= $form->field($model, 'r_suburb') ?>
            <?= $form->field($model, 'r_state')->dropDownList(['NSW', 'QLD', 'ACT'], ['prompt' => '']) ?>
            <?= $form->field($model, 'r_country') ?>
                
            <h2>Stuff on pizza</h2>
            <?= $form->field($model, 'crust')->inline(true)->radioList(['Thick', 'Thin', 'Medium'], ['prompt' => '']) ?>
            
            <?= $form->field($model, 'extra_cheese')->checkbox([], true) ?>
            <?= $form->field($model, 'extra_mushrooms')->checkbox([], true) ?>
            <?= $form->field($model, 'extra_sauce')->checkbox([], true) ?>
            <?= $form->field($model, 'extra_everything')->checkbox([], true) ?>
	    <div class="form-group">
		<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'recipe-button']) ?>
	    </div>
	<?php ActiveForm::end(); ?>
    </div>
</div>
