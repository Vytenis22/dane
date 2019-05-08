<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-form">

    <div class="row">
        <div class="col-md-10">

    <?= Html::label(Yii::t('app', 'Category'), 'cat', ['class' => 'label-asterix']); ?>
    <?= Html::dropDownList('cat', null, $service_category_list, ['prompt' => ['text' => Yii::t('app', 'Select category'),
                             'options'=> ['disabled' => true]], 'class'=>'form-control required', 'options' => ['required' => true], 
                                'onchange'=>'
                                    $.get( "'.Url::toRoute('copy/services', true).'", { id: $(this).val() } )
                                        .done(function( data ) {
                                            console.log("Done pasieke");
                                            $( "#'.Html::getInputId($modelService, 'fk_id_service').'" ).html( data );
                                        }
                                    );                             
                            ']) ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelService, 'fk_id_service')->textInput()->dropDownList($services_list, ['prompt' => 'Pasirinkite paslaugą']);  ?>

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

    <!-- <?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'info')->textInput(['maxlength' => true])->input('info', ['placeholder' => 'Įrašykite papildomą informaciją']); ?>

    <?= $form->field($model, 'total_price')->textInput()->input('total_price', ['placeholder' => '0.00 €']); ?>

    <?= $form->field($model, 'payment')->dropDownList($visit_status, ['prompt' => ['text' => 'Pasirinkite būseną', 'options'=> ['disabled' => true, 'selected' => true]], 'class'=>'form-control required']); ?>

    <!-- <?= $form->field($model, 'fk_user')->textInput() ?> -->

    <?= $form->field($model, 'fk_patient')->dropDownList($patients_list, 
            ['prompt' => Yii::t('app', 'Select patient')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_visit], [
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
