<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ab_type".
 *
 * @property string $id
 * @property string $type 1未删除；2删除
 * @property int $delete
 * @property int $created_at
 * @property int $updated_at
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ab_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delete', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 50],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
