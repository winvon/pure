<?php

use backend\widgets\ActiveForm;
use yii\helpers\Url;
use frontend\models\Action;
/* @var $this yii\web\View */
/* @var $model backend\models\Action */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Actions'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Actions')],
];
?>
<style>
    .checkbox, .radio {
        margin-top: 0px;
    }
    h2{
        color: #5a1d80;
    }
</style>
<div class="content" style="width: 700px;margin-left: 25%;margin-top: 100px">
    <h2 style="margin-left: 10%">阿卡西(Akashic)课程报名</h2>
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form',
            'style' => 'height:800px;'
        ],
        'fieldConfig' => [
//            'template' => "{input}{error}{hint}",
            'inputOptions' => [
                'class' => 'form-control ',
                'style' => ' width:300px;height:38px;border-radius:0 2px 2px 0;'
            ]]
    ]); ?>
    <div class="hr-line-dashed"></div>

    <?php
    if ($model->id != 0) {
        ?>
        <?= $form->field($model, 'num')->textInput(['readonly'=>true]) ?>
        <div class="hr-line-dashed"></div>
        <?php
    } ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'sex')->radioList(Action::getSexItem(), ['itemOptions' => ['disabled' => true]]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'changci')->dropDownList(Action::getChangCiItem(), ['prompt' => '请选择活动的场次']) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'comment')->textarea(['placeholder' => '备注内容', 'style'=>'width:300px;height:100px']) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'status')->dropDownList(Action::getStatusItem(), ['prompt' => '审核状态','disabled' => true]) ?>
    <div class="hr-line-dashed"></div>
    <?php
    if ($model->status == Action::STATUS_FAILED) {
        ?>
        <?= $form->field($model, 'reason')->textarea(['style'=>'width:300px;height:100px','readonly'=>true]);?>
        <div class="hr-line-dashed"></div>
        <?php
    }
    ?>


    <?= $form->defaultButtons() ?>
    <?php ActiveForm::end(); ?>
</div>
