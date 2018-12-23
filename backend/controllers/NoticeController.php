<?php

namespace backend\controllers;

use backend\actions\ViewAction;
use Yii;
use backend\models\search\NoticeSearch;
use backend\models\Notice;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class NoticeController extends BackendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                        $searchModel = new NoticeSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Notice::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Notice::className(),
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'modelClass' => Notice::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Notice::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Notice::className(),
            ],
        ];
    }
}
