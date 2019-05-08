<?php

namespace app\models;

use Yii;
use dektrium\user\models\User;

/**
 * This is the model class for table "assists".
 *
 * @property int $id_assist
 * @property int $fk_user
 * @property string $reg_nr
 * @property string $start_time
 * @property string $end
 * @property string $info
 *
 * @property User $fkUser
 */
class Assists extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assists';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_user', 'start_time', 'end', 'info'], 'required'],
            [['fk_user'], 'integer'],
            [['start_time', 'end'], 'safe'],
            [['reg_nr'], 'string', 'max' => 8],
            [['info'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_assist' => Yii::t('app', 'Id Assist'),
            'fk_user' => Yii::t('app', 'Fk User'),
            'reg_nr' => Yii::t('app', 'Reg Nr'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end' => Yii::t('app', 'End'),
            'info' => Yii::t('app', 'Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user']);
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
        }

        return parent::beforeSave($insert);
    }
}
