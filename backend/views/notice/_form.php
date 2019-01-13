<?php

use backend\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Notice */
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
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'title')->textInput() ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className(), [
                    'options' => [
                        'style' => 'height:500px'
                    ]
                ]) ?>

                <?= $form->field($model, 'deadline_at')->widget(\kartik\datetime\DateTimePicker::className(),
                    [
                        'options' => [
                            'placeholder' => '有效时间',
                            'value' => $model->deadline_at ,
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii',
                            'todayHighlight' => true
                        ]
                    ]
                ) ?>

                <div class="hr-line-dashed"></div>

                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>