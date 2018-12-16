<?php

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Order */
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
                    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'admin_id')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'year')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'month')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'day')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'time')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'status')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'delete')->textInput() ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>