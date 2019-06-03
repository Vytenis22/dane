<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Vacations */
/* @var $form yii\widgets\ActiveForm */
?>
<script type='text/javascript'>
    var dates = <?php echo json_encode($unavailable_days); ?>;
    //var js_array = Object.entries(js_obj);
    //die();
</script>
<script type='text/javascript'>

    var c_date = new Date();
    var date_f = c_date.getFullYear();
    date_f+= "-";
    var month = c_date.getMonth() +1;
    if(month < 10) {
        date_f+= "0" + month; 
    } else {
        date_f+= month;
    }
    date_f+= "-";
    var day = c_date.getDate();
    if(day < 10) {
        date_f+= "0" + day; 
    } else {
        date_f+= day;
    }
    //var js_array = Object.entries(js_obj);
    //die();
</script>

<div class="vacations-form">
    <div class="row">
        <div class="col-sm-4">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'begin')->widget(\yii\jui\DatePicker::class, [
                                'language' => 'lt',
                                'options' => ['placeholder' => 'Pasirinkite datą ...', ],
                                'clientOptions' => [
                                    'minDate' => '1',
                                    'onSelect'=> new \yii\web\JsExpression('function(dateStr) {
                                            console.log(dateStr);
                                          var newDate = $(this).datepicker("getDate");  
                                          console.log(newDate); 
                                          if (newDate) {
                                                  newDate.setDate(newDate.getDate() + 1);
                                          }
                                          $("#vacations-end").datepicker( "option", "minDate", newDate );
                                     }'),
                                    'beforeShowDay' => new \yii\web\JsExpression('function(date) { 
                                        var year = date.getFullYear();
                                        holidays = [year + "-01-01", year + "-02-16", year + "-03-11", year + "-05-01", year + "-06-24", year + "-07-06", year + "-08-15", year + "-11-01", year + "-12-25", year + "-12-26", "2020-04-13", "2021-04-05", "2022-04-18"];

                                        var dmy = date.getFullYear();
                                        dmy+= "-";
                                        var month = date.getMonth() +1;
                                        if(month < 10) {
                                            dmy+= "0" + month; 
                                        } else {
                                            dmy+= month;
                                        }
                                        dmy+= "-";
                                        var day = date.getDate();
                                        if(day < 10) {
                                            dmy+= "0" + day; 
                                        } else {
                                            dmy+= day;
                                        }

                                        if ($.inArray(dmy, holidays) > -1 && date.getUTCDay() < 5 && dmy > date_f  ||
                                         $.inArray(dmy, dates) > -1 && date.getUTCDay() < 5) {
                                            return [false, "highlight-day", ""]
                                        } else if (date.getUTCDay() > 4) {
                                            return [false, "", ""]
                                        } else {
                                            return [true, "", ""]
                                        }                

                                     }'),
                                ],
                                
                                //'dateFormat' => 'yyyy-MM-dd',
                            ]) ?>

            <?= $form->field($model, 'end')->widget(\yii\jui\DatePicker::class, [
                                'language' => 'lt',
                                'options' => ['placeholder' => 'Pasirinkite datą ...', ],
                                'clientOptions' => [
                                    'minDate' => '1',
                                    'beforeShowDay' => new \yii\web\JsExpression('function(date) { 
                                        var year = date.getFullYear();
                                        holidays = [year + "-01-01", year + "-02-16", year + "-03-11", year + "-05-01", year + "-06-24", year + "-07-06", year + "-08-15", year + "-11-01", year + "-12-25", year + "-12-26", "2020-04-13", "2021-04-05", "2022-04-18"];

                                        var dmy = date.getFullYear();
                                        dmy+= "-";
                                        var month = date.getMonth() +1;
                                        if(month < 10) {
                                            dmy+= "0" + month; 
                                        } else {
                                            dmy+= month;
                                        }
                                        dmy+= "-";
                                        var day = date.getDate();
                                        if(day < 10) {
                                            dmy+= "0" + day; 
                                        } else {
                                            dmy+= day;
                                        }

                                        if ($.inArray(dmy, holidays) > -1 && date.getUTCDay() < 5 && dmy > date_f  ||
                                         $.inArray(dmy, dates) > -1 && date.getUTCDay() < 5) {
                                            return [false, "highlight-day", ""]
                                        } else if (date.getUTCDay() > 4) {
                                            return [false, "", ""]
                                        } else {
                                            return [true, "", ""]
                                        }                

                                     }'),
                                ],
                                
                                //'dateFormat' => 'yyyy-MM-dd',
                            ]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    

</div>
