<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/11/4
 * Time: 18:03
 */

namespace common\models;

use common\components\IdWork;
use yii\db\ActiveRecord;
use Yii;
class BaseModel extends ActiveRecord
{
    public static function getId()
    {
        $work = new IdWork(Yii::$app->params["workId"]);
        return $work->nextId();
    }
}