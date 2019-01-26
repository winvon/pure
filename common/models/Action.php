<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%action}}".
 *
 * @property int $id
 * @property string $num 编号
 * @property string $name 姓名
 * @property int $sex 性别
 * @property string $email 邮箱
 * @property string $mobile 通讯电话
 * @property string comment 通讯电话
 * @property string reason 通讯电话
 * @property int $changci 参加场次
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $is_delete 是否删除
 */
class Action extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%action}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'mobile', 'changci', 'wechat'], 'required'],
            [['sex', 'changci', 'status', 'created_at', 'updated_at', 'is_delete'], 'integer'],
            [['num'], 'string', 'max' => 50],
            ['email', 'email'],
            [['name', 'email', 'mobile'], 'string', 'max' => 255],
            [['comment', 'reason', 'num'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num' => '编号',
            'name' => '姓名',
            'sex' => '性别',
            'email' => '邮箱',
            'mobile' => '通讯电话',
            'wechat' => '微信账号',
            'changci' => '参加场次',
            'reason' => '拒绝原因',
            'comment' => '备注',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'is_delete' => '是否删除',
        ];
    }

    /**
     * @return array
     * @author von
     */
    public static function getChangCiItem()
    {
        return [
            1 => '地区:马来西亚|新加坡  时间：3/8--3/10',
            2 => '地区:台湾/台北  时间：3/15--3/17',
            3 => '地区:深圳|香港|澳门  时间：4/12--4/14',
            4 => '地区:中国/北京  时间：4/26--4/28'
        ];
    }

    /**
     * @return array
     * @author von
     */
    public static function getSexItem()
    {
        return [
            0 => '男',
            1 => '女'
        ];
    }

    /**
     * @return array
     * @author von
     */
    public static function getStatusItem()
    {
        return [
            0 => '新报名',
            1 => '审核中',
            2 => '报名成功',
            3 => '报名失败',
        ];
    }

    const STATUS_CHECK = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAILED = 3;

    public function beforeSave($insert)
    {
        parent::beforeSave($insert); // TODO: Change the autogenerated stub
        if ($this->isNewRecord) {
            $num = self::find()->where(['changci' => $this->changci])->orderBy('id DESC')->one();
            $id = $num == null ? 0 : $num->id;
            switch ($this->changci) {
                case 3:
                    $this->num = 'HK190412-' . $id . rand(1000, 9999);
                    break;
                case 1:
                    $this->num = 'MS190308-' . $id . rand(1000, 9999);
                    break;
                case 2:
                    $this->num = 'TP190315-' . $id . rand(1000, 9999);
                    break;
                case 4:
                    $this->num = 'BJ190426-' . $id . rand(1000, 9999);
                    break;
                default  :
                    $this->num = '';
                    break;
            }
            $this->uid = Yii::$app->user->id;
            $this->status = self::STATUS_CHECK;
            $this->created_at = time();
        } else {
            if ($this->getAttribute('email') != $this->getOldAttribute('email')) {
                for ($i = 0; $i < 2; $i++) {
                    if ($this->send($this->getAttribute('email'), $this->num)) {
                        break;
                    }
                }
            }
            if ($this->status == self::STATUS_SUCCESS) {
                $this->sendOk($this->email, $this->num);
            }
        }
        $this->updated_at = time();
        if ($this->status == self::STATUS_FAILED) {
            if (empty($this->reason)) {
                $this->addError('reason', '审核拒绝，原因须填写');
                return false;
            }
        }
        return true;
    }

    public function send($email, $num)
    {
        $content = $this->contentAdd($num);
        $res = Yii::$app->mailer->compose()
            ->setFrom('1165180201@qq.com')
            ->setTo($email)
            ->setSubject('阿卡西课程报名')
            ->setTextBody('Plain text content')
            ->setHtmlBody($content)
            ->send();
        return $res;
    }

    public function sendOk($email, $num)
    {
        $content = $this->contentOk($num);
        $res = Yii::$app->mailer->compose()
            ->setFrom('1165180201@qq.com')
            ->setTo($email)
            ->setSubject('阿卡西课程报名')
            ->setTextBody('Plain text content')
            ->setHtmlBody($content)
            ->send();
        return $res;
    }


    public function contentOk($num)
    {
        return '<div>
            <h3>恭喜您的报名审核成功</h3>
            <p style="font-size: 12px">恭喜您已报名成功，报名编号：' . $num . '，若需修改资料，请登陆到www.purelove.ltd 【我的报名】 修改报名讯息。</p>
            </div>';
    }

    public function contentAdd($num)
    {
        return '<div>
            <h3>恭喜您已报名成功</h3>
            <p style="font-size: 12px">恭喜您已报名成功，报名编号：' . $num . '，若需修改资料，请登陆到www.purelove.ltd 【我的报名】 修改报名讯息。</p>
            <p style="font-size: 12px">缴费之后请email负责人,或者回复本邮件已缴费。回复内容包含您的的报名编号或者电话号码或者微信号码。</p>
            <p>报名缴费各地区负责人账户及邮箱</p>
            <div class="div-box" style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>馬來西亞负责人：靜娟</p>
                <p>*入账银行：馬來亞銀行（Maybank）</p>
                <p>*账号姓名：Tu Chin Juan</p>
                <p>*账号号码：1010-6781-6041</p>
                <p>*Email ： ginger.tu@gmail.com</p>
                <p>*通讯电话 ：+6012-7886553</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>新加坡负责人：林潔馨 Jacelyn Lim</p>
                <p>*入账银行：Oversea-Chinese Banking (OCBC)</p>
                <p>*账号姓名： Lim Gat Sin</p>
                <p>*账号号码：608053294001</p>
                <p>*Email : jaceljx@gmail.com</p>
                <p>*通讯电话 ：+65-83992648</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>台湾台北负责人</p>
                <p>*入账银行：中國信託銀行(chinatrust)</p>
                <p>*账号号码：帳戶：822-277531011281</p>
                <p>*中文名字：丁竑峻 </p>
                <p>* Email ：frederic123123123123@gmail.com</p>
                <p>*通讯电话 ：+886-922-491707</p>
            </div>
            <div style="border:  1px solid #bababa;font-size: 12px ;width: 300px">
                <p>北京|深圳|香港|澳门负责人</p>
                <p>子漩老師 </p>
                <p>* 入账银行：恒生銀行 </p>
                <p>* 账号号码：936 050855 888</p>
                <p>* 中文名字：张子漩 </p>
                <p>* 英文姓名：Cheung Tsz Suen </p>
                <p>*通讯电话 ：+855-66293812</p>
                <p>*通讯电话 ：+86-13728987573</p>
            </div>
        </div>';
    }
}
