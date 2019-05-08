<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recipes;
use app\models\Patient;

/**
 * RecipesSearch represents the model behind the search form of `app\models\Recipes`.
 */
class RecipesSearch extends Recipes
{
    public $user;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_patient', 'fk_user'], 'integer'],
            [['create_at', 'expire', 'rp', 'N', 'S', 'user'], 'safe'],
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
        $query = Recipes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'create_at' => $this->create_at,
            'expire' => $this->expire,
            'fk_patient' => $this->fk_patient,
            'fk_user' => $this->fk_user,
        ]);

        $query->andFilterWhere(['like', 'rp', $this->rp])
            ->andFilterWhere(['like', 'N', $this->N])
            ->andFilterWhere(['like', 'S', $this->S]);

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
        $query = Recipes::find()
        ->where(['fk_patient' => $id_Patient]);

        $query->joinWith(['user', 'profile']);

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
            'create_at' => $this->create_at,
            'expire' => $this->expire,
            //'fk_patient' => $this->fk_patient,
        ]);

        $query->andFilterWhere(['like', 'rp', $this->rp])
            ->andFilterWhere(['like', 'N', $this->N])
            ->andFilterWhere(['like', 'S', $this->S])
            ->andFilterWhere(['like', 'profile.name', $this->user]);

        return $dataProvider;
    }
}
