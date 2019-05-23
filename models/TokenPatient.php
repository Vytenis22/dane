<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use dektrium\user\traits\ModuleTrait;
use app\models\Patient;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Token Active Record model.
 *
 * @property integer $patient_id
 * @property string  $code
 * @property integer $created_at
 * @property integer $type
 * @property string  $url
 * @property bool    $isExpired
 * @property Patient $patient
 * @property Visit   $visit_id
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class TokenPatient extends ActiveRecord
{
    //use ModuleTrait;
	
	const TYPE_CANCEL			 = 4;
    const TYPE_CONFIRM_REG       = 5;

    /* const TYPE_CONFIRMATION      = 0;
    const TYPE_RECOVERY          = 1;
    const TYPE_CONFIRM_NEW_EMAIL = 2;
    const TYPE_CONFIRM_OLD_EMAIL = 3; */

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        //return $this->hasOne(Patient::className(), ['id_Patient' => 'patient_id']);
		return $this->hasOne($this->module->modelMap['Patient'], ['id_Patient' => 'patient_id']);
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['id_visit' => 'visit_id']);
		//return $this->hasOne($this->module->modelMap['Visit'], ['id_visit' => 'visit_id']);
    }
	
    /**
     * @return string
     */
    public function getUrl()
    {
        switch ($this->type) {
			case self::TYPE_CANCEL:
                //$route = '/site/cancel';
				//$route = \Yii::$app->baseUrl . '/site/cancel';
				//die("sutvarkyt route in tokenpatient 62\n");
				//$home = Url::home(true);
				//$route = $home . '/site/cancel';
				
				//$route = \Yii::$app->getUrlManager()->createUrl(['site/cancel', 'id' => $this->patient_id, 'code' => $this->code]);
				/*$route = Url::to(['site/cancel', 'patient_id' => $this->patient_id, 'code' => $this->code, 'visit_id' => $this->visit_id], true);*/
                $route = Url::to(['site/cancel', 'code' => $this->code], true);
                break;
            case self::TYPE_CONFIRM_REG:
                $route = Url::to(['site/confirm', 'code' => $this->code], true);
                break;
            default:
                throw new \RuntimeException();
        }

        //return Url::to([$route, 'id' => $this->patient_id, 'code' => $this->code], true);
		return $route;
    }

    /**
     * @return bool Whether token has expired.
     */
    public function getIsExpired()
    {
        switch ($this->type) {
			case self::TYPE_CANCEL:
                //$expirationTime = $this->module->cancelWithin;
				$expirationTime = 60;
                break;
            case self::TYPE_CONFIRM_REG:
                //$expirationTime = $this->module->cancelWithin;
                $expirationTime = 600;
                break;
            default:
                throw new \RuntimeException();
        }

        return ($this->created_at + $expirationTime) < time();
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            static::deleteAll(['patient_id' => $this->patient_id, 'type' => $this->type]);
            $this->setAttribute('created_at', time());
            $this->setAttribute('code', Yii::$app->security->generateRandomString());
        }

        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%token_patient}}';
    }

    /** @inheritdoc */
    public static function primaryKey()
    {
        return ['visit_id', 'patient_id', 'code', 'type'];
    }
}
