<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use yii\widgets\Pjax;
use common\models\Order;
use yii\helpers\Html;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php
                if (Yii::$app->user->identity->type == User::TYPE_MANAGE) {
                    $template = ['template' => '{refresh} '];
                } else {
                    $template = ['template' => '{refresh} {create}'];
                }

                ?>
                <?= Bar::widget($template) ?>

                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'order_sn',
                        [
                            'attribute' => 'admin_id',
                            'width' => '8%',
                            'value' => function ($model) {
                                return $model->adminUser->username;
                            }
                        ],
                        [
                            'attribute' => 'start_time',
                            'value'=> function($model){
                                    return  $model->start_time;   //主要通过此种方式实现
                                },
                        ],
                        [
                            'attribute' => 'end_time',
                            'value'=> function($model){
                                return  $model->end_time;   //主要通过此种方式实现
                            },
                        ],
                        [
                            'attribute' => 'user_id',
                            'value' => function ($model) {
                                if ($model->user_id == null) {
                                    return '';
                                } else {
                                    return $model->user->username;
                                }
                            }
                        ],
                        [
                            'attribute' => 'price',
                            'value' => function ($model) {
                                switch ($model->price) {
                                    case null:
                                        return "随喜";
                                        break;
                                    case 0.00:
                                        return "免费";
                                        break;
                                    default:
                                        return $model->price;
                                }
                            }
                        ],
                        [
                            'attribute' => 'pay',
                            'width' => '8%',
                        ],
                        [
                            'attribute' => 'status',
                            'width' => '8%',
                            'value' => function ($model) {

                                return Order::getStatusItems($model->status);
                            },
                            'filter' => Order::getStatusItems()
                        ],
                        [
                            'attribute' => 'pay_status',
                            'width' => '8%',
                            'value' => function ($model) {
                                if ($model->price === '0.00'||$model->price==null) {
                                    return '-';
                                }
                                return Order::getPayStatusItems($model->pay_status);
                            },
                            'filter' => Order::getPayStatusItems()
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => "{update} {delete}",
                            'width' => '10%',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    if ($model->status == Order::STATUS_WAIT_ORDER && Yii::$app->user->identity->type == User::TYPE_TEACHER) {
                                        return Html::a('<i class="fa fa-pencil"></i> ', $url, [
                                            'title' => Yii::t('app', 'Update'),
                                            'data-pjax' => '0',
                                            'class' => 'btn btn-white btn-sm',
                                        ]);
                                    }
                                },
                                'delete' => function ($url, $model, $key, $index, $gridView) {
                                    if ($model->status == Order::STATUS_WAIT_ORDER && Yii::$app->user->identity->type == User::TYPE_TEACHER) {
                                        return Html::a('<i class="glyphicon glyphicon-trash" aria-hidden="true"></i> ', $url, [
                                            'title' => Yii::t('app', 'Delete'),
                                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'class' => 'btn btn-white btn-sm',
                                        ]);
                                    }
                                },

                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
