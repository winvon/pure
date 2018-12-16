<?php

namespace frontend\models;

use function GuzzleHttp\Psr7\str;
use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $admin_id 導師用戶id
 * @property string $user_id 預約用戶id
 * @property int $year
 * @property int $month
 * @property int $day
 * @property int $time
 * @property int $status 是否預約1否；2是；3取消；
 * @property int $delete
 */
class Order extends \common\models\Order
{

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'user_id' => 'User ID',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
            'time' => 'Time',
            'status' => 'Status',
            'delete' => 'Delete',
        ];
    }

    public static function getQuery()
    {
        $param = Yii::$app->request->get();
        $model = new self();
        $model->attributes = $param;
        $query = Order::find()
            ->andFilterWhere(['delete'=>Order::DELETE_NOT])
            ->andFilterWhere(['admin_id'=>$model->admin_id])
            ->andFilterWhere(['user_id'=>$model->user_id]);
        if (!empty($model->start_time)) {
            $day0=date("y-m-d",strtotime($model->start_time));
            $query->andFilterWhere(['>=','start_time',strtotime($day0) ]);
        }
        return $query;
    }

    public static function row()
    {
        $models = self::getNotOrderQuery()
            ->orderBy('start_time DESC')
            ->all();
        $array = [];
        foreach ($models as $model) {
            $array[] = self::asArray($model);
        }
        return $array;
    }

    public static function myRow()
    {
        $models = self::getMyQuery()
            ->orderBy('start_time DESC')
            ->all();
        $array = [];
        foreach ($models as $model) {
            $array[] = self::asArray($model);
        }
        return $array;
    }

    public static function getNotOrderQuery(){
        return self::getQuery()
            ->andWhere(['status'=>Order::STATUS_WAIT_ORDER]);
    }

    public static function getMyQuery(){
        return self::getQuery()
            ->andWhere(['user_id'=>Yii::$app->user->id]);
    }

    public static function asArray(Order $model)
    {
        switch ($model->price){
            case null:$price='随喜';break;
            case 0:$price='免费公益';break;
            default :$price=$model->price.'￥';break;
        }
        return [
            'id' =>(string)$model->id,
            'admin_name' =>@(string) $model->adminUser->username,
            'admin_telephone' =>@(string) $model->adminUser->telephone,
            'day' => date("Y-m-d", $model->start_time),
            'start_time' => date("H:s", $model->start_time),
            'end_time' => date("H:s", $model->end_time),
            'price' => $model->price,
            'pay' => $model->pay,
            'pay_status' => $model->pay_status,
            'status' => $model->status,
        ];
    }
}
