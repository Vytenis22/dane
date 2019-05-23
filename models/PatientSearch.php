<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Patient;

/**
 * PatientSearch represents the model behind the search form of `app\models\Patient`.
 */
class PatientSearch extends Patient
{
    public $cityObj;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_number', 'name', 'surname', 'code', 'email', 'birth_date', 'phone', 'sex', 'cityObj'], 'safe'],
            [['id_Patient'], 'integer'],
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
        $query = Patient::find();

        $query->joinWith(['cityObj']);
		
		$patientsQuery = count($query);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
        ]);
        
        $dataProvider->sort->attributes['cityObj'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['cities.name' => SORT_ASC],
            'desc' => ['cities.name' => SORT_DESC],
        ];  

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_Patient' => $this->id_Patient,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])        
            ->andFilterWhere(['like', 'card_number', $this->card_number])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'cities.name', $this->cityObj])
            ->andFilterWhere(['like', 'birth_date', $this->birth_date]);

        return $dataProvider;
    }
}
