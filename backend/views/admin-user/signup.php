<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

/**
 * @var $this yii\web\View
 * @var $model \common\models\LoginForm
 */

use backend\assets\AppAsset;
use yii\helpers\Html;
use backend\widgets\ActiveForm;
use yii\helpers\Url;
use yii\captcha\Captcha;

AppAsset::register($this);
$this->title = yii::t('app', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= $this->render("/widgets/_language-js") ?>
    <link rel="stylesheet" href="/static/tel-input/build/css/intlTelInput.css">
    <style>
        div.form-group div.help-block {
            position: absolute;
            left: 305px;
            width: 170px;
            text-align: left;
        }

        .form-horizontal .form-group {
            width: 300px;
            margin-left: 0px;
        }

        .wrapper .middle-box {
            margin-top: 0px;
        }

        .wrapper-content {
            padding: 0px;
        }

        img#loginform-captcha-image {
            position: absolute;
            top: 2px;
            right: 1px;
        }
    </style>
</head>
<body class="gray-bg">
<?php $this->beginBody() ?>
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <?= $this->render('/widgets/_flash') ?>
    <div>
        <div>
            <h2 class="logo-name">PL</h2>
        </div>
        <h3><?= yii::t('app', 'Welcome to') ?></h3>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'inputOptions' => [
                    'class' => 'form-control ',
                    'style' => 'height:38px;border-radius:2px'
                ],
                'errorOptions' => [
                    'style' => 'top:4px;'
                ]
            ],]);?>
        <?= $form->field($model, 'username',
            ['template' => "<div style='position:relative'>{input} {error} {hint}</div>"])
            ->textInput(['autofocus' => true, 'placeholder' => yii::t("app", "Username")]) ?>

        <?= $form->field($model, 'password', ['template' => "<div style='position:relative'>{input} {error} {hint}</div>"])
            ->passwordInput(['placeholder' => yii::t("app", "Password")]) ?>

        <?= $form->field($model, 'telephone', [
            'template' => "<div style='position:relative'>{input} {error} {hint}</div>",
        ])->textInput(['placeholder' => yii::t("app", "Telephone"),'style'=>'width:300px;height:38px']) ?>

        <?= $form->field($model, 'code', ['template' => "<div style='position:relative' class='form-group'><div  class='input-group'>{input}<a class='input-group-addon getcode'>获取验证码</a>\n{error}\n{hint}</div></div>"])
            ->textInput(['placeholder' => yii::t("app", "Telephone Code")]) ?>

        <?= Html::submitButton(yii::t("app", "Sign up"), [
            'class' => 'btn btn-primary block full-width m-b',
            'name' => 'login-button'
        ]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<!--逻辑功能代码 -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/static/tel-input/build/js/intlTelInput.js"></script>
<script>
    $("#user-telephone").intlTelInput({
        initialCountry: "cn",
    });
    /*获取验证码*/
    $('.input-group').on('click', '.getcode', function () {
        getCode('.getcode')
    });
    var jishi = 1;
    function getCode(obj) {
        if (checkPhone()) {//验证手机号码
            if (jishi == 1) {
                $.ajax({
                    type: "POST",
                    url: '<?=Url::to(['public/send-mobile-code'])?>',
                    data: {_csrf_backend:'<?=Yii::$app->request->getCsrfToken()?>',telephone:$("input[name='User[telephone]']").val(),district:$(".selected-flag")[0].title},
                    success: function (result) {
                        if (result) {

                        }
                        else {

                        }
                    },
                    error: function (result) {

                    }
                });
                settime(obj);//倒计时
            }
        }
        else {
            $("input[name='Tel']").focus();
            return;
        }
    }

    //验证手机号码
    function checkPhone() {
        var phone = $("input[name='User[telephone]']").val();
        var pattern = /^1[0-9]{10}$/;
        if (phone.length == 0) {
            layer.msg('请输入手机号码');
            return false;
        }
//        if (!pattern.test(phone)) {
//            layer.msg('手机号格式错误');
//            return false;
//        }
        var ct = checkTel(phone);
        if (ct == true) {
            layer.msg('手机号格已被注册');
            return false;
        }

        return true;
    }

    var countdown = 60;

    function checkTel(phone) {
        var res = true;
        $.ajaxSetup({
            async: false //取消异步
        });
        $.get('<?=Url::to(["user/check-register"])?>', {telephone: phone}, function (data) {
            res = data;
        });
        return res;
    }

    function settime(obj) {
        if (countdown == 0) {
            $(obj).replaceWith("<a class='input-group-addon getcode'>获取验证码</a>");
            $(obj).text("获取验证码");
            countdown = 60;
            jishi = 1;
            return;
        } else {
            $(obj).replaceWith("<div class='input-group-addon getcode'>获取验证码</div>");
            $(obj).text(countdown + 's' + '后重发');
            countdown--;
            jishi = 0;
        }
        setTimeout(function () {
            settime(obj)
        }, 1000)
    }

</script>

