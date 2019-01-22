<?php

use backend\widgets\ActiveForm;
use frontend\models\Action;

/* @var $this yii\web\View */
/* @var $model backend\models\Action */
/* @var $form backend\widgets\ActiveForm */
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
    <h2  ="margin-left: 10%">阿卡西(Akashic)课程报名</h2>
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
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?php $model->sex = 0 ?>
    <?= $form->field($model, 'sex')->radioList(Action::getSexItem()) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'changci')->dropDownList(Action::getChangCiItem(), ['prompt' => '请选择活动的场次']) ?>
    <div class="hr-line-dashed"></div>

    <?= $form->field($model, 'comment')->textarea(['placeholder' => '备注内容', 'style'=>'width:300px;height:100px']) ?>
    <div class="hr-line-dashed"></div>

    <?php
    if ($model->status == 2) {
        ?>
        <?= $form->field($model, 'reason')->dropDownList(Action::getChangCiItem(), ['prompt' => '请选择活动的场次']) ?>
        <div class="hr-line-dashed"></div>
        <?php
    }
    ?>
    <div class="form-group">
        <div class="col-sm-' . $options['size'] . ' col-sm-offset-2">
            <button style="width: 60px;height: 36px" class="btn btn-primary" type="submit"><?=Yii::t('app', '报名')?> </button>
            <button style="width: 60px;height: 36px" class=" btn btn-info" type="reset"><?= Yii::t('app', 'Reset')?></button>
        </div>
    </div>
    <div>
        <p>报名流程:</p>
        <p>1.填写资料</p>
        <p>2.缴报名费</p>
        <p>3.邮件或者电话告知负责人已缴费</p>
        <p>-4.负责人通知参与课程</p>
        <p style="font-size: 14px">资料填写请使用真实有效的信息,便于通讯链接</p>
    </div>
    <?php ActiveForm::end(); ?>

</div>