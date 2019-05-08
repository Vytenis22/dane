<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelService, 'fk_id_service', ['inputOptions' => ['class' => 'selectpicker ']]
            )->dropDownList($hierarchy, ['prompt' => 'Pasirinkite paslaugą', 'class'=>'form-control required']); ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true])->input('info', ['placeholder' => 'Įrašykite papildomą informaciją']); ?>

    <?= $form->field($model, 'total_price')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList($status_array, ['prompt' => 'Pasirinkite būseną', 'class'=>'form-control required']); ?>

    <?= $form->field($model, 'fk_user')->textInput() ?>

    <?= $form->field($model, 'fk_patient')->dropDownList($patients_list, 
            ['prompt' => Yii::t('app', 'Select patient')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
