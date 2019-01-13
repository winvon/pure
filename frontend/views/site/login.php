<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/* @var $this yii\web\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
\frontend\assets\IndexAsset::register($this);
?>

<?= $this->render('/site/header') ?>
<style>
    .login-box{
        background-color: rgba(255,255,255,0.1)
    }
</style>
<div class="content-wrap">
    <div class="login-box">
        <form class="layui-form layui-form-pane" action="<?= Url::to(['site/login']) ?>" method="post">
            <h1 style="text-align: center;padding-top:20px ;margin-bottom:20px;"><?= yii::t('frontend', 'Log in') ?></h1>
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-username"></i></label>
                <div class="layui-input-inline">
                    <input type="text" name="LoginForm[username]" lay-verify="required" placeholder="用户名"
                           autocomplete="off" class="layui-input">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                <div class="layui-input-inline">
                    <input type="password" name="LoginForm[password]" placeholder="密码" autocomplete="off"
                           class="layui-input">
                </div>
            </div>
            <?php if ($model->password != null || $model->username != null) { ?>
                <div class="layui-form-item">
                    <span class="login_error" style="color: red">密码或者账号错误</span>
                </div>
            <?php } ?>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button style="width: 235px" type="submit" class="layui-btn layui-btn-normal" lay-submit=""
                            lay-filter="demo1"><?= Yii::t('frontend', 'Log in') ?>
                    </button>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a style="font-size: 12px;margin-left: 180px" href="<?= Url::to(['site/forget-password']) ?>"> <?= Yii::t('frontend', '忘记密码') ?></a>
                </div>
            </div>
        </form>
    </div>
</div>