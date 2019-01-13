<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%action}}".
 *
 * @property int $id
 * @property string $num 编号
 * @property string $name 姓名
 * @property int $sex 性别
 * @property string $email 邮箱
 * @property string $mobile 通讯电话
 * @property int $changci 参加场次
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $is_delete 是否删除
 */
class Action extends \common\models\Action
{

}
