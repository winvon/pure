<?php

namespace backend\controllers;

use Yii;
use backend\models\search\AdvisorTypeSearch;
use backend\models\AdvisorType;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
/**
 * AdvisorTypeController implements the CRUD actions for AdvisorType model.
 */
class AdvisorTypeController extends BackendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new AdvisorTypeSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => AdvisorType::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => AdvisorType::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => AdvisorType::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => AdvisorType::className(),
            ],
        ];
    }
}
