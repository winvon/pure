<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\AdvisorTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advisor Types';
$this->params['breadcrumbs'][] = 'Advisor Types';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget() ?>
    <?php Pjax::begin(); ?>            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => CheckboxColumn::className()],
                        'id',
                        'type',
                        'delete',
                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
<?php Pjax::end(); ?>            </div>
        </div>
    </div>
</div>
