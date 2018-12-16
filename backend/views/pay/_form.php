<?php

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Pay */
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
                    <?= $form->field($model, 'order_id')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'pay_money')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'pay_img')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'pay_type')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'created_at')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>