<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ordered_service".
 *
 * @property int $amount
 * @property double $total_price
 * @property int $id_ordered_service
 * @property int $fk_id_service
 * @property int $fk_id_visit
 *
 * @property Service $fkIdService
 * @property Visit $fkIdVisit
 */
class OrderedService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordered_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_id_service', 'fk_id_visit'], 'integer'],
            //[['total_price'], 'number'],
            [['fk_id_service', 'fk_id_visit'], 'required'],
            [['fk_id_service'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['fk_id_service' => 'id']],
            [['fk_id_visit'], 'exist', 'skipOnError' => true, 'targetClass' => Visit::className(), 'targetAttribute' => ['fk_id_visit' => 'id_visit']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            //'amount' => Yii::t('app', 'Amount'),
            //'total_price' => Yii::t('app', 'Total Price'),
            //'id_ordered_service' => Yii::t('app', 'Id Ordered Service'),
            'fk_id_service' => Yii::t('app', 'Paslauga'),
            'fk_id_visit' => Yii::t('app', 'Fk Id Visit'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIdService()
    {
        return $this->hasOne(Services::className(), ['id' => 'fk_id_service']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIdVisit()
    {
        return $this->hasOne(Visit::className(), ['id_visit' => 'fk_id_visit']);
    }

    public static function primaryKey()
    {
        return ['fk_id_service'];
    }
}
