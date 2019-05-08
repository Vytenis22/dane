<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%service}}".
 *
 * @property string $name
 * @property double $price
 * @property string $duration
 * @property int $id_service
 * @property int $fk_service_type
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['duration'], 'safe'],
            [['id_service', 'fk_service_type'], 'required'],
            [['id_service', 'fk_service_type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_service'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'duration' => Yii::t('app', 'Duration'),
            'id_service' => Yii::t('app', 'Id Service'),
            'fk_service_type' => Yii::t('app', 'Fk Service Type'),
        ];
    }
}
