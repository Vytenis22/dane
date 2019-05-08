<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%material_type}}".
 *
 * @property string $name
 * @property int $id_material_type
 *
 * @property Material[] $materials
 */
class MaterialType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%material_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Pavadinimas'),
            'id_material_type' => Yii::t('app', 'Nr.'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['fk_id_material_type' => 'id_material_type']);
    }
}
