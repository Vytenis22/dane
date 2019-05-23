<?php

namespace app\models;

use Yii;
use dektrium\user\models\User;
use DateTime;
use DatePeriod;
use DateInterval;

/**
 * This is the model class for table "visit".
 *
 * @property string $reg_nr
 * @property string $start_time
 * @property string $time
 * @property string $add_time
 * @property string $end
 * @property string $room
 * @property string $info
 * @property double $total_price
 * @property int $status
 * @property int $payment
 * @property int $id_visit
 * @property int $fk_user
 * @property int $fk_patient
 * @property int $fk_branch
 *
 * @property OrderedService[] $orderedServices
 * @property Services[] $fkIdServices
 * @property TokenPatient[] $tokenPatients
 * @property Patient $fkPatient
 * @property VisitPayment $payment0
 * @property Services $fkService
 * @property VisitStatus $status0
 * @property User $fkUser
 */
class Visit extends \yii\db\ActiveRecord
{	
    const ROOM = 'bendras';

    const SCENARIO_AUTO = 'auto';
    const SCENARIO_DOCTOR = 'doctor';
    const SCENARIO_ASSIST = 'assist';

	const UNPAID = 'Neapmokėtas';

	const STATUS_ORDERED = 'Užsakytas';
    const PAID = 'Apmokėtas';
	const STATUS_GOING = 'Vyksta';
	const STATUS_DONE = 'Įvykęs';
	const STATUS_CANCEL = 'Atšauktas';

    const VISIT_UNCONFIRMED = 0;
    const VISIT_CONFIRMED = 1;
	
	public $doctor_room;
	
	public $tmpdate;
	public $tmptime;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_AUTO => ['fk_user', 'tmpdate', 'tmptime', 'time', 'start_time', 'end', 'room', 'total_price', 'status', 'payment', 'fk_patient', 'reg_nr'],
            self::SCENARIO_DOCTOR => ['fk_user','start_time', 'end', 'room', 'info', 'total_price', 'status', 'payment', 'fk_patient', 
                'reg_nr'],
            self::SCENARIO_ASSIST => ['fk_user','start_time', 'end', 'info', 'status', 'reg_nr'],
        ];
    }   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'time', 'end', 'tmpdate', 'tmptime'], 'safe'],
            [['total_price'], 'number'],
            [['fk_user', 'fk_patient', 'fk_branch', 'payment', 'status'], 'integer'],

            [['fk_user', 'tmpdate', 'time', 'payment', 'fk_patient'], 'required'],

            [['reg_nr'], 'string', 'max' => 8],
            //[['room'], 'string', 'max' => 15],
            [['info'], 'string', 'max' => 255],
            //[['fk_patient'], 'exist', 'skipOnError' => true, 'targetClass' => Patient::className(), 'targetAttribute' => ['fk_patient' => 'id_Patient']],
            //[['payment'], 'exist', 'skipOnError' => true, 'targetClass' => VisitPayment::className(), 'targetAttribute' => ['payment' => 'id']],
            //[['fk_service'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['fk_service' => 'id']],
            //[['status'], 'exist', 'skipOnError' => true, 'targetClass' => VisitStatus::className(), 'targetAttribute' => ['status' => 'id']],
            //[['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reg_nr' => Yii::t('app', 'Reg Nr'),
            'start_time' => Yii::t('app', 'Start Time'),
            'time' => Yii::t('app', 'Time'),
            'add_time' => Yii::t('app', 'Add Time'),
            'end' => Yii::t('app', 'End'),
            'room' => Yii::t('app', 'Room'),
            'info' => Yii::t('app', 'Info'),
            'total_price' => Yii::t('app', 'Total Price'),
            'status' => Yii::t('app', 'Status'),
            'payment' => Yii::t('app', 'Payment'),
            'id_visit' => Yii::t('app', 'Id Visit'),
            //'fk_service' => Yii::t('app', 'Fk Service'),
            'fk_user' => Yii::t('app', 'Doctor'),
            'fk_patient' => Yii::t('app', 'Patient'),
            'fk_branch' => Yii::t('app', 'Fk Branch'),
			
			'tmpdate' => Yii::t('app', 'TMP start date'),
			'tmptime' => Yii::t('app', 'TMP start time'),
        ];
    }
	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderedServices()
    {
        return $this->hasMany(OrderedService::className(), ['fk_id_visit' => 'id_visit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Services::className(), ['id' => 'fk_id_service'])->via('orderedServices');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokenPatients()
    {
        return $this->hasMany(TokenPatient::className(), ['visit_id' => 'id_visit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id_Patient' => 'fk_patient']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentName()
    {
        return $this->hasOne(VisitPayment::className(), ['id' => 'payment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     
    public function getService()
    {
        return $this->hasOne(Services::className(), ['id' => 'fk_service']);
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(VisitStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'fk_user']);
    }
	
	/*
	* return doctors room
	*/
	public function getDoctorRoom()
    {
		$doctor_room = Rooms::findOne(['user_id' => $this->fk_user]);
        return $doctor_room;
    }
	
	/*
	* return patients name
	*/
	public static function getPatientName($id)
    {
		//$query = Visit::find()->where(['id_visit' => $id]);
		
		
		$query = Visit::find()->where(['id_visit' => $id])->one();

		//$query->joinWith(['patient']);
        //return $this->patient->name . " " . $this->patient->surname;
		$patient = $query->patient;
		//return $patient->name . " " . $patient->surname;
		return $patient;
    }
    
    /*
    * return patients name
    */
    public static function getDurationMinutes($fk_id_service)
    {
        $duration = ServiceDuration::find()
            ->where(['service_id' => $fk_id_service])
            ->one();

        $minutes = 0; 
        $duration_m = $duration->duration;
        if (strpos($duration_m, ':') !== false) 
        { 
            // Split hours and minutes. 
            list($duration_m, $minutes) = explode(':', $duration_m); 
        } 
        $duration_minutes =  $duration_m * 60 + $minutes;

        return $duration_minutes;
    }
	
	/*
	* return patients list
	*/
	public function getPatientsList()
    {		
		$bool = 'true';
		$dateNow = date('Y-m-d');
		$tomorrow = date('Y-m-d', strtotime($dateNow. ' + 1 days'));
		
		$query = Visit::find()->where(['start_time' => '2019-03-06'])->all();
		/**
		$query = Visit::find()
		->select(['visit.room', 'patient.name', 'patient.email'])
		->leftJoin('patient', '`visit`.`fk_patient` = `patient`.`id_Patient`')
		->where(['visit.start_time' => '2019-03-07'])
		->all();
		*/
		if ($query){
			//$patients = $query->patient;
			return $query;
		} else 
			$bool = 'false';
			return $bool;
		//return $patient->name . " " . $patient->surname;
		//return $patients;
    }

    /*
    * return doctor visits
    */
    public static function getDoctorVisits($doc_id) {        
        $today = date('Y-m-d');

        $command = (new \yii\db\Query())
            ->select(['start_time', 'end', 'date_format(start_time, "%Y-%m-%d") as start_format'])
            ->from('visit')
            ->where(['and', 'fk_user=:doc_id', 'start_time>:today'])
            ->addParams([':doc_id' => $doc_id, ':today' => $today])
            ->orderBy(['start_time' => SORT_ASC])
            ->all();

        return $command;
    }
    
    /*
    * return doctor times
    */
    public static function getDoctorTimes($dates, $id, $service) {
        //$date = '2019-04-05';
        $date = $dates;
        //$user_id = 7;
        $user_id = $id;
        //$service_id = 5;
        $service_id = $service;
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
                            }
                        }
                        $daterange = new DatePeriod($break_end, $interval , $work_end);
                        foreach($daterange as $range){
                            if (date_add($range, $interval) <= $work_end)
                            {
                                date_sub($range, $interval);
                                $time_slots[] = $range->format('H:i');
                            }
                        }
                    } elseif ($period_start > $break_end) {
                        $daterange_last_visit = new DatePeriod($period_start, $interval , $work_end);
                        foreach($daterange_last_visit as $range){
                            if (date_add($range, $interval) <= $work_end)
                            {
                                date_sub($range, $interval);
                                $time_slots[] = $range->format('H:i');
                            }
                        }
                    } else {
                        $daterange = new DatePeriod($break_end, $interval , $work_end);
                        foreach($daterange as $range){
                            if (date_add($range, $interval) <= $work_end)
                            {
                                date_sub($range, $interval);
                                $time_slots[] = $range->format('H:i');
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

        return $time_slots;
    }
	
	/** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            if (isset($this->fk_user))
            {
                
            } else 
            {
                $this->fk_user = \Yii::$app->user->id;
            }
            if (isset($this->reg_nr))
            {
                
            } else
            {
                $this->setAttribute('reg_nr', Yii::$app->security->generateRandomString(8));
                //$this->room = $this->doctorRoom->name;

                //$this->fk_user = \Yii::$app->user->id;

                //daryti su scenarios? ir cia det if arba case
                //$this->start_time = date('Y-m-d H:i:s',strtotime($this->st_time,strtotime($this->st_date)));
            } 
            if (isset($this->room))
            {
                
            } else
            {
                $this->room = $this->doctorRoom->name;
            }            
        }

        return parent::beforeSave($insert);
    }
}
