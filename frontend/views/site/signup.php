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

$this->title = yii::t('frontend', 'Sign up') . '-' . yii::$app->feehi->website_title;
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
</style>
<div class="content-wrap">
    <div class="login-box">
        <h1 style="text-align: center;padding-top:20px ;margin-bottom:20px;"><?= yii::t('frontend', 'Sign up') ?></h1>

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
        <?= $form->field($model, 'username', [
            'template' => "<label class='layui-form-label'><i class='layui-icon layui-icon-username'></i></label>{input}{error}{hint}"])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password', [
            'template' => '<label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>{input}{error}{hint}'
        ])->passwordInput() ?>

        <?= $form->field($model, 'telephone', [
            'template' => '<label class="layui-form-label"><i class="layui-icon layui-icon-cellphone"></i></label>{input}{error}{hint}'
        ])->textInput(['type'=>'tel']) ?>

        <?= $form->field($model, 'code', [
                'template' => "<div style='position:relative' class='form-group'><div  class='input-group' >{input}<a class='input-group-addon getcode' href='#' style=''>获取验证码</a>\n{error}\n{hint}</div></div>"]
        )->textInput([
            'placeholder' => yii::t("app", "Telephone Code"),
            'style' => 'width:139px;height:38px;;border-radius:2px 0 0 2px'
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton(yii::t('frontend', 'Signup'),
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
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/static/tel-input/build/js/intlTelInput.js"></script>
<script>
    $("#signupform-telephone").intlTelInput({
        initialCountry: "cn",
    });

    /*获取验证码*/
    $('.input-group').on('click', '.getcode', function () {
        getCode('.getcode')
    });
    var jishi = 1;
    function getCode(obj) {
//        var exten=$(".selected-flag")[0].title.split(":")[1].trim();
        if (checkPhone() == true) {//验证手机号码
            if (jishi == 1) {
                $.ajax({
                    type: "POST",
                    url: '<?=Url::to(['public/send-mobile-code'])?>',
                    data: {telephone:$("input[name='SignupForm[telephone]']").val(),district:$(".selected-flag")[0].title},
                    success: function (result) {
                        if (result != true) {

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
        var phone = $("input[name='SignupForm[telephone]").val();
        var pattern = /^1[0-9]{10}$/;
        if (phone.length == 0) {
            layer.msg('请输入手机号码');
            return false;
        }
//        if (!pattern.test(phone)) {
//            layer.msg('手机号格式错误');
//            return false;
//        }
        var ct =checkTel(phone);

        if (ct==true) {
            layer.msg('手机号格已被注册');
            return false;
        }
        return true;
    };


    function checkTel(phone) {
        $.ajaxSetup({
            async : false //取消异步
        });
        var res=true;
        $.get('<?=Url::to(['author/check-register'])?>', {telephone: phone}, function (data) {
            res=data;
        });
        return res;
    };

    var countdown = 60;

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