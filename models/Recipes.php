<?php

namespace app\models;

use Yii;
use dektrium\user\models\User;

/**
 * This is the model class for table "recipes".
 *
 * @property int $id
 * @property string $create_at
 * @property string $expire
 * @property string $rp
 * @property string $N
 * @property string $S
 * @property int $fk_patient
 * @property int $fk_user
 *
 * @property User $fkUser
 * @property Patient $fkPatient
 */
class Recipes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recipes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_at', 'expire'], 'safe'],
            [['rp'], 'string', 'max' => 255],
            [['fk_patient', 'fk_user'], 'required'],
            [['fk_patient', 'fk_user'], 'integer'],
            [['N'], 'string', 'max' => 55],
            [['S'], 'string', 'max' => 25],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
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
            'create_at' => Yii::t('app', 'Create At'),
            'expire' => Yii::t('app', 'Expire'),
            'rp' => Yii::t('app', 'Rp'),
            'N' => Yii::t('app', 'N'),
            'S' => Yii::t('app', 'S'),
            'fk_patient' => Yii::t('app', 'Fk Patient'),
            'fk_user' => Yii::t('app', 'Fk User'),
        ];
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
    
    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            //$this->fk_user = \Yii::$app->user->id;
            $this->create_at = date('Y-m-d H:i');            
        }

        return parent::beforeSave($insert);
    }
}
