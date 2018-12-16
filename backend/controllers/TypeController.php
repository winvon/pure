<?php

namespace backend\controllers;

use Yii;
use backend\models\search\TypeSearch;
use common\models\Type;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
/**
 * TypeController implements the CRUD actions for Type model.
 */
class TypeController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    
                        $searchModel = new TypeSearch();
                        $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Type::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Type::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Type::className(),
            ],
            'sort' => [
                'class' => SortAction::className(),
                'modelClass' => Type::className(),
            ],
        ];
    }
}
