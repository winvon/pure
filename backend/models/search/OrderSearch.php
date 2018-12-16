<?php

namespace backend\models\search;

use backend\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'user_id', 'start_time', 'end_time','price', 'status','pay_status', 'delete'], 'integer'],
            [['order_sn', ], 'string'],
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
        $query = Order::find();
        $user=Yii::$app->user->identity;
        if ($user->type==User::TYPE_TEACHER){
            $query->where(["admin_id"=>$user->id]);
        }
        $query->andFilterWhere(['delete'=>Order::DELETE_NOT]);

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
            'user_id' => $this->user_id,
            'pay_status' => $this->pay_status,
            'status' => $this->status,
            'price' => $this->price,
            'delete' => $this->delete,
        ])->andFilterWhere(['like','order_sn',$this->order_sn]);
        $query->orderBy('created_at DESC');
        return $dataProvider;
    }
}
