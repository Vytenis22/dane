<?php

namespace app\models;

use Yii;
use dektrium\user\models\User;
use yii\helpers\ArrayHelper;
use DateTime;
use DatePeriod;
use DateInterval;

/**
 * This is the model class for table "vacations".
 *
 * @property int $id
 * @property string $begin
 * @property string $end
 * @property string $status
 * @property int $fk_user
 * @property int $fk_admin
 *
 * @property User $fkAdmin
 * @property User $fkUser
 */
class Vacations extends \yii\db\ActiveRecord
{
    const SUBMITTED = 0;
    const CONFIRMED = 1;
    const REJECTED = 2;

    const SCENARIO_ADMIN = 'admin';
    const SCENARIO_DOCTOR = 'doctor';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacations';
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DOCTOR => ['begin', 'end'],
            self::SCENARIO_ADMIN => ['begin','end', 'fk_user', 'status'],
        ];
    }  

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'confirmed_at'], 'safe'],

            [['begin', 'end', 'status', 'fk_user'], 'required'],
            [['begin', 'end'], 'safe'],
            [['fk_user', 'fk_admin', 'status'], 'integer'],
            //[['status'], 'string', 'max' => 15],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'begin' => Yii::t('app', 'Begin'),
            'end' => Yii::t('app', 'End'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'confirmed_at' => Yii::t('app', 'Confirmed'),
            'fk_user' => Yii::t('app', 'Employee'),
            'fk_admin' => Yii::t('app', 'Fk Admin'),
        ];
    }

    public function confirm()
    {        
        $result = (bool) $this->updateAttributes(['status' => Vacations::CONFIRMED]);
        $this->updateAttributes(['confirmed_at' => date('Y-m-d H:i')]);
        return $result;
    }

    public function reject()
    {        
        $result = (bool) $this->updateAttributes(['status' => Vacations::REJECTED]);
        $this->updateAttributes(['confirmed_at' => date('Y-m-d H:i')]);
        return $result;
    }

    public static function getEmployees()
    {
        $doctors = User::find()
            ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
            ->where(['=', 'auth_assignment.item_name', 'assistant'])
            ->orWhere(['=', 'auth_assignment.item_name', 'doctor'])
            ->orWhere(['=', 'auth_assignment.item_name', 'admin'])
            ->orderBy(['user.id' => SORT_ASC])
            ->all();

        $doctors_profiles = array();
        foreach ($doctors as $doctor) {
            $doctors_profiles[] = $doctor->profile;
        }

        $doctors_list = ArrayHelper::map($doctors_profiles, 'user_id', 'name');

        return $doctors_list;
    }

    public static function getStatusList()
    {
        $status = [
            ['id' => '1', 'name' => 'Patvirtinta'], 
            ['id' => '2', 'name' => 'Atmesta'],
        ];

        $status_list = ArrayHelper::map($status, 'id', 'name');

        return $status_list;
    }

    public static function getDoctorVacations($doc_id)
    {
        $vacations_list = array();

        $vacations = Vacations::find()
            ->where(['fk_user' => $doc_id])
            ->andWhere(['status' => Vacations::CONFIRMED])
            ->all();

        $interval = new DateInterval('P1D');
        if (!empty($vacations))
        {
            foreach ($vacations as $vacation) {
                $period_start = new Datetime($vacation->begin);
                $vacations_end = new Datetime($vacation->end);
                $period_end = $vacations_end->add($interval);     
                $daterange = new DatePeriod($period_start, $interval , $period_end);

                foreach ($daterange as $range) {
                    $vacations_list[] = $range->format('Y-m-d');
                }
            }
        }        

        return $vacations_list;
    }

    public static function getUnavailableVacations($doc_id)
    {
        $vacations_list = Vacations::getDoctorVacations($doc_id);
        $visits_list = array();

        $today = date('Y-m-d');
        $visits = (new \yii\db\Query())
            ->select(['date_format(start_time, "%Y-%m-%d") as begin'])
            ->from('visit')
            ->where(['and', 'fk_user=:doc_id', 'start_time>:today'])
            ->addParams([':doc_id' => $doc_id, ':today' => $today])
            ->orderBy(['start_time' => SORT_ASC])
            ->groupBy(['begin'])
            ->all();
        foreach ($visits as $visit) {
            $visits_list[] = $visit["begin"];
        }
        $unavailable_days = array_merge($vacations_list,$visits_list);

        return $unavailable_days;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_admin']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'fk_admin']);
    }
}
