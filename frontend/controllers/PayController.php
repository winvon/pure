<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/11/29
 * Time: 21:44
 */

namespace frontend\controllers;

use common\models\Order;
use frontend\models\Pay;
use Guzzle\Service\Command\OperationResponseParser;
use Yii;
use yii\db\Exception;

class PayController extends FrontendController
{
    public function actionPayInline()
    {
        $data = Yii::$app->request->post();
        $transcation = Yii::$app->db->beginTransaction();
        try {
            $model = new Pay();
            $model->order_id = $data['id'];
            $model->pay_money = $data['pay'];
            $model->pay_type = Pay::PAY_TYPE_INLINE;
            $model->pay_img = $data['img'];
            $model->save();
            $o_m = Order::findOne(['id' => $data["id"]]);
            $o_m->pay_status = Order::PAY_STATUS_PAYING;
            $o_m->save();
//            $o_m->updateCounters(['pay'=>$data['pay']]);
        } catch (Exception $e) {
            throw  $e;
        };
        return true;
    }

    public function actionGetPayInfo()
    {
        $order_id = Yii::$app->request->get('order_id');
        return $models = Pay::find()->where(['order_id' => $order_id])->all();
    }

}