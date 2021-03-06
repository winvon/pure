<?php
/**
 * Created by PhpStorm.
 * User: FOCUS
 * Date: 2018/11/27
 * Time: 16:25
 */

namespace common\components;


use Yunpian\Sdk\YunpianClient;
use Yii;

class Telephone
{
    const TYPE_ACTION_PASS = 1;

    const TYPE_ACTION_PASS_NOT = 2;

    public static $district = ['+86', '+886', '+852', '+853'];

    public static function sendByType($type, $param = [])
    {
        switch ($type) {
            case self::TYPE_ACTION_PASS:
                if (!in_array($param['district'], ['+86', '+886', '+852', '+853'])) {
                    $string = "【PURELOVE】Dear,Congratulations! Your application has been approved.";
                } else {
                    $string = "【PURELOVE】尊敬的学员,恭喜您，您的报名已审核通过.";
                };
                break;
            case self::TYPE_ACTION_PASS_NOT:
                if (!in_array($param['district'], ['+86', '+886', '+852', '+853'])) {
                    $string = "【PURELOVE】We are very sorry that your application was not approved. The reason has been notified by email";
                } else {
                    $string = "【PURELOVE】尊敬的学员,非常抱歉,您的报名未审核通过.原因已邮件通知.";
                };
                break;
        }
        Yii::$app->smser->send($param['telephone'], $string);
        return true;
    }


    public static function send($telephone = '17623006012', $code)
    {
        $res = self::beforeSend($telephone);
        if ($res !== true) {
            return $res;
        }
        if (!in_array(Common::$_district, ['+86', '+886', '+852', '+853'])) {
            $string = "【PURELOVE】Your verification code is $code, valid within 20 minutes. Don't let it out.";
        } else {
            $string = "【PURELOVE】您的验证码是$code,20分钟内有效。请勿泄露。";
        }
        Yii::$app->smser->send($telephone, $string);
        return true;
    }

    public static function beforeSend($telephone)
    {
        $cache = Yii::$app->cache;
        $t_value = $cache->get($telephone);
        if ($t_value == null) {
            $cache->set($telephone, 2, 60);
        } elseif ($t_value == 2) {
            return "请60s后,再请求验证码";
        }
        $i_value = $cache->get(Yii::$app->request->userIP);
        if ($i_value == null) {
            $cache->set(Yii::$app->request->userIP, 1, 60);
        } else {
            return "请60s后,再请求验证码";
        }
        return true;
    }


    public static function trimall($str)
    {
        $qian = array(" ", "　", "\t", "\n", "\r");
        $hou = array("", "", "", "", "");
        return str_replace($qian, $hou, $str);
    }

}