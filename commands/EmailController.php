<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\helpers\Url;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Visit;
use app\models\AuthAssignment;
use app\models\TokenPatient;
use app\models\Patient;
use app\models\ServiceDuration;
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
		echo $date . "\n";
		echo $date_format . "\n";

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
					->setTo($patient->email)
					->setSubject("Welcome subject");
					//->send();
				echo "Email sent from " . Yii::$app->params['adminEmail'] . " to " . $patient->email . "\n";
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
		if ($count > 0)
		{
			$i = 0;
			$int_end = $visits[$i]->end;

			echo $interval->format('%i') . " minutes\n";
			echo "\n";
		
			while($i < $count) 
			{
				$visit_start_time = new DateTime($visits[$i]->start_time); // [0] => 09:00, [1] => 12:00
				$visit_end_time = new DateTime($visits[$i]->end); // 		  [0] => 10:00, [1] => 13:00
				echo $visit_start_time->format('H:i') . " - " . $visit_end_time->format('H:i') ."\n";

				if(!($period_start->add($interval) > $visit_start_time))
				{
					echo $period_start->format('H:i') . " period start add\n";
					$added_slot = $period_start->sub($interval);
					echo $added_slot->format('H:i') . " added time slot\n";
					$time_slots[] = $added_slot->format('H:i');
				}			
				$period_start = $visit_end_time;
				echo $period_start->format('H:i') . " reset period start\n";
				$i++;	
				echo "\n";		
			}
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
		foreach ($time_slots as $slot) {
			echo $slot . "\n";			
			//echo $slot->format('H:i') . "\n";
		}
	}
}
