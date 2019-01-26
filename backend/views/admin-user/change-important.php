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

use backend\models\form\Rbac;
use backend\widgets\ActiveForm;
use backend\models\User;
use common\widgets\JsBlock;
use yii\helpers\Html;
use backend\models\AdminUser;

$this->title = "Admin";
?>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <?= $this->render('/widgets/_ibox-title') ?>
                <div class="ibox-content">
                    <p style="font-size: 10px">提示：以下资料修改后，账户将进入审核状态，账户功能在审核通过后开启</p>
                    <div class="hr-line-dashed"></div>
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal'
                        ]
                    ]); ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => 64, 'readonly' => 'true',]) ?>
                    <div class="hr-line-dashed"></div>

                    <?= $form->field($model, 'realname')->textInput(['maxlength' => 64, [
                        'placeholder' => '真实姓名',]]) ?>
                    <?= $form->field($model, 'card_number')->textInput(['maxlength' => 64, [
                        'placeholder' => '身份证件号码',]]) ?>
                    <?= $form->field($model, 'card_img')->imgInput([
                        'value' => $model->card_img,
                        'width' => '150px',
                        'baseUrl' => yii::$app->params['admin']['url'],
                    ]) ?>
                    <?= $form->field($model, 'certificate')->imgInput([

                        'readonly' => 'true',
                        'width' => '150px',
                        'baseUrl' => yii::$app->params['admin']['url'],
                    ]) ?>
                    <?= $form->field($model, 'bank')->textInput(['maxlength' => 64, [
                        'placeholder' => '收款银行',]]) ?>
                    <?= $form->field($model, 'bank_account')->textInput(['maxlength' => 64, [
                        'placeholder' => '收款账号',]]) ?>

                    <div class="hr-line-dashed"></div>
                    <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php JsBlock::begin() ?>
    <script>
        <?php
        if (Yii::$app->user->identity->type == AdminUser::TYPE_TEACHER) {
            if (Yii::$app->request->get('lo')==1) {
                if (Yii::$app->user->identity->admin_status == AdminUser::STATUS_ADMIN_CHECK) {
                    echo "layer.msg('请点击头像下方用户名，完善个人资料和重要资料',{time:5000})";
                }
            }
        }
        ?>

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
                    })
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