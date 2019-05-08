<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentTime */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="treatment-time-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'id_treatment_time')->textInput() ?>

    <?= $form->field($model, 'fk_id_service')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
