<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_category".
 *
 * @property int $id
 * @property string $name
 *
 * @property Services[] $services
 */
class ServiceCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_name'], 'required'],
            [['parent_name'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_name' => Yii::t('app', 'Parent Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Services::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getDoctorCategories($user_id)
    {
        $categories = ServiceCategory::find()
            ->leftJoin('service_assignment', 'service_assignment.category_id = service_category.id')
            ->where(['=', 'service_assignment.user_id', $user_id])
            ->orderBy(['service_category.id' => SORT_ASC])
            ->all();

        return $categories;
    }
}
