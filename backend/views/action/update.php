<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Action */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Actions'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', '审核') . yii::t('app', 'Actions')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
