<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

use common\libs\Constants;
use yii\helpers\Html;
use common\models\Pay;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pays');
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
                            'class' => 'yii\grid\SerialColumn',
                            'header' => '编号',
                            'options' => [
                                'style' => 'width:5%'
                            ],
                        ],
                        [
                            'attribute' => 'order_id',
                            'value' => function ($model) {
                                return $model->order->order_sn;
                            }
                        ],
                        [
                            'attribute' => 'pay_money',
                            'value' => function ($model) {
                                return $model->pay_money . '￥';
                            }
                        ],
                        [
                            'attribute' => 'pay_img',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                if (empty($model->pay_img)) {
                                    $num = Constants::YesNo_No;
                                } else {
                                    $num = Constants::YesNo_Yes;
                                }
                                return Html::a(Constants::getYesNoItems($num), $model->pay_img ? $model->pay_img : 'javascript:void(0)', [
                                    'img' => $model->pay_img ? $model->pay_img : '',
                                    'class' => 'thumbImg',
                                    'target' => '_blank',
                                ]);
                            },
                            'filter' => Constants::getYesNoItems(),
                            'options' => [
                                'style' => 'width:7%',
                            ]
                        ],
                        [
                            'attribute' => 'pay_type',
                            'value' => function ($model) {
                                return Pay::getPayTypeItems($model->pay_type);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return Pay::getStatusItems($model->status);
                            }
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => function ($model) {
                                return date('Y-m-d H:i', $model->created_at);
                            }
                        ],

                        [
                            'class' => ActionColumn::className(),
                            'template' => '{check-pay-yes} {check-pay-no} ',
                            'buttons' => [
                                'check-pay-yes' => function ($url, $model, $key) {
                                    if ($model->status == Pay::STATUS_CONFIRM && Yii::$app->user->identity->type == User::TYPE_MANAGE) {
                                        return Html::a('<i class="glyphicon glyphicon-ok" style="color: green" aria-hidden="true"></i> ', $url, [
                                            'title' => Yii::t('app', '审核通过这次的线下支付'),
                                            'data-confirm' => Yii::t('app', '您确认通过本次线下支付吗?'),
                                            'data-method' => 'post',
                                            'data' => ['id' => $model->id],
                                            'data-pjax' => '0',
                                            'class' => 'btn btn-white btn-sm',
                                        ]);
                                    }
                                },
                                'check-pay-no' => function ($url, $model, $key) {
                                    if ($model->status == Pay::STATUS_CONFIRM && Yii::$app->user->identity->type == User::TYPE_MANAGE) {
                                        return Html::a('<i class="glyphicon glyphicon-remove" style="color: red" aria-hidden="true"></i> ', $url, [
                                            'title' => Yii::t('app', '审核不通过这次的线下支付'),
                                            'data-confirm' => Yii::t('app', '您确认不通过本次线下支付吗??'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                            'class' => 'btn btn-white btn-sm',
                                        ]);
                                    }
                                },
                            ],
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function showImg() {
        t = setTimeout(function () {
        }, 200);
        var url = $(this).attr('img');
        if (url.length == 0) {
            layer.tips('<?=yii::t('app', 'No picture')?>', $(this));
        } else {
            layer.tips('<img style="max-width: 100px;max-height: 60px" src=' + url + '>', $(this));
        }
    }
    $(document).ready(function () {
        var t;
        $('table tr td a.thumbImg').hover(showImg, function () {
            clearTimeout(t);
        });
    });
    var container = $('#pjax');
    container.on('pjax:send', function (args) {
        layer.load(2);
    });
    container.on('pjax:complete', function (args) {
        layer.closeAll('loading');
        $('table tr td a.thumbImg').bind('mouseover mouseout', showImg);
        $("input.sort").bind('blur', indexSort);
    });
</script>