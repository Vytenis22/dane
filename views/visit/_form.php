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

<script type='text/javascript'>
    var model_date = <?php echo json_encode($model->start_time); ?>;
    var model_id = <?php echo json_encode($model->fk_user); ?>;
</script>

<div class="visit-form">

    <div class="row">
        <div class="col-md-10">

    <?= Html::label(Yii::t('app', 'Category'), 'cat', ['class' => 'label-asterix']); ?>
    <?= Html::dropDownList('cat', null, $service_category_list, ['prompt' => ['text' => Yii::t('app', 'Select category'),
                             'options'=> ['disabled' => true, 'selected' => true]], 'class'=>'form-control required', 'options' => ['required' => true], 
                                'onchange'=>'
                                    $.get( "'.Url::toRoute('copy/services', true).'", { id: $(this).val() } )
                                        .done(function( data ) {
                                            console.log("Done pasieke");
                                            $( "#'.Html::getInputId($modelService, 'fk_id_service').'" ).html( data );
                                        }
                                    );                          
                            ']) ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelService, 'fk_id_service', ['inputOptions' => ['class' => 'selectpicker ']]
            )->dropDownList([], ['prompt' => 'Pasirinkite paslaugą', 'class'=>'form-control required',
                'onchange'=>'
                                $.get( "'.Url::toRoute('/visit/price', true).'", { id: $(this).val() } )
                                    .done(function( data ) {
                                        /*console.log(data);*/
                                        /*$( "#visit-total_price" ).val(data);*/
                                        $( "#'.Html::getInputId($model, 'total_price').'" ).val( data );
                                    }
                                );    
                                var start_t = $(document.getElementById("visit-start_time")).val();
                                var id_service = $(document.getElementById("orderedservice-fk_id_service")).val();
                                $.get( "'.Url::toRoute('/visit/end-time', true).'", { 
                                    start_time: start_t,
                                    fk_id_service: id_service
                                     } )
                                    .done(function( data ) {
                                        /*console.log(data);*/
                                        /*$( "#visit-total_price" ).val(data);*/
                                        $( "#'.Html::getInputId($model, 'end').'" ).val( data );
                                    }
                                );                         
                            '
            ]);  ?>

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
                                'startDate' => date('Y-m-d', strtotime('+1 day')),
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

    <?= $form->field($model, 'total_price')->textInput()->input('info', ['placeholder' => 'Įrašykite sumą']); ?>

    <?= $form->field($model, 'payment')->dropDownList($visit_status, ['prompt' => ['text' => 'Pasirinkite būseną', 'options'=> ['disabled' => true, 'selected' => true]], 'class'=>'form-control required']); ?>

    <!-- <?= $form->field($model, 'fk_user')->textInput() ?> -->

    <?= $form->field($model, 'fk_patient')->dropDownList($patients_list, 
            ['prompt' => Yii::t('app', 'Select patient')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

        <?= \Yii::$app->user->can('createAssist') ? Html::button('Sukurti asistavimą', [ 'class' => 'btn btn-primary assist-btn', 
            'onclick' => '$.get( "' .Url::toRoute('/assists/doctor-assist', true). '", { date: model_date, id: model_id },(html) => {                
                 var response = JSON.parse(html);
                 $(".visit-form").html(response.content);
            })
            .done(function(data) {
                    $(function() {
                        console.log("done assist");
                    });
                })
                .fail(function(data) {
                    console.log("erroras");
                    });

            console.log("clickas");
            console.log(model_date);
            console.log(model_id);
            '
        ]) : "" ?>
    </div>

    <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
