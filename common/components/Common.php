<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/12/12
 * Time: 21:07
 */

namespace common\components;

use Yii;

class Common
{
    public static $_district='';



    public static function sendRegisterCode()
    {
        $post = Yii::$app->request->post();
        $district = (string)trim(explode(":", $post['district'])[1], ' ');
        Common::$_district=$district;
        $telephone = $district . (string)$post['telephone'];
        $cache = Yii::$app->cache;
        if (!self::sendCode($telephone)) {
            return false;
        }
        $cache->set($post['telephone'] . 'district', $post['district'], 60 * 60 * 24);
        return true;
    }


    public static function sendCodeForget()
    {
        $post = Yii::$app->request->post();
        $district = (string)trim(explode(":", $post['district'])[1], ' ');
        $telephone = $district . (string)$post['telephone'];
        self::sendCode($telephone);
        return true;
    }

    public static function sendCode($telephone)
    {
        $code = rand(1000, 9999);
        $post = Yii::$app->request->post();
        if (!Telephone::send($telephone,$code)) {
            return false;
        }
        $cache = Yii::$app->cache;
        $cache->set($post['telephone'], $code, 60 * 20);//20分钟；
        return true;
    }
}