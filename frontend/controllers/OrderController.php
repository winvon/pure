<?php

namespace frontend\controllers;

use Yii;
use frontend\models\search\OrderSearch;
use frontend\models\Order;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use yii\helpers\Json;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends FrontendController
{
    public function actions()
    {
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Order::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Order::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Order::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Order::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMyIndex()
    {
        return $this->render('myindex');
    }

    public function actionVue(){
        return $this->render('vue');
    }

    public function actionList()
    {
        $res = Order::row();
        $array = [
            'code' => 0,
            'msg' => '',
            'count' => Order::getNotOrderQuery()->count(),
            'data' => $res
        ];
        return $array;
    }

    public function actionMyList()
    {
        $res = Order::myRow();
        $array = [
            'code' => 0,
            'msg' => '',
            'count' => Order::getMyQuery()->count(),
            'data' => $res
        ];
        return $array;
    }

    /**
     * 预约
     * @return bool
     */
    public function actionOrder()
    {
        $param = Yii::$app->request->post();
        $model = Order::findOne(['id' => $param['id']]);
        $model->scenario='order';
        if ($model->status != Order::STATUS_WAIT_ORDER) {
            return false;
        }
        if ($model->price == null) {
            $model->price =(int)$param['price'];
        }
        $model->user_id = Yii::$app->user->id;
        $model->status = Order::STATUS_ORDER;
        if (!$model->save()) {
            var_dump($model->price);
            var_dump($model->getErrors());
            die();
        }
        return true;
    }

    /**
     * 预约
     * @return bool
     */
    public function actionCancel()
    {
        $param = Yii::$app->request->get();
        $model = Order::findOne(['id' => $param['id']]);
        $model->scenario='cancel';
        $model->status = Order::STATUS_WAIT_ORDER;
        $model->user_id = null;
        if ($model->price_copy==null) {
            $model->price=null;
        }
        if (!$model->save()) {
            var_dump($model->getErrors());
            die();
        }
        return true;
    }
}
