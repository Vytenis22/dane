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
	<script>

	  $(function() { // document ready

	    $('#calendar').fullCalendar({
	      defaultView: 'agendaDay',
	      allDaySlot: false,
	      defaultDate: '2018-04-07',
	      minTime: '08:00',
	      maxTime: '18:00',
	      slotDuration: '00:15:00',
	      editable: true,
	      selectable: true,
	      eventLimit: true, // allow "more" link when too many events
	      header: {
	        left: 'prev,next today',
	        center: 'title',
	        right: 'agendaDay,agendaTwoDay,agendaWeek,month'
	      },
	      views: {
	        agendaTwoDay: {
	          type: 'agenda',
	          duration: { days: 2 },

	          // views that are more than a day will NOT do this behavior by default
	          // so, we need to explicitly enable it
	          groupByResource: true

	          //// uncomment this line to group by day FIRST with resources underneath
	          //groupByDateAndResource: true
	        }
	      },

	      //// uncomment this line to hide the all-day slot
	      //allDaySlot: false,

	      resources: [
	        { id: 'a', title: 'Tomas Tomaitis' },
	        { id: 'b', title: 'Antanas Anaitis', eventColor: 'green' },
	        { id: 'c', title: 'Lina Linaitė', eventColor: 'orange' },
	        { id: 'd', title: 'Matas Mantaitis', eventColor: 'red' }
	      ],
	      events: [
	        //{ id: '1', resourceId: 'a', start: '2018-04-06', end: '2018-04-08', title: 'event 1' },
	        { id: '2', resourceId: 'a', start: '2018-04-07T09:00:00', end: '2018-04-07T14:00:00', title: 'event 2' },
	        { id: '3', resourceId: 'b', start: '2018-04-07T12:00:00', end: '2018-04-08T06:00:00', title: 'event 3' },
	        { id: '4', resourceId: 'c', start: '2018-04-07T07:30:00', end: '2018-04-07T09:30:00', title: 'event 4' },
	        { id: '5', resourceId: 'd', start: '2018-04-07T10:00:00', end: '2018-04-07T15:00:00', title: 'event 5' }
	      ],

	      select: function(start, end, jsEvent, view, resource) {
	        console.log(
	          'select',
	          start.format(),
	          end.format(),
	          resource ? resource.id : '(no resource)'
	        );
	      },
	      eventClick: function(date, jsEvent, view, resource) {
	        console.log(
	          'eventClick',
	          date.start.format(),
	          resource ? resource.id : '(no resource)'
	        );
	      }
	    });
	  
	  });

	</script>
	</head>
	<body>

		<div class="visit-calendar">

		  	<div id='calendar'></div>

		</div>

	    <h1><?= Html::encode($this->title) ?></h1>
		
		<?=
			
				\yii2fullcalendar\yii2fullcalendar::widget(array(
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
		              	'views' => ['agendaTwoDay' => [
		              					'type' => 'agenda',
		              					'duration' => ['days' => 2 ],
		              					'groupByResource' => true ]
		              	],

				        'resources' => [
				            ['id' => 'a', 'title' => 'Room A'],
				            ['id' => 'b', 'title' => 'Room B'],
				            ['id' => 'c', 'title' => 'Room C'],
				            ['id' => 'd', 'title' => 'Room D']
				        ],
					      'events' => [
					        ['id' => '2', 'resourceId' => 'a', 'start' => '2019-04-11 09:00:00', 'end' => '2019-04-11 14:00:00', 'title' => 'event 	2'],
					        ['id' => '3', 'resourceId' => 'b', 'start' => '2018-04-07T12:00:00', 'end' => '2018-04-08T06:00:00', 'title' => 'event 3'],
					        ['id' => '4', 'resourceId' => 'c', 'start' => '2018-04-07T07:30:00', 'end' => '2018-04-07T09:30:00', 'title' => 'event 4'],
					        ['id' => '5', 'resourceId' => 'd', 'start' => '2018-04-07T10:00:00', 'end' => '2018-04-07T15:00:00', 'title' => 'event 5']
					      ],
		              ],

		      
		            ));
			
			?>	


	</body>

