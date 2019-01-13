<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/12/22
 * Time: 20:24
 */

namespace backend\controllers;


use backend\models\User;
use yii\web\Controller;
use Yii;

class BackendController extends Controller
{

    public $except = [
        '/',
        'site/index',
        'site/login',
        'site/logout',
        'admin-user/change-password',
        'admin-user/change-important',
        'admin-user/change-not-important',
        'admin-user/view',
    ];

    public function beforeAction($action)
    {
        parent::beforeAction($action); // TODO: Change the autogenerated stub;

        $user = Yii::$app->user;
        if ($user->isGuest) {
            return true;
        }
        if ($user->identity->type == User::TYPE_MANAGE) {
            return true;
        }
        if ($user->identity->admin_status != User::STATUS_ADMIN_PASS) {
            if (in_array(Yii::$app->request->pathInfo,$this->except)) {
                return true;
            }else{
                echo '资料审核中，审核通过后开启';
                exit();
            }
        }
        return true;
    }

}