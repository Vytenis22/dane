<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_duration".
 *
 * @property int $service_id
 * @property string $duration
 *
 * @property Services $service
 */
class ServiceDuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_duration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'duration'], 'required'],
            [['service_id'], 'integer'],
            [['duration'], 'safe'],
            [['service_id'], 'unique'],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('app', 'Service ID'),
            'duration' => Yii::t('app', 'Duration'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
    }
}
