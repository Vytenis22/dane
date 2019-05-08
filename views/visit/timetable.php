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

$this->title = Yii::t('app', 'Visits');
$this->params['breadcrumbs'][] = $this->title;

?>
<script type='text/javascript'>
	var js_array = <?php echo json_encode($assistants_id); ?>;
	//var js_array = Object.entries(js_obj);
	//die();
</script>
<div class="visit-timetable">
	
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
		
		\yii2fullcalendarscheduler\yii2fullcalendarscheduler::widget(array(
              'events' => $visits,
              'clientOptions' => [ 
        		'defaultView' => 'agendaDay',
              	'schedulerLicenseKey' => 'GPL-My-Project-Is-Open-Source',
       	 		'weekends' => false,
		        //'editable' => true,
				'selectable' => true,
				'selectHelper' => true,
				'slotDuration' => '00:15:00',
				'allDaySlot' => false,
				'minTime' => "08:00",
				'maxTime' => "18:00",
				'droppable' => true,
              	'views' => ['groupByResource' => true],         	
		        'resources' => [
		            ['id' => \Yii::$app->user->id < 6 ? $doctors[0]->id : Yii::$app->user->id,
		             'title' => \Yii::$app->user->id < 6 ? $doctors[0]->profile->name : $doctor_online->profile->name],
		            ['id' => $doctors[1]->id, 'title' => $doctors[1]->profile->name],
		            ['id' => $doctors[2]->id, 'title' => $doctors[2]->profile->name],
		            ['id' => $doctors[3]->id, 'title' => $doctors[3]->profile->name],
		            //['id' => $doctors[4]->id, 'title' => $doctors[4]->profile->name],
		            ['id' => $assistants[0]->id, 'title' => $assistants[0]->profile->name],
		        ],
		        //'eventRender' => "",

              /*'resourceRender' => "function resourceRenderCallback(resourceObj, labelTds, bodyTds){
								    labelTds.on('click', function(){console.log('click');});
								}",*/

			/*
			isbandyt click su event render (ar su eventafter render)
			resourceRender: function(resource, cellEls) {
			    cellEls.on('click', function(resource) {
			        $.getScript(resource.edit_url);
			    })
			}

			gal eis panaudot ant tvarkarascio su asistentu grupavimu
			{
			  start: "2017-01-01",
			  end: "2017-01-03",
			  //...other properties here...
			  customRender: true
			}
			eventRender: function(event, element, view) {
			  if (event.customRender == true)
			  {
			    var el = element.html();
			    element.html("<div style='width:90%;float:left;'>" +  el + "</div><div style='text-align:right;' class='close'><span class='glyphicon glyphicon-trash'></span></div>");
			    //...etc
			  }
			}
			*/
              ],

              /*'select' => 'function(date, jsEvent, view) {
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
				}',	*/
				'dayClick' => "function(date, jsEvent, view, resourceObj) {
					function findAssistant(id) {
              			return id == resourceObj.id;
              		}
					if ('". \Yii::$app->user->can('createAssist') . "') {
						console.log('user can create assist ');
						console.log('js_array - ', js_array);
						var found = js_array.find(findAssistant);
						console.log('found - ', found);
						if (js_array.find(findAssistant)) {
	              			console.log('asistento day click ', resourceObj.id);
	              			$.get( '" .Url::toRoute('/assists/assist', true). "', { date: date.format(), id: resourceObj.id }, function(data) {
					    		$('#modal').modal('show')
								.find('#modalContent')
								.html(data);
					    	} )
										.done(function( data ) {
											
										}
									);
	              		} else {
	              			console.log('gydytojo day click ', resourceObj.id);
	              			$.get( '" .Url::toRoute('/visit/create', true). "', { date: date.format(), id: resourceObj.id }, function(data) {
					    		$('#modal').modal('show')
								.find('#modalContent')
								.html(data);
					    	} )
										.done(function( data ) {
											$(function() {
										    	console.log('datos formatas', date.format());
										    });
										}
									);
	              		}
					} else if ('". \Yii::$app->user->can('createVisit') . "') {
						console.log('user can create visit');
						if (js_array.find(findAssistant)) {
	              			console.log('asistento day click ', resourceObj.id);
	              		} else {
	              			console.log('gydytojo day click ', resourceObj.id);
	              			$.get( '" .Url::toRoute('/visit/create', true). "', { date: date.format(), id: resourceObj.id }, function(data) {
					    		$('#modal').modal('show')
								.find('#modalContent')
								.html(data);
					    	} )
										.done(function( data ) {
											$(function() {
										    	console.log('datos formatas', date.format());
										    });
										}
									);
	              		}
					} else {
						console.log('user is assistant');
					}
				}",

				/*'dayClick' => \Yii::$app->user->can('createAssist') ? 'function(date, jsEvent, view, resourceObj) {
					console.log("user can create assist");
				}' : (\Yii::$app->user->can('createVisit') ? 'function(date, jsEvent, view, resourceObj) {
					console.log("user can create visit");
				}' : 'function(date, jsEvent, view, resourceObj) {
					console.log("else else");
				}'),*/
				// --------------------------------------------------------------------------------------------------
				// gerai veikiantis dayClick
          		/*"dayClick" => "function(date, jsEvent, view, resourceObj) {
              		function findAssistant(id) {
              			return id == resourceObj.id;
              		}
              		if (js_array.find(findAssistant)) {
              			console.log('asistento day click ', resourceObj.id);
              			$.get( '" .Url::toRoute('/visit/assist', true). "', { date: date.format() }, function(data) {
				    		$('#modal').modal('show')
							.find('#modalContent')
							.html(data);
				    	} )
									.done(function( data ) {
										
									}
								);
              		} else {
              			console.log('gydytojo day click ', resourceObj.id);
              			$.get( '" .Url::toRoute('/visit/create', true). "', { date: date.format() }, function(data) {
				    		$('#modal').modal('show')
							.find('#modalContent')
							.html(data);
				    	} )
									.done(function( data ) {
										$(function() {
									    	console.log('datos formatas', date.format());
									    });
									}
								);
              		}
				    
				}",*/
				// --------------------------------------------------------------------------------------------------

				/*'dayClick' => new \yii\web\JsExpression("
					function(date, jsEvent, view, resource) {
						console.log(
							'dayClick',
							date.format(),
							resource ? resource.id : '(no resource)'
						);
					}
				"),*/



				/*'dayClick' => 'function(calEvent, date, jsEvent, view) {
									$(function() {
										    	console.log("event click formatas", calEvent.id);
										    });
									$.get( "'.Url::toRoute('/visit/view', true).'", { id: calEvent.id } )
										.done(function( data ) {
											$(function() {
										    	console.log("event click formatas", calEvent.id);
										    });
										    $("#modal").modal("show")
											.find("#modalContent")
											.html(data);
										});									
								}',*/










              /*'options' => [
              	'views' => [
			        'agendaTwoDay' => [
			          'type' => 'agenda',
			          'duration' => [ 'days' => 2 ],

			          // views that are more than a day will NOT do this behavior by default
			          // so, we need to explicitly enable it
			          'groupByResource' => true

			          //// uncomment this line to group by day FIRST with resources underneath
			          //groupByDateAndResource: true
			        ]
			      ],
              ]*/

      
            ));
	
	?>
	
	
</div>
<?php