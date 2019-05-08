<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 *
 * @property OrderedService[] $orderedServices
 * @property Visit[] $fkIdVisits
 * @property ServiceAssignment[] $serviceAssignments
 * @property User[] $users
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['name', 'parent_id', 'price'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 65],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ServiceCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDuration()
    {
        return $this->hasOne(ServiceDuration::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderedServices()
    {
        return $this->hasMany(OrderedService::className(), ['fk_id_service' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIdVisits()
    {
        return $this->hasMany(Visit::className(), ['id_visit' => 'fk_id_visit'])->viaTable('ordered_service', ['fk_id_service' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceAssignments()
    {
        return $this->hasMany(ServiceAssignment::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('service_assignment', ['category_id' => 'id']);
    }
	
	public static function getHierarchy() {
        //$parent_options = [];
		$options = [];
         
        $parents = self::find()->where("parent_id=0")->all();
        foreach($parents as $id => $p) {
            $children = self::find()->where("parent_id=:parent_id", [":parent_id"=>$p->id])->all();
            $child_options = [];
            foreach($children as $child) {
                $child_options[$child->id] = $child->name;
            }
            $options[$p->name] = $child_options;
			//$parent_options[$p->id] = $options[$p->name];
        }
        return $options;
		//return $parent_options;
    }
}
