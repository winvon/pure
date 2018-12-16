<?php

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
                ]); ?>

                <?= $form->field($model, 'start_time')->widget(\kartik\datetime\DateTimePicker::className(),
                    [
                        'options' => [
                            'placeholder' => '开始时间',
                            'value' =>$model->start_time ,
                            ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii',
                            'todayHighlight' => true
                        ]]
                ) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'end_time')->widget(\kartik\datetime\DateTimePicker::className(),
                    [
                        'options' => [
                            'placeholder' => '结束时间',
                            'value' => $model->end_time,
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii',
                            'todayHighlight' => true
                        ]
                    ]
                ) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'price')->input('number') ?>

                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
                <div class=" " style="margin-left: 10%">
                    <h5>提示:</h5>
                    <p>1、价格不填写,预约用户在点击预约按钮时，会随机生成价格;</p>
                    <p>2、价格填写, 预约用户在点击预约按钮时，不会随机生成价格;</p>
                    <p>3、价格填写0,表示免费。</p>
                </div>
            </div>
        </div>
    </div>
</div>