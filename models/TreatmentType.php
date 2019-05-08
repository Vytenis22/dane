<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%treatment_type}}".
 *
 * @property string $name
 * @property int $id_treatment_type
 */
class TreatmentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%treatment_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_treatment_type'], 'required'],
            [['id_treatment_type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_treatment_type'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'id_treatment_type' => Yii::t('app', 'Id Treatment Type'),
        ];
    }
}
