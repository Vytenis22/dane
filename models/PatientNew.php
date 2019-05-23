<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patient".
 *
 * @property string $card_number
 * @property string $name
 * @property string $surname
 * @property string $code
 * @property string $email
 * @property string $phone
 * @property string $sex
 * @property string $address
 * @property string $city
 * @property string $birth_date
 * @property int $id_Patient
 *
 * @property Recipes[] $recipes
 * @property TokenPatient[] $tokenPatients
 * @property TreatmentPlans[] $treatmentPlans
 * @property Visit[] $visits
 */
class PatientNew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'integer'],
            [['birth_date'], 'safe'],
            [['card_number'], 'string', 'max' => 10],
            [['name', 'surname'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 35],
            [['phone'], 'string', 'max' => 15],
            [['sex'], 'string', 'max' => 7],
            [['address'], 'string', 'max' => 100],
            [['city'], 'string', 'max' => 20],
            [['card_number'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'card_number' => Yii::t('app', 'Card Number'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'code' => Yii::t('app', 'Code'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'sex' => Yii::t('app', 'Sex'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'id_Patient' => Yii::t('app', 'Id Patient'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipes::className(), ['fk_patient' => 'id_Patient']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokenPatients()
    {
        return $this->hasMany(TokenPatient::className(), ['patient_id' => 'id_Patient']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreatmentPlans()
    {
        return $this->hasMany(TreatmentPlans::className(), ['fk_patient' => 'id_Patient']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(Visit::className(), ['fk_patient' => 'id_Patient']);
    }
}
