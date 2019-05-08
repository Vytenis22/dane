<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dektrium\user\models\User;
use app\models\TreatmentPlans;
use app\models\Patient;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentPlans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="treatment-plans-form">
    <div class="row">
        <div class="col-lg-5">
	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'begin')->textInput()
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
                                ],
                                 
                            ]) ?>

	    <?= $form->field($model, 'end')->textInput()
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
                                ],
                                 
                            ]) ?>

	    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

	    <!-- $form->field($model, 'fk_patient')->dropDownList($patients_list, 
            ['prompt' => Yii::t('app', 'Select patient')]) -->

	    <div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>
		</div>
	</div>

</div>
