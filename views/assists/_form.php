<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Assists */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assists-form">
    <div class="row">
        <div class="col-sm-4">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'start_time')->textInput() ?>

        <?= $form->field($model, 'end')->textInput() ?>

        <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
            
        </div>
    </div>

</div>
