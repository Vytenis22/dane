<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Material;

/**
 * MaterialSearch represents the model behind the search form of `app\models\Material`.
 */
class MaterialSearch extends Material
{
	public $mat;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'info', 'mat'], 'safe'],
            [['price'], 'number'],
			[['id_material'], 'integer'],
            [['id_material', 'fk_id_material_type'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Material::find();

		$query->joinWith(['mat']);
		
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);		
		
		$dataProvider->sort->attributes['mat'] = [
			// The tables are the ones our relation are configured to
			// in my case they are prefixed with "tbl_"
			'asc' => ['material_type.name' => SORT_ASC],
			'desc' => ['material_type.name' => SORT_DESC],
		];				

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'price' => $this->price,
            'id_material' => $this->id_material,
            //'fk_id_material_type' => $this->fk_id_material_type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'info', $this->info])
			->andFilterWhere(['like', 'material_type.name', $this->mat]);

        return $dataProvider;
    }
}
