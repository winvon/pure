<?php

namespace backend\controllers;

use Yii;
use backend\models\search\ActionSearch;
use backend\models\Action;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\ViewAction;
/**
 * ActionController implements the CRUD actions for Action model.
 */
class ActionController extends BackendController
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
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Action::className(),
            ],
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
            'view-layer' => [
                'class' => ViewAction::className(),
                'modelClass' => Action::className(),
            ],
        ];
    }
}
