<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdvisorType;

/**
 * AdvisorTypeSearch represents the model behind the search form about `backend\models\AdvisorType`.
 */
class AdvisorTypeSearch extends AdvisorType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id','delete'], 'integer'],
            [[ 'type'], 'string'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = AdvisorType::find();

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
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'type' => $this->type,
            'delete' => $this->delete,
        ]);

        return $dataProvider;
    }
}
