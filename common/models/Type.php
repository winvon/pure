<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%type}}".
 *
 * @property string $id
 * @property string $type 1未删除；2删除
 * @property int $delete
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'delete'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['id'], 'unique'],
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
