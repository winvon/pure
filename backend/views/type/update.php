<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Type */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Type'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Type')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
