<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Vacations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vacations-form">
    <div class="row">
        <div class="col-sm-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'begin')->textInput(['maxlength' => true])
                            ->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Pasirinkite data ...',],                            
                                'removeButton' => false,
                                'language' => 'lt',                           
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    //'format' => 'yyyy-MM-dd',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,                             
                                    'startDate' => '+1',
                                    'daysOfWeekDisabled' => [0, 6], 
                                ],
                                 
                            ]) ?>

            <?= $form->field($model, 'end')->textInput(['maxlength' => true])
                            ->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Pasirinkite data ...',],                            
                                'removeButton' => false,
                                'language' => 'lt',                           
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    //'format' => 'yyyy-MM-dd',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,                             
                                    'startDate' => '+1',
                                    'daysOfWeekDisabled' => [0, 6], 
                                ],
                                 
                            ]) ?>

            <?= isset($model->id) ? $form->field($model, 'status')->dropDownList($status_list, 
            ['prompt' => ['text' => Yii::t('app', 'Select status'), 'options'=> ['disabled' => true, 'selected' => true]], 'class'=>'form-control required']
            ) : "" ?>

            <?= \Yii::$app->user->can('confirmVacations') ? $form->field($model, 'fk_user')->dropDownList($doctors_list, 
            ['prompt' => ['text' => Yii::t('app', 'Select doctor'), 'options'=> ['disabled' => true, 'selected' => true]], 'class'=>'form-control required']
            ) : "" ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    

</div>
