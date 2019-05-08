<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservations_expirations".
 *
 * @property int $visit_id
 * @property string $created_at
 * @property string $expiration
 *
 * @property Visit $visit
 */
class ReservationsExpirations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservations_expirations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_id'], 'required'],
            [['visit_id'], 'integer'],
            [['created_at', 'expiration'], 'safe'],
            [['visit_id'], 'unique'],
            [['visit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Visit::className(), 'targetAttribute' => ['visit_id' => 'id_visit']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'visit_id' => Yii::t('app', 'Visit ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'expiration' => Yii::t('app', 'Expiration'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['id_visit' => 'visit_id']);
    }
}
