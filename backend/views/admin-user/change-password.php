<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-25 11:15
 */
/**
 * @var $this yii\web\View
 * @var $model backend\models\User
 */
use backend\widgets\ActiveForm;

$this->title = "Admin";
?>
<style>

    .input-group {
        width: 66.6667%;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal col-sm-offset-2'
                    ],
                    'fieldConfig' => [
                        'inputOptions' => [
                            'class' => 'col-sm-8 ',
                            'style' => 'height:38px;margin-bottom:20px'
                        ]
                    ],
                ]); ?>
                <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => 512]) ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 512]) ?>
                <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 512]) ?>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>