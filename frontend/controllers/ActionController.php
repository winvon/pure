<?php

namespace frontend\controllers;

use Yii;
use backend\models\search\ActionSearch;
use backend\models\Action;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
/**
 * ActionController implements the CRUD actions for Action model.
 */
class ActionController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new ActionSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
//            'create' => [
//                'class' => CreateAction::className(),
//                'modelClass' => Action::className(),
//            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Action::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Action::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Action::className(),
            ],
        ];
    }

    public function actionCreate(){
        if (Yii::$app->user->isGuest){
            yii::$app->getSession()->setFlash('error', yii::t('app', '请先登录！'));
            return $this->redirect(['site/login']);
        }
        $model=Action::find()->where(['uid'=>Yii::$app->user->id])->one();
        if (Yii::$app->request->get('lo')==1&&$model!=null){
            return $this->redirect(['update','id'=>$model->id]);
        }
        if ($model!=null){
            yii::$app->getSession()->setFlash('error', yii::t('app', '您已报名！'));
            return $this->redirect(['update','id'=>$model->id]);
        }
        $model=new Action();
        if (yii::$app->getRequest()->getIsPost()) {
            if ($model->load(yii::$app->getRequest()->post()) && $model->save()) {
                yii::$app->getSession()->setFlash('success', yii::t('app', '活动报名成功,可前往我的活动查看'));

                return $this->redirect(['update','id'=>$model->id]);
            } else {
                $errorReasons = $model->getErrors();
                $err = '';
                foreach ($errorReasons as $errorReason) {
                    $err .= $errorReason[0] . '<br>';
                }
                $err = rtrim($err, '<br>');
                yii::$app->getSession()->setFlash('error', $err);
            }
        }
         return $this->render('create',['model'=>$model]);
    }
}
