<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visit;

/**
 * VisitSearch represents the model behind the search form of `app\models\Visit`.
 */
class VisitSearch extends Visit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'room', 'info', 'status'], 'safe'],
            [['total_price'], 'number'],
            [['id_visit', 'fk_user', 'fk_patient'], 'integer'],
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
        $query = Visit::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'start_time' => $this->start_time,
            'total_price' => $this->total_price,
            'id_visit' => $this->id_visit,
            'fk_user' => $this->fk_user,
            'fk_patient' => $this->fk_patient,
        ]);

        $query->andFilterWhere(['like', 'room', $this->room])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
