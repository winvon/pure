<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\AdvisorType */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Advisor Type'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Advisor Type')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

