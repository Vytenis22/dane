<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vacations;

/**
 * VacationsSearch represents the model behind the search form of `app\models\Vacations`.
 */
class VacationsSearch extends Vacations
{
    public $fkUser;
    public $fkAdmin;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_user', 'fk_admin'], 'integer'],
            [['begin', 'end', 'status', 'fkUser', 'fkAdmin', 'created_at', 'confirmed_at'], 'safe'],
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
    public function search($params, $id = null)
    {
        if ($id != null)
        {
            $query = Vacations::find()->where(['fk_user' => $id]);
        } else {
            $query = Vacations::find();
        }        

        $query->joinWith(['fkUser', 'fkAdmin as us2', 'profile']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $dataProvider->sort->attributes['fkUser'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['fkAdmin'] = [
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
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'confirmed_at', $this->confirmed_at])
            ->andFilterWhere(['like', 'user.username', $this->fkUser])
            ->andFilterWhere(['like', 'profile.name', $this->fkAdmin]);

        return $dataProvider;
    }
}
