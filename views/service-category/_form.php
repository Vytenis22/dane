<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-category-form">
    <div class="row">
        <div class="col-sm-4">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'parent_name')->textInput(['maxlength' => true])->input('name', ['placeholder' => 'Įveskite pavadinimą']); ?>

	    <div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
