<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/11/12
 * Time: 21:29
 */

namespace backend\controllers;

use common\components\Mobile;
use backend\models\User;
use yii\web\Controller;
use Yii;
use common\components\Common;
class PublicController extends Controller
{

    public function actionSendMobileCode()
    {
        Common::sendRegisterCode();
        return true;
    }
}