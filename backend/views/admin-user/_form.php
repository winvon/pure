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

$this->title = "Admin";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'avatar')->imgInput([
                    'width' => '200px',
//                    'baseUrl' => yii::$app->params['admin']['url']
                ]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'telephone')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 512]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'status')->radioList( User::getStatuses() ) ?>
                <div class="hr-line-dashed"></div>
                <?php
                    $roles = yii::$app->getAuthManager()->getRoles();
                    $temp = [];
                    foreach (array_keys($roles) as $key){
                        $temp[$key] = $key;
                    }
                ?>
                <?php
                    $itemsOptions = [];
                    if(in_array( $model->getId(), yii::$app->getBehavior('access')->superAdminUserIds)){
                        $itemsOptions = ['disabled'=>'true'];
                    }
                ?>
                <?= $form->field($model, 'roles', [
                    'labelOptions' => [
                        'label' => yii::t('app', 'Roles'),
                    ]
                ])->checkboxList($temp, ['itemOptions'=>$itemsOptions]) ?>
                <div class="hr-line-dashed"></div>

                <div class="hr-line-dashed"></div>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php JsBlock::begin()?>
    <script>
        $(document).ready(function () {
            var isSuperAdmin = <?php if(in_array($model->getId(), yii::$app->getBehavior('access')->superAdminUserIds)){echo 1;}else{echo 0;}?>;
            if( isSuperAdmin ){
                var forbiddens = $(".field-permissions, .field-user-roles").find("input[type=checkbox]");
                forbiddens.each(function(){
                    $(this).attr('disabled', true).attr('checked', true);
                })
            }else{
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
                if( checkboxs.length == 0 ) {
                    checkboxs = $(this).parents(".col-sm-1").next().find("input[type=checkbox]");
                }
                checkboxs.each(function () {
                    if(type != $(this).is(':checked')){
                        $(this).trigger('click');
                    }
                })
            })
        })
    </script>
<?php JsBlock::end()?>