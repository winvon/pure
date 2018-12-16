<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/12/15
 * Time: 23:20
 */

namespace backend\models;


class AdminUser extends User
{

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->username=$this->nickname?$this->nickname:$this->username;
    }

    public static function getAuthorSelect()
    {
        $models = self::getAuthor();
        $array = [];
        foreach ($models as $model) {
            $array[] = [
                'id' => $model->id,
                'text' => $model->username
            ];
        }
        return $array;
    }
}