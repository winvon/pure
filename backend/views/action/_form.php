<?php

use backend\widgets\ActiveForm;
use backend\models\Action;
/* @var $this yii\web\View */
/* @var $model backend\models\Action */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <div class="hr-line-dashed"></div>
                    <?= $form->field($model, 'num')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'sex')->radioList(Action::getSexItem(), ['itemOptions' => ['disabled' => true]]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true,'readonly'=>true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'changci')->dropDownList(Action::getChangCiItem(),['readonly'=>true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'comment')->textarea(['maxlength' => true,'readonly'=>true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'status')->dropDownList(Action::getStatusItem()) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'reason')->textarea(['maxlength' => true, 'placeholder' => '审核拒绝,填写此项']) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>