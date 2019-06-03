<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-form">


    <div class="row">
        <div class="col-lg-5">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'birth_date')->textInput(['maxlength' => true])
                            ->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Pasirinkite data ...',],                            
                                'removeButton' => false,
                                'language' => 'lt',                         
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    //'format' => 'yyyy-MM-dd',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                ],
                                 
                            ]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'minlength' => true]) ?>

        <?= $form->field($model, 'sex')->textInput(['maxlength' => true])->dropDownList(['moteris' => 'moteris', 'vyras' => 'vyras'], ['prompt' => ['text' => Yii::t('app', 'Select sex'), 'options'=> ['disabled' => true, 'selected' => true]], 'class'=>'form-control required']) ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'minlength' => true, 
                        'placeholder' => 'Įveskite telefono numerį (86...)']) ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'city', ['labelOptions' => [ 'class' => 'label-asterix' ]])
        ->dropDownList($cities_list, ['prompt' => ['text' => Yii::t('app', 'Select city'), 'options'=> 
        ['disabled' => true, 'selected' => true]]]); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        
        </div>
    </div>

</div>
