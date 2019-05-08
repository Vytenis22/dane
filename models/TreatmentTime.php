<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%treatment_time}}".
 *
 * @property string $duration
 * @property int $id_treatment_time
 * @property int $fk_id_service
 */
class TreatmentTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%treatment_time}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['duration'], 'safe'],
            [['id_treatment_time', 'fk_id_service'], 'required'],
            [['id_treatment_time', 'fk_id_service'], 'integer'],
            [['id_treatment_time', 'fk_id_service'], 'unique', 'targetAttribute' => ['id_treatment_time', 'fk_id_service']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'duration' => Yii::t('app', 'Duration'),
            'id_treatment_time' => Yii::t('app', 'Id Treatment Time'),
            'fk_id_service' => Yii::t('app', 'Fk Id Service'),
        ];
    }
}
