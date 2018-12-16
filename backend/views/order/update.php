<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Orders'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Orders')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
