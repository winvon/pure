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
$this->title = yii::t('app', 'Login');
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
        <style>
            div.form-group div.help-block {
                position: absolute;
                left: 305px;
                width: 170px;
                top: 4px;
                text-align: left;
            }

            .form-horizontal .form-group {
                width: 300px;
                margin-left: 0px;
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
                ],]); ?>
            <?= $form->field($model, 'username',
                ['template' => "<div style='position:relative'>{input}\n{error}\n{hint}</div>"])
                ->textInput(['autofocus' => true, 'placeholder' => yii::t("app", "Username")]) ?>

            <?= $form->field($model, 'password', ['template' => "<div style='position:relative'>{input}\n{error}\n{hint}</div>"])
                ->passwordInput(['placeholder' => yii::t("app", "Password")]) ?>

            <?= Html::submitButton(yii::t("app", "Login"), [
                'class' => 'btn btn-primary block full-width m-b',
                'name' => 'login-button'
            ]) ?>

            <p class="text-muted text-center">
                <a href="<?= Url::to(['admin-user/signup']) ?>">
                     <?= yii::t('app', '注册') ?> 
                </a>|
                <a href="<?= Url::to(['site/forget-password']) ?>">
                    <small><?= yii::t('app', 'Forgot password') ?></small>
                </a>
                <!-- --><?php
//                if (yii::$app->language == 'en-US') {
//                    echo "<a href = " . Url::to(['site/language', 'lang' => 'zh-CN']) . " > 简体中文</a >";
//                } else {
//                    echo "<a href=" . Url::to(['site/language', 'lang' => 'en-US']) . ">English</a>";
//                }
//                ?>
            </p>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>