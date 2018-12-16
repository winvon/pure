<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/2
 * Time: 11:20
 */

namespace common\components;


class Mobile
{
    public static function sendtomobile($code, $mobile, $type, $exp = "")
    {
        return self::tuobao($code, $mobile, $type, $exp);
    }

    public static function tuobao($code, $mobile, $type, $exp)
    {
        $code = self::trimall($code);
        $Account = 'C49145582';
        $Password = 'b60f6eb4517815e516e79cc40d03b95c';
        $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
        //短信注册验证码
        switch ($type) {
            case 1:
                $message=  "您的验证码是：".$code."。请不要把验证码泄露给其他人。";
                break;
            case 2:  //平台设置服务站的仓储费 To 平台
                $message = $message = "请设置服务站" . $exp . "的仓储费";
                break;
            case 3://服务站处理托盘入托申请单 To 服务站
                $message = "您有一个注册申请单（".$code."）需要处理，详情登录集托网服务站app查看。";
                break;
            case 4: //平台处理线下支付 To 平台
                $message = "订单:$code 已经上传支付凭证，请确认";
                break;
            case 5: //服务站处理出库申请单 To 服务站主账号
                $message = "您有一个租赁订单（".$code."）需要处理，详情登录集托网服务站app查看。";
                break;
            case 6: //服务站入处理入库申请单 To 服务站操作账号
                $message = "您有一个还盘申请单（".$code."）需要处理，详情登录集托网服务站app查看。";
                break;
            case 7: //服务站同意入托单 To 出租商操作账号
                $message = "您的注册申请单（".$code."）已通过审核。详情登录集托网app查看。";
                break;
            case 8://服务站拒绝托盘入托申请 To 出租商
                $message = "您的注册申请单（".$code."）已被驳回。详情登录集托网app查看。";
                break;
            case 9://服务站同意托盘出库申请 To 承租商
                $message = "您的租赁申请（".$code."）已通过审核。详情登录集托网app查看。";
                break;
            case 10: //服务站拒绝托盘出库申请  To 承租商
                $message = "您的租赁申请（".$code."）已被驳回。详情登录集托网app查看。";
                break;
            case 11: //服务站同意托盘入库申请  To 承租商
                $message= "您的还盘申请（".$code."）已通过审核。详情登录集托网app查看。";
                break;
            case 12: //服务站拒绝托盘入库申请  To 承租商
                $message="您的租赁申请（".$code."）已被驳回。详情登录集托网app查看。";
                break;
            case 13://服务站提交定损 To 出租商主账号
                $message = "您有托盘报修定损需要处理，详情登录集托网app查看。";
                break;
            case 14://服务站报废通知 To 出租商主账号
                $message = "您有托盘已报废，平台将处理赔付。详情登录集托网app查看。";
                break;
            case 15://服务站/承租商提交报失 To 出租商主账号
                $message = "您有托盘已报失，平台将处理赔付。详情登录集托网app查看。";
                break;
            case 16://承租商提交订单 To 承租商管理员及操作账号：
                $message = "您提交了托盘租赁申请($code)，请确认为企业授权操作。详情登录集托网app查看。";
                break;
            case 17://承租商提交订单 To 承租商管理员及操作账号：
                $message = "您提交了托盘租赁申请($code)，请确认为企业授权操作。详情登录集托网app查看。";
                break;
        }

        $post_data = "account=$Account&password=$Password&mobile=" . $mobile . "&content=" . rawurlencode($message);

        //密码可以使用明文密码或使用32位MD5加密

        $get = self::Post($post_data, $target);

        $result = self::xml_to_array($get);

        if ($result['SubmitResult']['code'] != 2) {
            $result2['phone'] = $mobile;

            $result2['code'] = $result['SubmitResult']['code'];

            $result2['message'] = $result['SubmitResult']['msg'];
            return $result2;
        }

        return $result;

    }

    static function Post($curlPost, $url)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_HEADER, false);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_NOBODY, true);

        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);

        $return_str = curl_exec($curl);

        curl_close($curl);

        return $return_str;
    }

    static function trimall($str)
    {
        $qian = array(" ", "　", "\t", "\n", "\r");
        $hou = array("", "", "", "", "");
        return str_replace($qian, $hou, $str);
    }

    static function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = self::xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }


    /**
     * 检查手机号码格式
     * @param $mobile 手机号码
     */
    static function check_mobile($mobile)
    {
        if (preg_match('/1[34578]\d{9}$/', $mobile))
            return true;
        return false;
    }
}