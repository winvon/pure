<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/19
 * Time: 10:08
 */

namespace common\components;

use yii\helpers\Json;

class Response
{
    const RETURN_SUCCESS = "success";
    const RETURN_MSG = "msg";
    const RETURN_DATA = "data";
    const RETURN_CODE = "code";
    /**
     * 统一返回结构
     * @param string $code
     * @param bool $success
     * @param string $msg
     * @param array $data
     * @return string
     */
    public static function resJson($code = "", $success = true, $msg = "", $data = [])
    {
        $array = [
            self::RETURN_SUCCESS => $success,
            self::RETURN_MSG => $msg,
            self::RETURN_DATA => $data,
            self::RETURN_CODE => $code
        ];
        $rows = Value::changeNull($array);

        return Json::encode($rows);
    }

    /**
     * 统一返回成功
     * @param array $data
     * @return string
     */
    public static function success($msg="",$data = [])
    {
        $array = [
            self::RETURN_SUCCESS => true,
            self::RETURN_MSG => $msg,
            self::RETURN_DATA => $data,
            self::RETURN_CODE => 1
        ];
        $rows = Value::changeNull($array);
        return Json::encode($rows);
    }

    /**
     * @param string $msg
     * @param string $code
     * @return string
     */
    public static function error($msg = "", $code = "0")
    {
        $array = [
            self::RETURN_SUCCESS => false,
            self::RETURN_MSG => $msg,
            self::RETURN_DATA => '',
            self::RETURN_CODE => $code
        ];
        $rows =Value::changeNull($array);
        return Json::encode($rows);
    }

    /**
     * @param $code
     * @param array $data
     * @param string $msg
     */
    public static function Code($code, $data = [], $msg = "")
    {
        switch ($code) {
            case 9010:
                return  self::resJson(9010, false, "没有数据了", $data);
                break;
            case 9011:
                return  self::resJson(9011, true, empty($msg) ? "成功" : $msg, $data);
                break;
            case 9012:
                return   self::resJson(9012, false, empty($msg) ? "失败" : $msg, $data);
                break;
            case 9013:
                return   self::resJson(9013, true, empty($msg) ? "成功" : $msg, $data);//给pc扫码用的
                break;
            default:
                return  self::resJson(9999, false, $msg, $data);
                break;
        }
    }
}