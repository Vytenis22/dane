<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\time\TimePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-form">

    <div class="row">
        <div class="col-sm-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'start_time')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pasirinkite datą ...'],                         
                            'removeButton' => false,
                            'language' => 'lt',
                            'pluginOptions' => [
                                'autoclose' => true,
                                'daysOfWeekDisabled' => [0, 6],
                                //'format' => 'yyyy-MM-dd',
                                'todayHighlight' => true,
                                'todayBtn' => true,
                                //'startDate' => "0d",
                                'startDate' => date('Y-m-d', strtotime('+0 day')),
                                'hoursDisabled' => '0,1,2,3,4,5,6,7,18,19,20,21,22,23'
                            ],
                             
                            ]); ?>

    <?= $form->field($model, 'end')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pasirinkite datą ...'],                         
                            'removeButton' => false,
                            'language' => 'lt',
                            'pluginOptions' => [
                                'autoclose' => true,
                                'daysOfWeekDisabled' => [0, 6],
                                //'format' => 'yyyy-MM-dd',
                                'todayHighlight' => true,
                                'todayBtn' => true,
                                //'startDate' => "0d",
                                'startDate' => date('Y-m-d', strtotime('+0 day')),
                                'hoursDisabled' => '0,1,2,3,4,5,6,7,18,19,20,21,22,23'
                            ],
                             
                            ]); ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true])->input('info', ['placeholder' => 'Įrašykite papildomą informaciją']); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_assist], [
            'class' => 'btn btn-danger assignments',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
