<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%patient}}".
 *
 * @property string $name
 * @property string $surname
 * @property int $code
 * @property string $email
 * @property string $phone
 * @property string $sex
 * @property date $birth_date
 * @property int $id_Patient
 */
class Patient extends \yii\db\ActiveRecord
{	
	const SCENARIO_AUTO = 'auto';
    const SCENARIO_CREATE = 'create';
	
	//public $countPatients = Patient::findAll()->count();
	public $verifyCode;
    public $fullname;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%patient}}';
    }
	
	public static function patients() {
		$countPatients = Patient::find()->count();
		return $countPatients;
	}
	
	/**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_AUTO => ['card_number', 'name', 'surname', 'code', 'email', 'phone', 'verifyCode', 'sex'],
            self::SCENARIO_CREATE => ['card_number', 'name', 'surname', 'email', 'birth_date', 'phone', 'code', 'sex'],
        ];
    }	

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			/*'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],*/
			
            /*[['id_Patient', 'sex', 'card_number', 'name', 'surname', 'code', 'phone'], 'required'],
            [['id_Patient'], 'integer'],
            [['name', 'surname'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 11],
            [['code'], 'integer'],
            [['email'], 'string', 'max' => 35],
            [['phone'], 'string', 'max' => 15],            
            [['sex'], 'string', 'max' => 7],            
            [['card_number'], 'string', 'max' => 10],
            [['birth_date'], 'safe'],
            [['card_number'], 'unique'],
            [['code'], 'unique'],*/
			
            [['sex', 'name', 'surname', 'code', 'phone', 'birth_date', 'email'], 'required'],
			['verifyCode', 'captcha'],

            [['code'], 'integer'],
            [['birth_date'], 'safe'],
            [['card_number'], 'string', 'max' => 10],
            [['name', 'surname'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 35],
            [['phone'], 'string', 'max' => 15],
            [['sex'], 'string', 'max' => 7],
            [['address'], 'string', 'max' => 100],
            [['city'], 'string', 'max' => 20],
            [['code'], 'string', 'max' => 11],
            [['code'], 'string', 'min' => 11],
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
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'code' => Yii::t('app', 'Asmens kodas'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),            
            'birth_date' => Yii::t('app', 'Birth Date'),
            'id_Patient' => Yii::t('app', 'Id Patient'),
            'sex' => Yii::t('app', 'Sex'),
            'card_number' => Yii::t('app', 'Card Number'),
			
			'verifyCode' => 'Patvirtinimo kodas',
        ];
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
    public function getFullname()
    {
        return $this->fullname = $this->name . " " . $this->surname;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenNumber($id_Patient)
    {
        $years = date('y');
        $formatted_id = sprintf('%04d', $id_Patient);
        $cardNumber = $years . "-" . $formatted_id;

        return $cardNumber;
    }
    
    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            //$patientCount = Patient::find()->count();

            $last_patient = Patient::find()->orderBy(['id_Patient' => SORT_DESC])->one();
            $last_patient_id = $last_patient->id_Patient;
            $this->card_number = $this->getGenNumber($last_patient_id + 1);     
        }

        return parent::beforeSave($insert);
    }
}
