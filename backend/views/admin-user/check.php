<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-31 17:07
 */
use yii\helpers\Url;
use backend\widgets\ActiveForm;
use backend\models\User;

use common\widgets\JsBlock;
$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', '个人资料'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', '审核') . yii::t('app', '个人资料')],
];
/**
 * @var $model backend\models\User
 */
?>  <div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form =  ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => 64, 'readonly' => true,]) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'nickname')->textInput(['maxlength' => 64, 'readonly' => true,  [
                    'placeholder' => '前台页面显示的称呼',]]) ?>

                <?= $form->field($model, 'realname')->textInput(['maxlength' => 64, 'readonly' => true, [
                    'placeholder' => '真实姓名',]]) ?>
                <?= $form->field($model, 'avatar')->imgInput([
                    'readonly' => 'true',
                    'width' => '200px',
                    'baseUrl' => yii::$app->params['admin']['url']
                ]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'telephone')->textInput(['maxlength' => 64 ,'readonly' => true, ]) ?>
                <?= $form->field($model, 'card_number')->textInput(['maxlength' => 64,'readonly' => true, [
                    'placeholder' => '身份证件号码',]]) ?>
                <?= $form->field($model, 'card_img')->imgInput([
                    'value' => $model->card_img,
                    'width' => '150px',
                    'baseUrl' => yii::$app->params['admin']['url'],
                ]) ?>
                <?= $form->field($model, 'current_address')->textInput(['maxlength' => 64, 'readonly' => 'true', [
                    'placeholder' => '当前住居地址,以收取邮件',]]) ?>
                <?= $form->field($model, 'certificate')->imgInput([

                    'readonly' => 'true',
                    'width' => '150px',
                    'baseUrl' => yii::$app->params['admin']['url'],
                ]) ?>
                <?= $form->field($model, 'bank')->textInput(['maxlength' => 64,'readonly' => 'true', [
                    'placeholder' => '收款银行',]]) ?>
                <?= $form->field($model, 'bank_account')->textInput(['maxlength' => 64,'readonly' => 'true', [
                    'placeholder' => '收款账号',]]) ?>

                <?= $form->field($model, 'introduce')->textArea(['readonly' => 'true',
                    'style' => 'height:150px',
                    'placeholder' => '自我介绍一下吧!',
                ]) ?>
                <?= $form->field($model, 'admin_status')->radioList(User::getAdminStatuses()) ?>
                <?= $form->field($model, 'reason')->textArea([
                    'style' => 'height:100px',
                    'placeholder' => '若审核拒绝，请填写原因',
                ]) ?>
                <div class="hr-line-dashed"></div>
                <div class="hr-line-dashed"></div>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin() ?>
<script>
    $(document).ready(function () {
        var isSuperAdmin = <?php if (in_array($model->getId(), yii::$app->getBehavior('access')->superAdminUserIds)) {
            echo 1;
        } else {
            echo 0;
        }?>;
        if (isSuperAdmin) {
            var forbiddens = $(".field-permissions, .field-user-roles").find("input[type=checkbox]");
            forbiddens.each(function () {
                $(this).attr('disabled', true).attr('checked', true);
            })
        } else {
            var chooseAll = $(".col-sm-11 .col-sm-1 .chooseAll");
            var middle = $(".col-sm-1 .chooseAll");
            var top = $("label .chooseAll");
            for (var i = 0; i < middle.length; i++) {
                chooseAll.push(middle[i]);
            }
            for (var i = 0; i < top.length; i++) {
                chooseAll.push(top[i]);
            }
            chooseAll.each(function () {
                var that = $(this);
                if (that.attr('id') == 'permission-all') {
                    var checkboxs = $(this).parents("span").next().find("input[type=checkbox]");
                } else {
                    var checkboxs = $(this).parents(".col-sm-1").next().find("input[type=checkbox]");
                }
                var atLeastOneUnchecked = false;
                checkboxs.each(function () {
                    if ($(this).is(":checked") == false) {
                        atLeastOneUnchecked = true;
                    }
                });
                if (atLeastOneUnchecked == false && that.is(":checked") == false) {
                    that.trigger('click');
                }
            });
        }

        $(".chooseAll").change(function () {
            var type = $(this).is(':checked');
            var checkboxs = $(this).parents("span").next().find("input[type=checkbox]");
            if (checkboxs.length == 0) {
                checkboxs = $(this).parents(".col-sm-1").next().find("input[type=checkbox]");
            }
            checkboxs.each(function () {
                if (type != $(this).is(':checked')) {
                    $(this).trigger('click');
                }
            })
        })
    })
</script>
<?php JsBlock::end() ?>
