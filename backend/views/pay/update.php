<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Pay */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Pay'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Pay')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
