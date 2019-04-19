<?php 
/**
 * 短信发送的接口。
 * 
 * 主要功能：
 * 说明：发送即时短信时，允许多个手机号发送。但最多不能超过200个。
 * 
 * 调用方式
 *      测试地址：http://t.huodong.4399.com/sms/api_sms.php?sign=hykb&phone=15959206416&msg=iphone&from=hd_wzlm_yuyue
 *      线上地址：http://huodong2.4399.com/sms/api_sms.php?sign=hykb&phone=15959206416&msg=iphone&from=hd_wzlm_yuyue
 * 参数说明：
 *       sign   签名
 *       phone  手机号
 *       msg    发送信息
 *       from   来源信息
 * 
 *  @author 翁艺财
 *  @version     1.0.0.0
 *
 */

    //IP限制
    $ips = array(
        "115.182.52.77",
        "115.238.73.149",
        "115.238.73.89",
        "115.182.10.21",
        "115.182.10.22",
    );

    //签名
    $sign_deny = array(
        "huodong"=>"【四三九九】",
        "hykb"=>"【好游快爆】",
    );
    /****
    if(!in_array($_SERVER['REMOTE_ADDR'],$ips)){
        die("deny ip");
    }
    */
    require '../common.php';

    //判断签名
    $sign = $_GET['sign'];
    if(!$sign_deny[$sign]){
        info(10004,"签名不存在");
        die();
    }

    //判断来源
    $from = $_GET['from']; 
    preg_replace("/[^a-z_0-9]+/is","_",$from);
    if(!$from){
        info(10005,"来源信息没写");
        die();
    }


    //判断手机号，支持多个手机号发送
    $phone = $_GET['phone'];
    if(!$phone){
        info(10001,"没有手机号");
        die();
    }

    $phone = explode("|",$phone);
    $temp = array();
    foreach($phone as $k=>$v){
        if(preg_match("/^((13|14|15|18|17)[0-9]{1}\d{8})$/",$v)){
            $temp[] = $v;
        }
    }

    if(count($temp)==0){
        info(10001,"手机号错误");
        die();
    }
    $phone = $temp;

    //IP
    $ip = $_GET['ip'];
    if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/is",$ip)){
        $ip = Comm::get_online_ip();
    }

    //判断发送信息
    $msg = $_GET['msg'];
    if(!$msg){
        info(10003,"没有信息");
        die();
    }
    $msg = preg_replace("/php|exec|system|select|union|grant|union|insert|alert|like|drop|create|drop|modify|join/is"," ",$msg);
    $msg = mb_substr($msg,0,460,"gbk");
    //发送信息。
    include "api_gst_sms_class.php";
    $msg =$msg;
    $smsObj = SMS::getinstance($from);
    $result = $smsObj->sendSMS($phone,$msg);
    info($result['code'],$result['msg']);

    function info($code,$msg){
        echo json_encode(array("code"=>$code,"msg"=>iconv("gbk","utf-8",$msg)));
        die();
    }