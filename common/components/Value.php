<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/23
 * Time: 9:16
 */

namespace common\components;


use common\models\BaseModel;

class Value
{



    public static function changeNull($arr)
    {
        return self::settNull($arr);
    }

    public static function settNull($arr){

        foreach ($arr as $k=>$v)
        {
                if(is_array($arr[$k]))
                {
                    if(count($arr[$k])>0){
                        $arr[$k] = self::settNull($arr[$k]);
                    }else{
                        unset($arr[$k]);
                    }

                }
                else
                {
                    if($k!="success"){
                        if(empty($arr[$k])||$arr[$k]=="--")
                        {
                            unset($arr[$k]);
                        }
                    }

                }
        }
        return $arr;

    }


    /**
     * 参数不存在，设置为空
     * @param array $array
     * @param array $data
     * @return array
     */
    public static function setNull(array $array, array $data)
    {
        foreach ($array as $row) {
            if (empty($data[$row])) {
                $data[$row] = null;
            }
        }
        return $data;
    }

    /**
     * 参数检查不能为空
     * @param array $standard
     * @param array $target
     * @return bool
     */
    public static function emptyFilter(array $standard, array $target)
    {
        $string = "";
        foreach ($standard as $value) {
            if (empty($target[$value])) {
                $string .= $value . ".";
            }
        }
        return $string;
    }

    /**
     * 参数检查必须存在
     * @param array $standard
     * @param array $target
     * @return bool
     */
    public static function issetFilter(array $standard, array $target)
    {
        $string = "";
        foreach ($standard as $value) {
            if (!isset($target[$value])) {
                $string .= $value . ".";
            }
        }
        return $string;
    }

    /**
     * @param $array
     * @return array
     */
    public static function toSelect2Items($array, $id = "", $text = "")
    {
        $row = [];
        foreach ($array as $key => $value) {
            if (is_object($value)) {
                $row[] = [
                    'id' => (string)$value->$id,
                    'text' => (string)$value->$text,
                ];
            } else {
                $row[] = [
                    'id' => (string)$key,
                    'text' => (string)$value,
                ];
            }
        }
        return $row;
    }
}