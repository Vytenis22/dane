<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%treatment}}".
 *
 * @property double $price
 * @property int $id_treatment
 * @property int $fk_id_treatment_type
 * @property int $fk_id_service
 */
class Treatment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%treatment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['id_treatment', 'fk_id_treatment_type', 'fk_id_service'], 'required'],
            [['id_treatment', 'fk_id_treatment_type', 'fk_id_service'], 'integer'],
            [['id_treatment', 'fk_id_service'], 'unique', 'targetAttribute' => ['id_treatment', 'fk_id_service']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'price' => Yii::t('app', 'Price'),
            'id_treatment' => Yii::t('app', 'Id Treatment'),
            'fk_id_treatment_type' => Yii::t('app', 'Fk Id Treatment Type'),
            'fk_id_service' => Yii::t('app', 'Fk Id Service'),
        ];
    }
}
