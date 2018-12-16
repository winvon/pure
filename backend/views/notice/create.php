<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Notice */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Notice'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Notice')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

