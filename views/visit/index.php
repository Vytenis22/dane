<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<head>

	<link href='../../vendor/bower-asset/fullcalendar/dist/fullcalendar.css' rel='stylesheet' />
	<link href='../../vendor/bower-asset/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print' />
	<link href='../../vendor/bower-asset/fullcalendar-scheduler/dist/scheduler.css' rel='stylesheet' />
	<script src='../../vendor/bower-asset/moment/moment.js'></script>
	<script src='../../vendor/bower-asset/jquery/dist/jquery.js'></script>
	<script src='../../vendor/bower-asset/fullcalendar/dist/fullcalendar.js'></script>
	<script src='../../vendor/bower-asset/fullcalendar-scheduler/dist/scheduler.js'></script>
</head>
<?php

$this->title = Yii::t('app', 'Visits');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="visit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    	<?= Html::button(yii::t('app', 'Create Visit'), ['value' => Url::to(['visit/create-tmp']), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>
	
	<?php
	
		Modal::begin([
            //'header'=>'<h4>Visit</h4>',
            //'toggleButton' => ['label' => 'click me', 'class' => 'btn btn-primary'],
            'size' => '',
            'id'=>'modal', 

        ]);
        
        echo "<div id='modalContent'></div>";
        Modal::end();
		
	?>

	<?=
		
		\yii2fullcalendar\yii2fullcalendar::widget(array(
              'events' => $visits,
              'clientOptions' => [ 
       	 		'weekends' => false,
		        'editable' => true,
				'selectable' => true,
				'selectHelper' => true,
				'slotDuration' => '00:15:00',
				'allDaySlot' => false,
				'minTime' => "08:00",
				'maxTime' => "18:00",
				'droppable' => true,
              	//'views' => ['groupByResource' => true], 
              	/*'eventRender' => "function(info) {
			      var tooltip = new Tooltip(info.el, {
			        title: info.event.extendedProps.description,
			        placement: 'top',
			        trigger: 'hover',
			        container: 'body'
			      });
			    }",*/
			    // 'eventRender' => "function(event, element) {
			    //     $(element).tooltip({title: event.tooltip,
			    //               container: 'body',
			    //               delay: { 'show': 500, 'hide': 300 }
			    //     });
			    //   }",

		        /*'resources' => [
		            ['id' => 'a', 'title' => 'Room A'],
		            ['id' => 'b', 'title' => 'Room B'],
		            ['id' => 'c', 'title' => 'Room C'],
		            ['id' => 'd', 'title' => 'Room D']
		        ],*/
              	'views' => ['groupByResource' => true],         	
		        'resources' => [
		            ['id' => \Yii::$app->user->id < 6 ? $doctors[0]->id : Yii::$app->user->id,
		             'title' => \Yii::$app->user->id < 6 ? $doctors[0]->profile->name : $doctor_online->profile->name],
		            ['id' => $doctors[1]->id, 'title' => $doctors[1]->profile->name],
		            ['id' => $doctors[2]->id, 'title' => $doctors[2]->profile->name],
		            ['id' => $doctors[3]->id, 'title' => $doctors[3]->profile->name],
		            ['id' => $doctors[4]->id, 'title' => $doctors[4]->profile->name],
		        ],
              ],
              /*'select' => "function(date, jsEvent, view) {
				    $('#modal').modal('show');
				    $(function() {
				    	console.log('date formatas', date.format());
				    });
				}",*/ 
				'select' => 'function(date, jsEvent, view) {
				    $.get( "'.Url::toRoute('/visit/create', true).'", { date: date.format() }, function(data) {
				    		$("#modal").modal("show")
							.find("#modalContent")
							.html(data);
				    	} )
									.done(function( data ) {
										$(function() {
									    	console.log("datos formatas", date.format());
									    });
									}
								);
				}',
				'eventClick' => 'function(calEvent, date, jsEvent, view) {
									$.get( "'.Url::toRoute('/visit/view', true).'", { id: calEvent.id } )
										.done(function( data ) {
											$(function() {
										    	console.log("event click formatas", calEvent.id, calEvent.resourceId);
										    });
										    $("#modal").modal("show")
											.find("#modalContent")
											.html(data);
										});									
								}',
				/*'eventClick' => 'function(date, calEvent, view) {
				    $.get( "'.Url::toRoute('/visit/view', true).'", { id: calEvent.id }, function(data) {
				    		$("#modal").modal("show")
							.find("#modalContent")
							.html(data);
				    	} )
									.done(function( data ) {
										$(function() {
									    	console.log("update formatas", date.format());
									    });
									}
								);
				}',*/

				//from site reservation
				/*$.get( "'.Url::toRoute('/site/doctors', true).'", { id: $(this).val() } )
									.done(function( data ) {
										$( "#'.Html::getInputId($model, 'fk_user').'" ).html( data );
									}
								); */

				// DoingITEasy
					/*$.get('index.php/r=visit/create', { 'date': date}, function(data) {
				$('#modal').modal('show')
				.find('#modalContent')
				.html(data);			
				});*/	


        ));
	
	?>
	
	
</div>