<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TreatmentPlans;

/**
 * TreatmentPlansSearch represents the model behind the search form of `app\models\TreatmentPlans`.
 */
class TreatmentPlansSearch extends TreatmentPlans
{
    public $user;
    public $patient;
    public $patientFullName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['begin', 'end', 'info', 'patientFullName', 'patient', 'user'], 'safe'],
            [['id', 'fk_patient'], 'integer'],
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
        $query = TreatmentPlans::find();

        $query->joinWith(['patient']);    

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $dataProvider->sort->attributes['patient'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patient.name' => SORT_ASC],
            'desc' => ['patient.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'begin' => $this->begin,
            'end' => $this->end,
            //'fk_patient' => $this->fk_patient,
        ]);

        $query->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'patient.name', $this->patient]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchFiltered($params, $id_Patient)
    {
        $query = TreatmentPlans::find()
        ->where(['fk_patient' => $id_Patient]);

        $query->joinWith(['patient', 'user', 'profile']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            /*
            'sort' => [
                'attributes' => [
                    'patient.name' => [
                        'asc' => ['patient.name' => SORT_ASC, 'patient.surname' => SORT_DESC],
                        'desc' => ['patient.name' => SORT_DESC, 'patient.surname' => SORT_ASC],
                    ],
                    'patient.surname',
                ],
                'defaultOrder'=> ['patient.surname' => SORT_DESC]
            ],
            */
        ]);

        $dataProvider->sort->attributes['patient'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['patient.name' => SORT_ASC],
            'desc' => ['patient.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['user'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'begin' => $this->begin,
            'end' => $this->end,
            //'fk_patient' => $this->fk_patient,
        ]);

        $query->andFilterWhere(['like', 'info', $this->info])
            //->andFilterWhere(['like', 'patient.name', $this->patient])
            ->andFilterWhere(['like', 'Concat(patient.name, " ", patient.surname)', $this->patientFullName])
            //->andFilterWhere ( [ 'OR' ,
            //    [ 'like' , 'patient.name' , $this->patient ],
            //    [ 'like' , 'patient.surname' , $this->patient ],
            //] )
            ->andFilterWhere(['like', 'profile.name', $this->user]);

        return $dataProvider;
    }
}
