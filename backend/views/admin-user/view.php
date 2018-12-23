<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2018-02-24 14:26
 */
use backend\models\User;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
?>
<?php
echo $this->render('/widgets/_ibox-title');
?>
<!--<a class="openContab btn btn-default" id="change"
   href="<? /*= Url::to(['admin-user/check', 'id' => Yii::$app->user->id]) */ ?>" title="审核"
   data-index="0">审核</a>-->
<?php
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'username',
        [
            'attribute' => 'avatar',
            'format' => 'raw',
            'value' => function ($model) {
                if (empty($model->avatar)) return '-';
                return "<img style='max-width:50px;max-height:50px' src='" . $model->avatar . "'>";
            }
        ],
        'nickname',
        'realname',
        'telephone',
        'email',
        'bank',
        'bank_account',
        'card_number',
        [
            'attribute' => 'card_img',
            'format' => 'raw',
            'value' => function ($model) {
                if (empty($model->card_img)) return '-';
                return "<img style='max-width:50px;max-height:50px' src='" . $model->card_img . "'>";
            }
        ],
        [
            'attribute' => 'certificate',
            'format' => 'raw',
            'value' => function ($model) {
                if (empty($model->certificate)) return '-';
                return "<img style='max-width:50px;max-height:50px' src='" . $model->certificate . "'>";
            }
        ],
        [
            'attribute' => 'admin_status',
            'value' => function ($model) {
                if ($model->admin_status == User::STATUS_ADMIN_CHECK) {
                    return yii::t('app', '待审核');
                } else if ($model->admin_status == User::STATUS_ADMIN_PASS) {
                    return yii::t('app', '通过');
                } else if ($model->admin_status == User::STATUS_ADMIN_PASS_NOT) {
                    return yii::t('app', '拒绝');
                }
            }
        ],
        'reason',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>

