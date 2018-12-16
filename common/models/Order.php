<?php

namespace common\models;

use common\libs\Constants;
use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $admin_id 導師用戶id
 * @property string $user_id 預約用戶id
 * @property int $start_time
 * @property int $end_time
 * @property int $order_sn
 * @property int $time
 * @property int $price
 * @property int $price_copy
 * @property int $telephone
 * @property int $status 是否預約1否；2是；3取消；
 * @property int $delete
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_WAIT_ORDER = 1;
    const STATUS_ORDER = 2;
    const STATUS_FINISH = 3;

    const DELETE_NOT = 1;
    const DELETED = 2;

    const PAY_STATUS_PAY = 1;
    const PAY_STATUS_PAYING = 2;
    const PAY_STATUS_PAYED = 3;

    public static function getStatusItems($key = null)
    {
        $items = [
            self::STATUS_WAIT_ORDER => yii::t('app', '未预约'),
            self::STATUS_ORDER => yii::t('app', '已预约'),
            self::STATUS_FINISH => yii::t('app', '已完成'),
        ];
        return Constants::getItems($items, $key);
    }

    public static function getPayStatusItems($key = null)
    {
        $items = [
            self::PAY_STATUS_PAY => yii::t('app', '待支付'),
            self::PAY_STATUS_PAYING => yii::t('app', '支付中'),
            self::PAY_STATUS_PAYED => yii::t('app', '已支付'),
        ];
        return Constants::getItems($items, $key);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'user_id', 'status', 'created_at', 'updated_at', 'delete', 'pay_status'], 'integer'],
            [['start_time', 'end_time'], 'required'],
            [['start_time', 'end_time', 'order_sn'], 'safe'],
            [['id'], 'unique'],
            [['end_time'], 'checkTime'],
            [['start_time'], 'checkStartTime'],
            [['price', 'pay', 'price_copy', 'pay'], 'number'],
        ];
    }

    public function checkStartTime($attribute)
    {
        if ((int)strtotime($this->start_time) < time()) {
            $this->addError($attribute, yii::t('app', '开始时间须大于当前时间'));
        }
    }

    public function checkTime($attribute)
    {
        if ((int)strtotime($this->end_time) - (int)strtotime($this->start_time) > 12 * 60 * 60) {
            $this->addError($attribute, yii::t('app', '开始时间与结束时间须小于12小时'));
        }
        if ((int)strtotime($this->end_time) <= (int)strtotime($this->start_time)) {
            $this->addError($attribute, yii::t('app', '结束时间须大于开始时间'));
        }
    }

    public function scenarios()
    {
        $array = [
            'cancel' => ['id', 'user_id', 'price'],
            'order' => ['price'],
            'pay' => ['pay_status', 'pay'],
            'delete' => ['delete'],
        ];
        return array_merge($array, parent::scenarios());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => '疗愈师',
            'order_sn' => '订单号',
            'user_id' => '预约用户',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'price' => '价格￥',
            'pay' => '已支付￥',
            'pay_status' => '支付状态',
            'time' => 'Time',
            'status' => 'Status',
            'delete' => 'Delete',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->order_sn = 'ORD' . date('Ymd') . rand(1000, 9999);
            $this->admin_id = Yii::$app->user->identity->id;
            $this->created_at = time();
        } else {
            $this->updated_at = time();
        }
        if ($this->price != null) {
            $this->price_copy = $this->price;
        }
        if (!in_array($this->scenario,['order'])) {
            $this->start_time = strtotime($this->start_time);
            $this->end_time = strtotime($this->end_time);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAdminUser()
    {
        return $this->hasOne(\backend\models\AdminUser::className(), ['id' => 'admin_id']);
    }
}
