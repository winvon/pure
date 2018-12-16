<?php

namespace backend\controllers;

use Yii;
use backend\models\search\PaySearch;
use backend\models\Pay;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;

/**
 * PayController implements the CRUD actions for Pay model.
 */
class PayController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function () {

                    $searchModel = new PaySearch();
                    $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Pay::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Pay::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Pay::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Pay::className(),
            ],
        ];
    }


    public function actionCheckPayYes()
    {
        $id=Yii::$app->request->get('id');
        if (!Pay::checkUser($id)) {
            return true;
        }
        if (Pay::statusYes($id)!==true){
            return true;
            Yii::$app->session->setFlash('success','成功');
        }
        return false;
        Yii::$app->session->setFlash('error','失败');
    }

    public function actionCheckPayNo()
    {
        $id=Yii::$app->request->get('id');
        if (!Pay::checkUser($id)) {
            return true;
        }
        $model= Pay::findOne(['id'=>$id]);
        $model->status=Pay::STATUS_NOT;
        if ($model->save()) {
            return true;
        }
        return false;
    }
}
