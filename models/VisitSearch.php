<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visit;
use app\models\Patient;

/**
 * VisitSearch represents the model behind the search form of `app\models\Visit`.
 */
class VisitSearch extends Visit
{
    public $user;
    public $patient;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'room', 'info', 'status', 'reg_nr', 'end', 'total_price', 'user', 'patient'], 'safe'],
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

        $query->joinWith(['user', 'patient', 'profile']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $dataProvider->sort->attributes['user'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];  
        
        $dataProvider->sort->attributes['patient'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patient.name' => SORT_ASC, 'patient.surname' => SORT_ASC],
            'desc' => ['patient.name' => SORT_DESC, 'patient.surname' => SORT_DESC],
        ];  

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_visit' => $this->id_visit,
        ]);

        $query->andFilterWhere(['like', 'room', $this->room])
            ->andFilterWhere(['like', 'start_time', $this->start_time])
            ->andFilterWhere(['like', 'end', $this->end])
            ->andFilterWhere(['like', 'total_price', $this->total_price])
            ->andFilterWhere(['like', 'reg_nr', $this->reg_nr])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['OR', 
                [ 'like' , 'patient.name' , $this->patient ],
                [ 'like' , 'patient.surname' , $this->patient ],
            ])
            ->andFilterWhere(['like', 'profile.name', $this->user]);

        return $dataProvider;
    }
}
