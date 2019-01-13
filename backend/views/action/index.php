<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use backend\models\Action;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Actions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget(['template' => '{refresh}']) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                           'attribute' => 'num',
                           'width'=>'13%'
                        ],
                        [
                            'attribute' => 'name',
                            'width'=>'7%'],
                        [
                            'attribute' => 'sex',
                            'width'=>'6%',
                            'value' => function ($model) {
                                return Action::getSexItem()[$model->sex];
                            },
                            'filter' =>Action::getSexItem()
                        ],
                        'email:email',
                        'mobile',
                        [
                            'attribute' => 'changci',
                            'value' => function ($model) {
                                return Action::getChangCiItem()[$model->changci];
                            },
                            'filter' =>Action::getChangCiItem()
                        ],

                        [
                            'attribute' => 'status',
                            'width'=>'6%',
                            'value' => function ($model) {
                                return Action::getStatusItem()[$model->status];
                            },
                            'filter' =>Action::getStatusItem()
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => function ($model) {
                                return date('Y-m-d',$model->created_at);
                            }
                        ],

                        ['class' => ActionColumn::className(),
                            'template' => '{view-layer} {update}',
                            'buttons' => [
                                  'update'=>function($url, $model, $key, $index, $gridView){
                                      return \yii\helpers\Html::a('<i class="fa fa-pencil"></i> ', $url, [
                                          'title' => Yii::t('app', '审核'),
                                          'data-pjax' => '0',
                                          'class' => 'btn btn-white btn-sm',
                                      ]);
                                  }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
