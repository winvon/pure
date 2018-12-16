<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\NoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =Yii::t('app','Notice')  ;
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget() ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
//                        ['class' => CheckboxColumn::className()],
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header'=>'编号',
                            'options'=>[
                                    'style'=>'width:5%',
                            ]
                        ],
                        'title',
                        [
                            'attribute' => 'deadline_at',
                            'format' => ['date', 'Y-M-d H:i']
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => ['date', 'Y-M-d H:i']
                        ],
                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
