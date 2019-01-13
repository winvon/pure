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
            [['name', 'email', 'mobile', 'changci'], 'required'],
            [['sex', 'changci', 'status', 'created_at', 'updated_at', 'is_delete'], 'integer'],
            [['num'], 'string', 'max' => 50],
            ['email', 'email'],
            [['name', 'email', 'mobile'], 'string', 'max' => 255],
            [['common', 'reason','num'], 'safe'],
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
            'changci' => '参加场次',
            'reason' => '拒绝原因',
            'comment' => '备注',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'is_delete' => '是否删除',
        ];
    }

    public static function getChangCiItem()
    {
        return [
            1 => '地区:深圳|香港|澳门  时间：3/1--3/3',
            2 => '地区:马来西亚|新加坡  时间：3/8--3/10',
            3 => '地区:台湾/台北  时间：3/15--3/17',
            4 => '地区:中国北京  时间：3/22--3/24'
        ];
    }

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

    const STATUS_CHECK=1;
    const STATUS_SUCCESS=2;
    const STATUS_FAILED=3;

    public function beforeSave($insert)
    {
         parent::beforeSave($insert); // TODO: Change the autogenerated stub
         if ($this->isNewRecord) {
             $num=self::find()->where(['changci'=>$this->changci])->orderBy('id DESC')->one();
             $id=$num==null?0:$num->id;
             switch ($this->changci){
                case 1:$this->num='HK190301-'.$id.rand(1000,9999);break;
                case 2:$this->num='MS190308-'.$id.rand(1000,9999);break;
                case 3:$this->num='TP190315-'.$id.rand(1000,9999);break;
                case 4:$this->num='BJ190322-'.$id.rand(1000,9999);break;
                default  :$this->num='';break;
             }
             $this->uid=Yii::$app->user->id;
             $this->status=self::STATUS_CHECK;
             $this->created_at=time();
         }
        $this->updated_at=time();
        if ($this->status==self::STATUS_FAILED){
            if (empty($this->reason)) {
                $this->addError('reason','审核拒绝，原因须填写');
                return false;
            }
        }
        return true;
    }
}
