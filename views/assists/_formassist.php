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
//$this->title = Yii::t('app', 'Create Assist');
?>

<div class="assist-form">

    <script type='text/javascript'>
        var model_date = <?php echo json_encode($model->start_time); ?>;
        var model_id = <?php echo json_encode($model->fk_user); ?>;
    </script>

    <div class="row">
        <div class="col-sm-6">

            <p style="display: inline-block;">
                <?= $this->title == Yii::t('app', 'Create Assist') || $this->title == Yii::t('app', 'Update Assists: {name}') ? "" : Html::button(Yii::t('app', 'Return'), [ 'class' => 'btn btn-primary', 
                    'onclick' => '$.get( "' .Url::toRoute('/visit/create-partial', true). '", { date: model_date, id: model_id },(html) => {           
                         var response = JSON.parse(html);
                         $(".assist-form").html(response.content);
                    })
                    .done(function(data) {
                            $(function() {
                                console.log("done assist");
                            });
                        })
                        .fail(function(data) {
                            console.log("erroras");
                            });
                    '
                ]) ?>
            </p>

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
                <?= isset($model->reg_nr) ? Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_assist], [
                    'class' => 'btn btn-danger assignments',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) : "" ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<?php
