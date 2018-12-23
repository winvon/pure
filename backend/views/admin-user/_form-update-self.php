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
use backend\models\AdminUser;
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
                <?= $form->field($model, 'username')->textInput(['maxlength' => 64, 'disabled' => 'disabled']) ?>
                <?= $form->field($model, 'nickname')->textInput(['maxlength' => 64, [
                    'placeholder' => '前台页面显示的称呼',]]) ?>
                <?= $form->field($model, 'avatar')->imgInput([
                    'width' => '150px',
                    'baseUrl' => yii::$app->params['admin']['url'],
                ]) ?>
                <?= $form->field($model, 'telephone')->textInput(['maxlength' => 64]) ?>
                <?= $form->field($model, 'realname')->textInput(['maxlength' => 64, [
                    'placeholder' => '真实姓名',]]) ?>
                <?= $form->field($model, 'card_number')->textInput(['maxlength' => 64, [
                    'placeholder' => '身份证件号码',]]) ?>
                <?= $form->field($model, 'card_img')->imgInput([
                    'value' => $model->card_img,
                    'width' => '150px',
                    'baseUrl' => yii::$app->params['admin']['url'],
                ]) ?>
                <?= $form->field($model, 'current_address')->textInput(['maxlength' => 64, [
                    'placeholder' => '当前住居地址,以收取邮件',]]) ?>
                <?= $form->field($model, 'certificate')->imgInput([
                    'width' => '150px',
                    'baseUrl' => yii::$app->params['admin']['url'],
                ]) ?>
                <?= $form->field($model, 'bank')->textInput(['maxlength' => 64, [
                    'placeholder' => '收款银行',]]) ?>
                <?= $form->field($model, 'bank_account')->textInput(['maxlength' => 64, [
                    'placeholder' => '收款账号',]]) ?>

                <?= $form->field($model, 'introduce')->textArea([
                    'style' => 'height:150px',
                    'placeholder' => '自我介绍一下吧!',
                ]) ?>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    <?php
    if (Yii::$app->user->identity->status == AdminUser::STATUS_ACTIVE) {
        echo "layer.msg('资料成功后，系统功能将暂停使用，待管理员审核后资料成功后开启！',{time:5000})";
    }
    ?>
</script>