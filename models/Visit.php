<?php

namespace app\models;

use Yii;
use dektrium\user\models\User;

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
            self::SCENARIO_AUTO => ['fk_user', 'tmpdate', 'tmptime', 'time', 'start_time', 'end', 'room', 'status', 'payment', 'fk_patient', 'reg_nr'],
            self::SCENARIO_DOCTOR => ['fk_user','start_time', 'end', 'room', 'info', 'status', 'payment', 'fk_patient', 
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
