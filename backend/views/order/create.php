<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Order'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Order')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

