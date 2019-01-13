<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model frontend\models\form\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = yii::t('frontend', '修改密码') . '-' . yii::$app->feehi->website_title;
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('/site/header') ?>

<link rel="stylesheet" href="/static/tel-input/build/css/intlTelInput.css">
<style>
    .layui-form-label {
        width: 45px;
        padding: 8px 15px;
        height: 38px;
        line-height: 20px;
        border: #bec4c4;
        border-width: 1px;
        border-style: solid;
        border-right: none;
        border-radius: 2px 0 0 2px;
        text-align: center;
        background-color: #FBFBFB;
        white-space: nowrap;
        text-overflow: ellipsis;
        box-sizing: border-box;
    }

    .input-group {
        display: inline-block;
    }

    .getcode {
        height: 37.5px;
        width: 96px;
        border-left: none;
        border-radius: 0 2px 2px 0
    }
    .intl-tel-input .country-list{
        z-index: 100;
    }
    .login-box{
        background-color: rgba(255,255,255,0.1)
    }
</style>
<div class="content-wrap">
    <div class="login-box">
        <h1 style="text-align: center;padding-top:20px ;margin-bottom:20px;"><?= yii::t('frontend', '修改密码') ?></h1>

        <?php $form = ActiveForm::begin(
            [
                'id' => 'form-signup',
                'options' => [
                    'class' => 'form-horizontal',
                    'style' => 'margin-left:80px'
                ],
                'fieldConfig' => [
                    'template' => "{input}{error}{hint}",
                    'inputOptions' => [
                        'class' => 'form-control ',
                        'style' => ' width:190px;height:38px;border-radius:0 2px 2px 0;'
                    ],
                    'labelOptions' => [
                        'style' => 'float:left;margin-top:10px;'
                    ],
                    'errorOptions' => [
                        'style' => 'margin-left: 45px'
                    ],
                ],
            ]);
        ?>
        <label class='label'>旧密码</label>
        <?= $form->field($model, 'old_password', [
            'template' => "<label class='layui-form-label'><i class='layui-icon layui-icon-password'></i></label>{input}{error}{hint}"])->passwordInput() ?>
        <label class='label'>新密码</label>
        <?= $form->field($model, 'password', [
            'template' => '<label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>{input}{error}{hint}'
        ])->passwordInput() ?>
        <label class='label'>重复密码</label>
        <?= $form->field($model, 'repassword', [
            'template' => '<label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>{input}{error}{hint}'
        ])->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton(yii::t('frontend', '提交'),
                [
                    'class' => 'layui-btn layui-btn-normal',
                    'style' => 'width: 235px',
                    'name' => 'signup-button'
                ]
            ) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>