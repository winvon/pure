<?php

namespace backend\controllers;

use Yii;
use backend\models\search\OrderSearch;
use backend\models\Order;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends BackendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                        $searchModel = new OrderSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Order::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Order::className(),
            ],
//            'delete' => [
//                'class' => DeleteAction::className(),
//                'modelClass' => Order::className(),
//            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Order::className(),
            ],
        ];
    }

    public  function actionDelete(){
        if (Order::deletes()) {
            return ['code'=>200];
        }
        return ['code'=>500,'message'=>'已预约,操作失败'];
    }
}
