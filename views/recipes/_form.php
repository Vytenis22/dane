<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dektrium\user\models\User;
use app\models\Recipes;
use app\models\Patient;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Recipes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipes-form">
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'expire')->textInput()
                ->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Pasirinkite data ...',],                            
                                    'removeButton' => false,
                                    'language' => 'lt',                         
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'daysOfWeekDisabled' => [0, 6],
                                        //'format' => 'yyyy-MM-dd',
                                        'todayHighlight' => true,
                                        'todayBtn' => true,
                                        'startDate' => date('Y-m-d', strtotime('+1 day')),
                                    ],
                                     
                                ]) ?>

            <?= $form->field($model, 'rp')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'N')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'S')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
