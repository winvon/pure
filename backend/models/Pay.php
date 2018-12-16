<?php

namespace backend\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "{{%pay}}".
 *
 * @property int $id
 * @property int $order_id
 * @property string $pay_money
 * @property string $pay_img
 * @property int $pay_type 1;线下;2微信支付
 * @property int $created_at
 */
class Pay extends \common\models\Pay
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '预约单号',
            'pay_money' => '支付金额',
            'pay_img' => '支付凭证',
            'pay_type' => '支付方式',
            'status' => '支付状态',
            'created_at' => '提交时间',
        ];
    }

    public static function checkUser($id)
    {
        if (Yii::$app->user->identity->type==User::TYPE_MANAGE) {
            return true;
        }
        return false;
        
        $user_id = Yii::$app->user->id;
        $model = self::findOne(['id' => $id]);
        $_user_id = $model->order->admin_id;
        if ($user_id != $_user_id) {
            return false;
        }
        return true;
    }


    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public static function statusYes($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = self::findOne(['id' => $id]);
            $model->status = self::STATUS_CONFIRMED;
            $model->save();
            $order = $model->order;
            $order->scenario = 'pay';
            $order->updateCounters(['pay' => $model->pay_money]);
            if ($order->pay >= $order->price) {
                $order->pay_status = Order::PAY_STATUS_PAYED;
            } else {
                $order->pay_status = Order::PAY_STATUS_PAYING;
            }
            $order->save();
            $transaction->commit();
            return true;
        } catch (Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

    }
}
