<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\field\FieldRange;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<script type='text/javascript'>
    var dates;

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
<div class="site-index">

	
	<!--//Html::img('@web/images/odontologijos-klinika-547e.jpg', ['alt'=>'Odontologijos klinika']);
	
	<img src="/images/odontologijos-klinika-547e.jpg" alt="Odontologijos klinika"> -->
	
	<!-- <p>
		 Html::a('Registruotis', ['site/reservation'], ['class' => 'btn btn-primary']) 
	</p> -->
	

    <div class="jumbotron">
		<div id="smile">
        <h1>Graži šypsena!</h1>
		</div>
		
		<!-- <p>
			 <a class="btn btn-lg btn-danger" href="site/request">Atšaukti registraciją</a>
             Html::a('Atšaukti registraciją', ['site/request'], ['class' => 'btn btn-danger']) 
		</p>  -->
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4" style="float: right; display: inline-block;">                
                <?php
                    echo '<label class="control-label">Pasirinkite laikotarpį</label>';
                    echo DatePicker::widget([
                        'name' => 'from_date',
                        'value' => '',
                        'type' => DatePicker::TYPE_RANGE,
                        'name2' => 'to_date',
                        'value2' => '',
                        'separator' => 'ir',
                        'language' => 'lt', 
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>
                <?=

                Html::submitButton('Pateikti', ['class' => 'btn btn-primary pateikti'])

                ?>

                <!-- <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p> -->
            </div>
            <div> 

            <?=

            Html::Button('Date', ['class' => 'btn btn-primary pateikti', 'onclick' => '(function () { alert("Button 3 clicked"); 
                console.log($("#w1-container").datepicker("refresh")); })();'])

            ?> 

            <?php echo \yii\jui\DatePicker::widget([

                'inline'=>true,

                'clientOptions' => [
                    'minDate'=>'1',
                    //'onSelect' => new \yii\web\JsExpression('function(dateText, inst) { console.log(dateText, inst) }'),
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

                        if ($.inArray(dmy, holidays) > -1 && date.getUTCDay() < 5 && dmy > date_f) {
                            return [false, "highlight-day", ""]
                        } else if (date.getUTCDay() > 4) {
                            return [false, "", ""]
                        } else {
                            return [true, "", ""]
                        }                

                     }'),

                ],

            ]);?>

 
                            
                <!-- <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p> -->
            </div>
            <div class="col-lg-4">
                <!-- <h2>Heading</h2>

                <p>Heading1</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p> -->
            </div>
        </div>

    </div>
</div>
