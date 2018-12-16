<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notice}}".
 *
 * @property int $id
 * @property int $title
 * @property int $deadline_at
 * @property int $created_at
 * @property int $updated_at
 */
class Notice extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notice}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'deadline_at','content'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'deadline_at' => '有效日期',
            'content' => '内容',
            'created_at' => '创建时间',
            'updated_at' => 'Updated Time',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->deadline_at=strtotime($this->deadline_at);
            $this->created_at = time();
        } else {
            $this->updated_at = time();
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
