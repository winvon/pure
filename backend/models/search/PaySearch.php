<?php

namespace backend\models\search;

use backend\models\Order;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Pay;

/**
 * PaySearch represents the model behind the search form about `backend\models\Pay`.
 */
class PaySearch extends Pay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'pay_type', 'created_at'], 'integer'],
            [['pay_money'], 'number'],
            [['pay_img'], 'safe'],
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
        $query = Pay::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $user=Yii::$app->user->identity;
        if ($user->type==1){
            $order_ids=Order::find()
                ->where(['admin_id'=>$user->id])
                ->column();
            $query->where(["in",'id',$order_ids]);
        }

//        $query->leftJoin('ab_order','ab_order.id=ab_pay.order_id');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'pay_money' => $this->pay_money,
            'pay_type' => $this->pay_type,
            'created_at' => $this->created_at,
        ]);
        $query->orderBy('created_at DESC');
        return $dataProvider;
    }
}
