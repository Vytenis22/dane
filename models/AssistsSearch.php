<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Assists;

/**
 * AssistsSearch represents the model behind the search form of `app\models\Assists`.
 */
class AssistsSearch extends Assists
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_assist', 'fk_user'], 'integer'],
            [['reg_nr', 'start_time', 'end', 'info'], 'safe'],
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
        $query = Assists::find();

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
            'id_assist' => $this->id_assist,
            'fk_user' => $this->fk_user,
            'start_time' => $this->start_time,
            'end' => $this->end,
        ]);

        $query->andFilterWhere(['like', 'reg_nr', $this->reg_nr])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
