<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\Action */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Action'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Action')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

