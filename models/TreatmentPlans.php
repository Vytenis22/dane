<?php

namespace app\models;

use Yii;
use dektrium\user\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "treatment_plans".
 *
 * @property int $id
 * @property string $begin
 * @property string $end
 * @property string $info
 * @property int $fk_patient
 * @property int $fk_doctor
 *
 * @property Patient $fkPatient
 */
class TreatmentPlans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'treatment_plans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['begin', 'end'], 'safe'],
            [['info'], 'string'],
            [['fk_patient'], 'required'],
            [['fk_patient'], 'integer'],
            [['fk_patient'], 'exist', 'skipOnError' => true, 'targetClass' => Patient::className(), 'targetAttribute' => ['fk_patient' => 'id_Patient']],
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
            'info' => Yii::t('app', 'Info'),
            'fk_patient' => Yii::t('app', 'Patient'),
            'fk_doctor' => Yii::t('app', 'Doctor'),
        ];
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
    public function getPatientName()
    {
        return $this->patient->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatientFullName()
    {
        return $this->patient->name . " " . $this->patient->surname;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_doctor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'fk_doctor']);
    }
    
    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->fk_doctor = \Yii::$app->user->id;          
        }

        return parent::beforeSave($insert);
    }
}
