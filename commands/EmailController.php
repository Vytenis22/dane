<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Vacations;
use app\models\Visit;
use app\models\Assists;
use app\models\Cities;
use app\models\AuthAssignment;
use app\models\TokenPatient;
use app\models\Patient;
use app\models\ServiceDuration;
use app\models\ServiceCategory;
use app\models\Services;
use app\models\OrderedServices;
use app\models\ReservationsExpirations;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use DateTime;
use DatePeriod;
use DateInterval;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EmailController extends Controller
{
	public function actionMapDates($doc_id, $service_id) {
		$unavailable_days = array();
		$today = date('Y-m-d');
		//	, 'date_format(start_time", "%Y-%m-%d") as start_format'
		$command = (new \yii\db\Query())
			->select(['start_time', 'end', 'date_format(start_time, "%Y-%m-%d") as start_format'])
			->from('visit')
			->where(['and', 'fk_user=:doc_id', 'start_time>:today'])
			->addParams([':doc_id' => $doc_id, ':today' => $today])
			->orderBy(['start_time' => SORT_ASC])
			->all();
		$visits = Visit::find()->where(['fk_user' => $doc_id])->andWhere(['>', 'start_time', $today])->all();
		if (!empty($command)){
			$visits_map = ArrayHelper::map($command, 'start_time', 'end', 'start_format');
			echo "Visits array map count - " . count($visits_map) . ".\n";
		}
		$a = "a";
		$i = 1;
		foreach ($visits_map as $key => $value) {
			$time_slots = Visit::getDoctorTimes($key, $doc_id, $service_id);
			if (empty($time_slots)) {
				$unavailable_days[$a . $i] = $key;
				$i++;
			}
		}
		var_dump($unavailable_days);
		die();

		echo "Unavailable days count - " . count($unavailable_days) . "\n";
		$i = 1;
		foreach ($unavailable_days as $value) {
			echo $i . ") Unavailable day - " . $value . "\n";
			$i++;
		}

		return ExitCode::OK;
	}

	public function actionTesting()
	{
		/*$visit = Visit::find()->where(['id_visit' => 13])->one();
		$patient_full_name = $visit->patient->name . " " . $visit->patient->surname;
		$service_name = $visit->services;
		$user_name = $visit->user->profile->name;
		$duration = strtotime($visit->services[0]->duration->duration);
		$duration_format = date('H:i', $duration);
		echo $patient_full_name . "\n";
		echo $service_name[0]->name . "\n";
		echo $user_name . "\n";
		echo $duration_format . "\n";*/
		$date = '2019-04-15T14:00:00';
		$date_format = date('Y-m-d H:i:s', strtotime($date));
		//echo $date . "\n";
		//echo $date_format . "\n";

		$doc = User::find()->where(['id' => 8])->one();
		$doc_name = $doc->profile->name;
		$pieces = explode(" ", $doc_name);
		$piece_end = substr($pieces[0], -1);
		//echo "piece end " . $piece_end . "\n";
		//echo strcmp(strtolower($piece_end), "s") ? 'Asistentė ' . $pieces[0] : 'Asistentas ' . $pieces[0];
		//echo "\n";

		$patient = Patient::find()->where(['id_Patient' => 10])->one();
		if (!empty($patient)) {
			//echo $patient->cityName;
		}
		//echo "\n";

		$time_array = ["12:00", "15:30", "17:10"];

		$check_free_time = date("H:i", strtotime("2019-05-28 17:00"));
		//echo $check_free_time . "\n";

		//echo in_array($check_free_time, $time_array) . "\n";

		$user_id = 11;
		$date = "2019-05-28";
		$tomorrow = date('Y-m-d', strtotime($date. ' + 1 days'));
		$visits = Visit::find()
	        ->where(['fk_user' => $user_id])
	        //->andWhere(['>', 'start_time', $date])
	        //->andWhere(['<', 'start_time', $tomorrow])
	        ->orderBy(['start_time' => SORT_ASC])
	        ->all();
	    $assists = Assists::find()
	        ->where(['fk_user' => $user_id])
	        //->andWhere(['>', 'start_time', $date])
	        //->andWhere(['<', 'start_time', $tomorrow])
	        ->orderBy(['start_time' => SORT_ASC])
	        ->all();
	    //echo count($visits) . " - " . count($assists) . "\n";

	    $total_visits = array_merge($visits,$assists);
	    //echo count($total_visits) . "\n";
	    foreach ($total_visits as $visit) {
	    	//echo $visit->start_time . "\n";
	    }
	    sort($total_visits);
	    //echo "array sorted asc\n";
	    foreach ($total_visits as $visit) {
	    	//echo $visit->start_time . "\n";
	    }
	    ArrayHelper::multisort($total_visits, ['start_time'], [SORT_ASC]);
	    //echo "array helper sorted asc\n";
	    foreach ($total_visits as $visit) {
	    	//echo $visit->start_time . "\n";
	    }

	    $user_id = 7;
	    $categories = ServiceCategory::find()
            ->leftJoin('service_assignment', 'service_assignment.category_id = service_category.id')
            ->where(['=', 'service_assignment.user_id', $user_id])
            ->orderBy(['service_category.id' => SORT_ASC])
            ->all();
        //echo count($categories) . "\n";
        foreach ($categories as $category) {
        	//echo $category->parent_name . "\n";
        }

        $patient = Patient::find()->where(['fk_user' => 6])->one();
    	if (empty($patient)) {
    		echo "patient is empty" . "\n";
    	}

	    $user_id = 11;
    	$vacations = Vacations::find()
            ->where(['fk_user' => $user_id])
            ->andWhere(['status' => Vacations::CONFIRMED])
            ->all();
        echo count($vacations) . " - count\n";

		$interval = new DateInterval('P1D');
		if (!empty($vacations))
		{
			$period_start = new Datetime($vacations[0]->begin);
	        //echo $period_start->format('Y-m-d') . " - period start\n";
			$vacations_end = new Datetime($vacations[0]->end);
	        //echo $vacations_end->format('Y-m-d') . " - vacations end\n";
	        $period_end = $vacations_end->add($interval);        
	        //echo $period_end->format('Y-m-d') . " - period end\n";
			$daterange = new DatePeriod($period_start, $interval , $period_end);
			/*foreach ($daterange as $date) {
				echo $date->format('Y-m-d') . "\n";
			}*/
		}
		

		$doc_vacations = Vacations::getDoctorVacations($user_id);
		if (!empty($doc_vacations))
		{
			foreach ($doc_vacations as $vacation) {
				echo $vacation . "\n";
			}
		}

		echo $today = date('Y-m-d H:i') . " - today\n";

		$visits_list = Visit::find()
            ->select(["DATE_FORMAT(start_time, '%Y-%m-%d') as begin"])
            ->where(['fk_user' => $user_id])
            ->groupBy('begin')
            ->all();
        $today = date('Y-m-d');
        $command = (new \yii\db\Query())
			->select(['date_format(start_time, "%Y-%m-%d") as begin'])
			->from('visit')
			->where(['and', 'fk_user=:doc_id', 'start_time>:today'])
			->addParams([':doc_id' => $user_id, ':today' => $today])
			->orderBy(['start_time' => SORT_ASC])
			->groupBy(['begin'])
			->all();
		//var_dump($command[0]);
		//die();
        foreach ($command as $visit) {
        	echo $visit["begin"] . " - begin visit date\n";
        }

	    $user_id = 13;

        $confirmed_vacations = Vacations::find()->where(['fk_user' => $user_id])
            ->andWhere(['=', 'status', Vacations::CONFIRMED])
            ->andWhere(['>', 'begin', $today])
            ->all();
        echo count($confirmed_vacations) . "\n";
        echo $confirmed_vacations[0]->begin . " - " . $confirmed_vacations[0]->end;
		

		return ExitCode::OK;
	}

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
		//echo \Yii::$app->getUrlManager()->createUrl(['site/cancel', 'id' => 2, 'code' => 1233]) . "\n";
		//echo Yii::$app->getUrlManager()->getBaseUrl() . "\n";
		echo Url::to(['site/cancel', 'id' => 2, 'code' => 1233], true) . "\n";
		//echo Url::to(['/site/cancel', 'id' => 2, 'code' => 1233]) . "\n";
		echo Url::to('web/images/logo-danes.png') . "\n";
		echo Yii::$app->security->generateRandomString(8) . "\n";
		
		$dateNow = date('Y-m-d');
        echo $message . date('Y-m-d', strtotime($dateNow. ' + 1 days')) . "\n";
		$visit = Visit::find()->where(['id_visit' => 2])->one();
		
		date_default_timezone_set('Europe/Vilnius');
		$timeSet = $visit->start_time;
		$timeNow = date('Y-m-d H:i:s');
		$timeSetFormat = date("Y-m-d", strtotime($timeSet));
		
		echo $timeSetFormat . " timeset\n";
		echo $timeNow . " timenow\n";
		
		if ($timeNow < $timeSetFormat){
		//if ($timeNow < date("Y-m-d", strtotime($timeSet))){
			echo "true\n";
			echo $timeNow . " < " . $timeSetFormat;
		} else {
			echo "false\n";
			echo $timeNow . " >= " . $timeSetFormat;
		}

        return ExitCode::OK;
    }
	
	/**
     * This command sends email reminders to patients about awaiting appointments tomorrow.
     * @return int Exit code
     */
	public function actionEmailPatients()
    {
		$dateNow = date('Y-m-d');
		$tomorrow = date('Y-m-d', strtotime($dateNow. ' + 1 days'));
		$nextTomorrow = date('Y-m-d', strtotime($dateNow. ' + 2 days'));
		//$visits = Visit::getPatientsList();
		$visits = Visit::find()->where(['>', 'start_time', $tomorrow])->andWhere(['<', 'start_time', $nextTomorrow])->all();
		
		if ($visits == Null) {
			$error = 'null';
			echo $error . "\n";
		} else {
			$messages = array();
			/**
			$mailer = Yii::$app->mailer;
			$mailer->useFileTransport = false;
			$mailer->transport = ['class' => 'Swift_SmtpTransport', 
				'host' => 'smtp.gmail.com', 
				'username' => 'dionizas123@gmail.com', 
				'password' => 'kakalasa5', 
				'port' => '587', 
				'encryption' => 'tls',
				];
			*/
			
			$routeRequest = Url::to(['site/request'], true);
				
			foreach ($visits as $visit) {			
				
				$patient = $visit->patient;			
				
				//die("mire. Email controller line 69. Nesukuria tokeno\n");
				/**
				$token = \Yii::createObject([
					'class' => TokenPatient::className(),
					'patient_id' => $patient->id_Patient,
					'type' => TokenPatient::TYPE_CANCEL,					
				])				
				if (!$token->save(false)) {
					echo "token save is false. Email controller 114";
					return false;
				}
				*/
				
				$messages[] = Yii::$app->mailer->compose('patient', ['patient' => $patient = $visit->patient, 'visit' => $visit, 'routeRequest' => $routeRequest])
					->setFrom([Yii::$app->params['adminEmail']])
					->setTo($patient->user->email)
					->setSubject("Welcome subject");
					//->send();
				echo "Email sent from " . Yii::$app->params['adminEmail'] . " to " . $patient->user->email . "\n";
			}
			Yii::$app->mailer->sendMultiple($messages);			
		}

        return ExitCode::OK;
    }
	
	/**
     * This command sends email reminders to doctors about awaiting appointments tomorrow.
     * @return int Exit code
     */
	public function actionEmailDoctors() {
		$dateNow = date('Y-m-d');
		$tomorrow = date('Y-m-d', strtotime($dateNow. ' + 1 days'));
		$nextTomorrow = date('Y-m-d', strtotime($dateNow. ' + 2 days'));
		$visits = Visit::find()->where(['>', 'start_time', $tomorrow])->andWhere(['<', 'start_time', $nextTomorrow])->all();
				
		if ($visits == Null) {
			$error = 'visits array is null';
			echo $error . "\n";
			return ExitCode::OK;
		}
		
		$doctors = User::find()
			->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
			->where(['=', 'auth_assignment.item_name', 'doctor'])
			->all();
		if ($doctors == Null) {
			$error = 'doctors array is null';
			echo $error . "\n";
			return ExitCode::OK;
		}
			
		$filteredVisits = array();
		$messages = array();
		$count = 0;
		foreach ($doctors as $doctor) {
			foreach ($visits as $visit) {
				if ($doctor->id === $visit->fk_user) {
					$filteredVisits[] = $visit;
					$count++;
				}
			}
			if (!empty($filteredVisits)) {
				$messages[] = Yii::$app->mailer->compose('doctor', ['profile' => $profile = $doctor->profile, 'visits' => $filteredVisits, 'count' => $count])
					->setFrom([Yii::$app->params['adminEmail']])
					->setTo($doctor->email)
					->setSubject("Tomorrow appointments");
				echo "Email sent from " . Yii::$app->params['adminEmail'] . " to " . $doctor->email . "\n";
				$count = 0;
				$filteredVisits = array();
			}
		}
		Yii::$app->mailer->sendMultiple($messages);
		
        return ExitCode::OK;
	}

	/**
	* test function for selecting available doctor time
	* prints incorrect time slots. DateInterval class isnt proper choice
	*/
	public function actionSql()
	{
		$model = Visit::find()->where(['id_visit' => 31])->one();
		$connection = Yii::$app->getDb();

		/*$query = $connection->createCommand("CREATE EVENT IF NOT EXISTS `name" . $id . "`
           ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL  10 SECOND
           DO
           UPDATE `event` SET `name`='aha' WHERE `id` = 1 ");
		$query = $connection->createCommand("CREATE EVENT IF NOT EXISTS `name" . $id . "`
           ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL  10 SECOND
           DO
           UPDATE `event` SET `name`='aha' WHERE `id` = 1 ");
		$query->execute();*/

		$query = $connection->createCommand("CREATE EVENT IF NOT EXISTS `name" . $model->id_visit . "`
				           ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL  1 MINUTE
				           DO
				           DELETE FROM `visit` WHERE `status` = 0 AND `id_visit` = " . $model->id_visit . " ");
		$query->execute();

		return ExitCode::OK;
	}

	/**
	* another try
	*/
	public function actionDocTime($date, $user_id, $service_id)
	{
		$break_start = new DateTime($date);
		$break_start_hour = '12:00';
		$break_start->modify($break_start_hour);
		$break_end = new DateTime($date);
		$break_end_hour = '13:00';
		$break_end->modify($break_end_hour);		
		// ------------------------------------------------------------------------
		// find selected service duration and find visits on selected date
		$tomorrow = date('Y-m-d', strtotime($date. ' + 1 days'));
		$duration_obj = ServiceDuration::find()
			->where(['service_id' => $service_id])
			->one();

		$visits = Visit::find()
		->where(['fk_user' => $user_id])
		->andWhere(['>', 'start_time', $date])
		->andWhere(['<', 'start_time', $tomorrow])
		->orderBy(['start_time' => SORT_ASC])
		->all();
		// ------------------------------------------------------------------------
		// set period start time and end time for calculations		
		$period_start = new DateTime($date);
		$period_start_hour = '08:00';
		$work_end = new DateTime($date);
		$work_end_hour = '18:00';
		$period_start->modify($period_start_hour);
		$work_end->modify($work_end_hour);
		// ------------------------------------------------------------------------

		$duration = $duration_obj->duration;
		list($hours, $minutes) = explode(':', $duration); 
		$total_minutes = $hours * 60 + $minutes;
		$interval = new DateInterval('PT' . $total_minutes . 'M');

		$time_slots = array();
		$count = count($visits);
		echo $count . " - count\n";
		echo $duration . " - intervalas\n";

		if ($count > 0)
		{
			for ($i=0; $i <= $count; $i++) { 
				if ($i == $count) {
					// nuo paskutinio vizito pabaigos iki darbo pabaigos
					$period_start = new DateTime($visits[$i - 1]->end);
					if ($period_start < $break_start) {
						$daterange = new DatePeriod($period_start, $interval , $break_start);
						foreach($daterange as $range){
			            	if (date_add($range, $interval) <= $break_start)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
			            		echo $range->format('H:i') . "ideta ties if pirma dalis" . "\n";
							}
			            }
						$daterange = new DatePeriod($break_end, $interval , $work_end);
						foreach($daterange as $range){
			            	if (date_add($range, $interval) <= $work_end)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
			            		echo $range->format('H:i') . "ideta ties if antra dalis" . "\n";
							}
			            }
					} elseif ($period_start > $break_end) {
						$daterange_last_visit = new DatePeriod($period_start, $interval , $work_end);
			            foreach($daterange_last_visit as $range){
			            	if (date_add($range, $interval) <= $work_end)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
			            		echo $range->format('H:i') . "ideta ties elseif" . "\n";
							}
			            }
					} else {
						$daterange = new DatePeriod($break_end, $interval , $work_end);
			            foreach($daterange as $range){
			            	if (date_add($range, $interval) <= $work_end)
							{
								date_sub($range, $interval);
			            		$time_slots[] = $range->format('H:i');
			            		echo $range->format('H:i') . "ideta ties else" . "\n";
							}
			            }
					}
					//$work_end->modify($work_end_hour);

					/*$daterange_last_visit = new DatePeriod($period_start, $interval , $work_end);
		            foreach($daterange_last_visit as $range){
		            	if (date_add($range, $interval) <= $work_end)
						{
							date_sub($range, $interval);
		            		$time_slots[] = $range->format('H:i');
						}
		            }*/
				} else {
					// nuo darbo pradzios iki pirmo vizito pr arba nuo i vizito pab iki i+1 pr

					$period_end = new DateTime($visits[$i]->start_time);

					if ($period_start >= $break_start && $period_end <= $break_end) {
						$period_start = new DateTime($visits[$i]->end);
						continue;
					}

					$tmp_period_end = new DateTime($visits[$i]->start_time);
					$tmp_period_end->sub($interval);

					$tmp_break_start = new DateTime($date);
					$tmp_break_start->modify($break_start_hour);
					$tmp_break_start->sub($interval);

					if ($period_start <= $break_start && $period_end >= $break_end) {
						$daterange_before = new DatePeriod($period_start, $interval , $break_start);
						$daterange_after = new DatePeriod($break_end, $interval , $period_end);
						foreach($daterange_before as $range){		
							if ($range <= $tmp_break_start)
							{
			            		$time_slots[] = $range->format('H:i');
							}
			            }		
						foreach($daterange_after as $range){	
							if ($range <= $tmp_period_end)
							{
			            		$time_slots[] = $range->format('H:i');
							}
			            }	

			            $period_start = new DateTime($visits[$i]->end);

			            continue;
					}

					// blogai skaiciuoja slotus, kai intervalas atitinka laiko tarpa
					/*$period_end->sub($interval);
					$daterange = new DatePeriod($period_start, $interval , $period_end);
					if (!empty($daterange)){
						foreach($daterange as $range){		
							if ($range <= $break_start)
							{
			            		$time_slots[] = $range->format('H:i');
			            		echo $range->format('H:i') . " ideta ties pirmu else " . "\n";
							} elseif ($range >= $break_end) {
								$time_slots[] = $range->format('H:i');
			            		echo $range->format('H:i') . " ideta ties antru else . i = " . $i . "\n";
							}
							$daterange = array();
			            }
					}*/

					// ----------------------------------------------------------------------------------------
					// -- buvo uzkomentuota pries

					if ($i == 3) {
						echo $period_start->format('H:i') . " - i = 3 period start\n";
						echo $period_end->format('H:i') . " - i = 3 period end\n";
					}

					$daterange = new DatePeriod($period_start, $interval , $period_end); // daterange neatimant interval

					//--$tmp_break_end = new DateTime($date);
					//--$tmp_break_end->modify($break_end_hour);
					//--$tmp_break_end->sub($interval);
					
					//--if (!empty($daterange)){
						foreach($daterange as $range){		
							if ($range <= $tmp_break_start && $range <= $tmp_period_end)
							{
			            		$time_slots[] = $range->format('H:i');
							} elseif ($range >= $break_end && $range <= $tmp_period_end) {
								$time_slots[] = $range->format('H:i');						
							}
							//--$daterange = array();
			            }
					//--}									

					$period_start = new DateTime($visits[$i]->end);
				}
			}

			/*$i = 0;
			$int_end = $visits[$i]->end;

			echo $interval->format('%i') . " minutes\n";
			echo "\n";
		
			while($i < $count) 
			{
				$visit_start_time = new DateTime($visits[$i]->start_time); // [0] => 09:00, [1] => 12:00
				$visit_end_time = new DateTime($visits[$i]->end); // 		  [0] => 10:00, [1] => 13:00
				echo $visit_start_time->format('H:i') . " - " . $visit_end_time->format('H:i') ."\n";

				while(!($period_start->add($interval) > $visit_start_time))
				{
					echo $period_start->format('H:i') . " period start add\n";
					$added_slot = $period_start->sub($interval);
					echo $added_slot->format('H:i') . " added time slot\n";
					$time_slots[] = $added_slot->format('H:i');	

					$period_start->add($interval);
					echo $period_start->format('H:i') . " period start in while loop\n";
				}
				$period_start = $visit_end_time;
				echo $period_start->format('H:i') . " reset period start\n";
				$i++;	
				echo "\n";		
			}*/
		} else {			
			$daterange_before_break = new DatePeriod($period_start, $interval ,$break_start);
			$daterange_after_break = new DatePeriod($break_end, $interval ,$work_end);
			//$daterange = new DatePeriod('2019-04-04 08:00', 'PT2H' , '2019-04-04 18:00');
			foreach($daterange_before_break as $range){				
				//var_dump(date_add($range, $interval));
				//die();				
				if (date_add($range, $interval) <= $break_start)
				{
					date_sub($range, $interval);
            		$time_slots[] = $range->format('H:i');
				}
            }
            foreach($daterange_after_break as $range){
            	if (date_add($range, $interval) <= $work_end)
				{
					date_sub($range, $interval);
            		$time_slots[] = $range->format('H:i');
				}
            }
		}	
	
		/*while($i < $count) 
		{
			$period_end = new DateTime($visits[$i]->start_time);
			$period_diff = $period_end->diff($period_start);
			echo $period_start->format('H:i') . " period start\n";
			if ($period_diff >= $duration)
			{
				while($period_diff >= $interval)
				{
					$time_slots[] = $period_start;
					echo $period_start->format('H:i') . " period start\n";
					$period_start->add($interval);
					echo $period_start->format('H:i') . " period start add\n";
					//$period_diff->sub($interval);
					break;
				}
			}
			$period_start->modify($visits[$i]->end);
			echo $i . "\n";
			$i++;			
		}*/
		if(count($time_slots)>0){
			foreach ($time_slots as $slot) {
				echo $slot . "\n";			
				//echo $slot->format('H:i') . "\n";
			}
		}
	}
}
