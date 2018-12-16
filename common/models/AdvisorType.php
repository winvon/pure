<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%advisor_type}}".
 *
 * @property string $id
 * @property string $admin_id
 * @property int $type 1未删除；2删除
 * @property int $delete
 */
class AdvisorType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advisor_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'admin_id', 'delete'], 'integer'],
            [['id'], 'unique'],
            [['type'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'delete' => 'Delete',
        ];
    }
}
