<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form">
    <div class="row">
        <div class="col-sm-4">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Pavadinimas') ?>

	    <?= $form->field($model, 'parent_id')->textInput()->dropDownList($categories_list, 
	            ['prompt' => Yii::t('app', 'Select category')]) ?>

        <?= $form->field($model, 'price')->textInput() ?>

	    <div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
