<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Visit;
use app\models\VisitPayment;
use app\models\TokenPatient;
use app\models\Services;
use app\models\ServiceDuration;
use app\models\Profile;
use app\models\Patient;
use app\models\ServiceAssignment;
use app\models\AuthAssignment;
use dektrium\user\models\User;
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
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
		$date = "2019-03-07";
		$time = "11:40";
		$dateTime = date('Y-m-d H:i:s',strtotime($time,strtotime($date)));
		echo $dateTime . "\n";

        return ExitCode::OK;
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionPayment()
    {
    	$patient = Patient::find()->where(['name' => 'Monika'])->one();
    	echo $patient->id_Patient . "\n";
        $visit = Visit::find()->where(['fk_patient' => $patient->id_Patient])->one();
        echo $visit->id_visit . "\n";
        $visit_payment = $visit->paymentName->name;        
		echo $visit_payment . "\n";

		$token = TokenPatient::find()->where(['code' => 'ABex2Im0cJi_Ku4PeUatQQheXLRGQcwn', 'type' => TokenPatient::TYPE_CONFIRM_REG])->one();
		$visit = Visit::find()->where(['id_visit' => $token->visit_id])->one();        
		echo $visit->id_visit . "\n";		

        return ExitCode::OK;
    }
	
	public function actionDocs($id) 
	{
		$service_cat = Services::find()
		->where(['id' => $id])->one();		
		echo $service_cat->parent_id . "\n";
		
		$filtered_docs = User::find()
		->leftJoin('service_assignment', 'service_assignment.user_id = user.id')
		->leftJoin('services', 'services.id = service_assignment.category_id')
		->where(['services.id' => $service_cat])
		->all();		
		echo count($filtered_docs) . "\n";
		
		$filt_profiles = array();
		foreach ($filtered_docs as $doc) 
		{
			$filt_profiles[] = $doc->profile;
		}
		foreach ($filt_profiles as $profile) 
		{
			echo $profile->name . "\n";
		}		
		
		return ExitCode::OK;
	}
	
	public function actionTimes()
	{
		$work_start = '08:00';
		$work_end = '18:00';
		$date = '2019-03-07';
		$date1 = '2019-03-08';
		$doc_id = 7;
		$service_id = 5;
		
		$time_slots = array();
		
		$service_duration = ServiceDuration::find()
			->where(['service_id' => $service_id])->one();
		
		echo date('H:i', strtotime($service_duration->duration)) . "\n";
		
		$time_slots[] = $work_start;
		$tmp_slot = $work_start;
		
		//echo date('H:i', strtotime($tmp_slot. ' + 1 hour')) . "\n";
		
		$hours = '01:30';		
		$minutes = 0; 
		if (strpos($hours, ':') !== false) 
		{ 
			// Split hours and minutes. 
			list($hours, $minutes) = explode(':', $hours); 
		} 
		$total =  $hours * 60 + $minutes;
		echo "minutes " . $total . "\n";
		
		$new_date_time = new DateTime($work_start);
		$new_date_time->format('H:i');
		echo gettype($new_date_time) . "\n";
		
		while (date('H:i', strtotime($tmp_slot. ' + 1 hour')) < $work_end)
		{
			$tmp_slot = date('H:i', strtotime($tmp_slot. ' + 1 hour'));
			//$time_slots[] = date('H:i', strtotime($tmp_slot));
			$time_slots[] = $tmp_slot;			
		}
		
		/* foreach ($time_slots as $slot)
		{
			echo $slot . "\n";
		} */
		
		$visits = Visit::find()
		->where(['>=', 'start_time', $date])
		->andWhere(['<', 'start_time', $date1])
		->andWhere(['fk_user' => $doc_id])
		->orderBy('start_time ASC')
		->all();
		
		return ExitCode::OK;
	}
	
	public function actionTimes2() 
	{
		$start = '08:00:00';
		$end = '18:00:00';
		
		$duration = '01:30';		
		$minutes = 0; 
		if (strpos($duration, ':') !== false) 
		{ 
			// Split hours and minutes. 
			list($duration, $minutes) = explode(':', $duration); 
		} 
		$total =  $duration * 60 + $minutes;		
		//echo "minutes " . $total . "\n";

		$dateTimes = new DatePeriod(
			new DateTime($start),
			new DateInterval('PT'.$total.'M'),
			new DateTime($end)
		);
		foreach ($dateTimes as $dt) {
		  //echo $dt->format('H:i'), "\n";
		}
		
		$laikas = '12:00';
		$bandymas = date('Y-m-d H:i:s',strtotime('2019-03-07'. ' -' . "13:00"));
		echo $bandymas . "\n";
		return ExitCode::OK;
	}
	
	public function actionPat()
	{
		$if_exists = Patient::findOne([
					'name' => 'patient1',
					'surname' => 'surname1',
					'email' => 'skaudanugara2@gmail.com',
				]);
		echo is_null($if_exists) ? 'nulis' : 'ne nulis' . "\n";
		//echo $if_exists->name;
	}
}
