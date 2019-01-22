<?php

use backend\widgets\ActiveForm;
use yii\helpers\Url;
use frontend\models\Action;

/* @var $this yii\web\View */
/* @var $model backend\models\Action */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Actions'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Actions')],
];
?>
<style>
    .checkbox, .radio {
        margin-top: 0px;
    }

    h2 {
        color: #5a1d80;
    }
</style>
<div class="content" style="width: 100%">
    <div class="col-md-8" style="margin-top: 100px">
        <h2 style="margin-left: 10%">阿卡西(Akashic)课程报名</h2>
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form',
                'style' => 'height:800px;'
            ],
            'fieldConfig' => [
//            'template' => "{input}{error}{hint}",
                'inputOptions' => [
                    'class' => 'form-control ',
                    'style' => 'width:400px;height:38px;border-radius:0 2px 2px 0;'
                ]]
        ]); ?>
        <div class="hr-line-dashed"></div>

        <?php
        if ($model->id != 0) {
            ?>
            <?= $form->field($model, 'num')->textInput(['readonly' => true]) ?>
            <div class="hr-line-dashed"></div>
            <?php
        } ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        <div class="hr-line-dashed"></div>

        <?= $form->field($model, 'sex')->radioList(Action::getSexItem(), ['itemOptions' => ['disabled' => true]]) ?>
        <div class="hr-line-dashed"></div>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <div class="hr-line-dashed"></div>

        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
        <div class="hr-line-dashed"></div>

        <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>
        <div class="hr-line-dashed"></div>

        <?= $form->field($model, 'changci')->dropDownList(Action::getChangCiItem(), ['prompt' => '请选择活动的场次']) ?>
        <div class="hr-line-dashed"></div>

        <?= $form->field($model, 'comment')->textarea(['placeholder' => '备注内容', 'style' => 'width:400px;height:100px']) ?>
        <div class="hr-line-dashed"></div>

        <?= $form->field($model, 'status')->dropDownList(Action::getStatusItem(), ['prompt' => '审核状态', 'disabled' => true]) ?>
        <div class="hr-line-dashed"></div>
        <?php
        if ($model->status == Action::STATUS_FAILED) {
            ?>
            <?= $form->field($model, 'reason')->textarea(['style' => 'width:400px;height:100px', 'readonly' => true]); ?>
            <div class="hr-line-dashed"></div>
            <?php
        }
        ?>
        <div class="form-group">
            <div class="col-sm-' . $options['size'] . ' col-sm-offset-2">
                <button style="width: 90px;height: 36px" class="btn btn-primary"
                        type="submit"><?= Yii::t('app', '修改报名') ?> </button>
                <button style="width: 60px;height: 36px" class=" btn btn-info"
                        type="reset"><?= Yii::t('app', 'Reset') ?></button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-4" style="margin-top: 150px">
        <p>备注:</p>
        <p style="font-size:12px">此时您的报名资料已提交,您会在一分钟内收到邮件通知。<br>若接受失败，请修改邮件地址，系统重新发送邮件通知。</p>
        <br>
        <select class="sel">
            <option value=1>马来西亚|新加坡负责人</option>
            <option value=2>台湾/台北负责人</option>
            <option value=3>深圳|香港|澳门负责人</option>
            <option value=4> 中国/北京负责人</option>
        </select>
        <div id="replace"></div>
        <div id="1" style="display: none">
            馬來西亞：靜娟<br>
            *入账银行：馬來亞銀行（Maybank）<br>
            *账号姓名：Tu Chin Juan<br>
            *账号号码：1010-6781-6041<br>
            *Email ： ginger.tu@gmail.com<br>
            ----------------------------------------------<br>
            新加坡：林潔馨 Jacelyn Lim<br>
            *入账银行：Oversea-Chinese Banking (OCBC)<br>
            *账号姓名： Lim Gat Sin<br>
            *账号号码：608053294001<br>
            *Email : jaceljx@gmail.com<br>
        </div>
        <div id="2" style="display: none">
            *入账银行：中國信託銀行(chinatrust)<br>
            *账号号码：帳戶：822-277531011281<br>
            *中文名字：丁竑峻<br>
            * Email ：frederic123123123123@gmail.com<br>
        </div>
        <div id="3" style="display: none">
            * 入账银行：恒生銀行 <br>
            * 账号号码：936 050855 888 <br>
            * 中文名字：张子漩 <br>
            * 英文姓名：Cheung Tsz Suen<br>
        </div>
        <div id="4" style="display: none">
            子漩老師<br>
            * 入账银行：恒生銀行 <br>
            * 账号号码：936 050855 888 <br>
            * 中文名字：张子漩 <br>
            * 英文姓名：Cheung Tsz Suen<br>
            -----------------------------------------------
            <img src="/static/images/zzz.png" width="160px">
        </div>
    </div>
    <div class="col-md-4">
        <div>
            <h3>恭喜您已报名成功</h3>
            <p style="font-size: 12px">恭喜您已报名成功，若需修改资料，请登陆到www.purelove.ltd 【我的报名】 修改报名讯息。</p>
            <p style="font-size: 12px">缴费之后请email负责人,或者回复本邮件已缴费。回复内容包含您的的报名编号或者电话号码或者微信号码。</p>
            <p>报名缴费各地区负责人账户及邮箱</p>

            <div class="div-box" style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>馬來西亞负责人：靜娟</p>
                <p>*入账银行：馬來亞銀行（Maybank）</p>
                <p>*账号姓名：Tu Chin Juan</p>
                <p>*账号号码：1010-6781-6041</p>
                <p>*Email ： ginger.tu@gmail.com</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>新加坡负责人：林潔馨 Jacelyn Lim</p>
                <p>*入账银行：Oversea-Chinese Banking (OCBC)</p>
                <p>*账号姓名： Lim Gat Sin</p>
                <p>*账号号码：608053294001</p>
                <p>*Email : jaceljx@gmail.com</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>台湾台北负责人</p>
                <p>*入账银行：中國信託銀行(chinatrust)</p>
                <p>*账号号码：帳戶：822-277531011281</p>
                <p>*中文名字：丁竑峻 </p>
                <p>* Email ：frederic123123123123@gmail.com</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>北京|深圳|香港|澳门负责人</p>
                <p>子漩老師 </p>
                <p>* 入账银行：恒生銀行 </p>
                <p>* 账号号码：936 050855 888</p>
                <p>* 中文名字：张子漩 </p>
                <p>* 英文姓名：Cheung Tsz Suen </p>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function myfun() {
            var id = $("#action-changci").val();
            $('.sel').find("option[value=" + id + "]").attr("selected", true);
            $('div[id=replace]').append($('div[id=' + id + ']').clone().css('display', 'block'));
        }
        window.onload = myfun;
        $('.sel').on('change', function () {
            var id = this.value;
            $('div[id=replace]').empty();
            $('div[id=replace]').append($('div[id=' + id + ']').clone().css('display', 'block'));
        })
    </script>
