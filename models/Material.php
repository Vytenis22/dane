<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%material}}".
 *
 * @property string $name
 * @property double $price
 * @property string $info
 * @property int $id_material
 * @property int $fk_id_material_type
 *
 * @property MaterialType $fkIdMaterialType
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%material}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['fk_id_material_type'], 'required'],
            [['fk_id_material_type'], 'integer'],
            [['name', 'info'], 'string', 'max' => 255],
            [['fk_id_material_type'], 'exist', 'skipOnError' => true, 'targetClass' => MaterialType::className(), 'targetAttribute' => ['fk_id_material_type' => 'id_material_type']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Pavadinimas'),
            'price' => Yii::t('app', 'Kaina'),
            'info' => Yii::t('app', 'Informacija'),
            'id_material' => Yii::t('app', 'Nr.'),
            'fk_id_material_type' => Yii::t('app', 'Tipas'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMat()
    {
        return $this->hasOne(MaterialType::className(), ['id_material_type' => 'fk_id_material_type']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getMatName()
    {
        return $this->mat->name;
    }
}
