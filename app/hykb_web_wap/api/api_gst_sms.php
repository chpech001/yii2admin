<?php 
/**
 * ���ŷ��͵Ľӿڡ�
 * 
 * ��Ҫ���ܣ�
 * ˵�������ͼ�ʱ����ʱ���������ֻ��ŷ��͡�����಻�ܳ���200����
 * 
 * ���÷�ʽ
 *      ���Ե�ַ��http://t.huodong.4399.com/sms/api_sms.php?sign=hykb&phone=15959206416&msg=iphone&from=hd_wzlm_yuyue
 *      ���ϵ�ַ��http://huodong2.4399.com/sms/api_sms.php?sign=hykb&phone=15959206416&msg=iphone&from=hd_wzlm_yuyue
 * ����˵����
 *       sign   ǩ��
 *       phone  �ֻ���
 *       msg    ������Ϣ
 *       from   ��Դ��Ϣ
 * 
 *  @author ���ղ�
 *  @version     1.0.0.0
 *
 */

    //IP����
    $ips = array(
        "115.182.52.77",
        "115.238.73.149",
        "115.238.73.89",
        "115.182.10.21",
        "115.182.10.22",
    );

    //ǩ��
    $sign_deny = array(
        "huodong"=>"�������žš�",
        "hykb"=>"�����ο챬��",
    );
    /****
    if(!in_array($_SERVER['REMOTE_ADDR'],$ips)){
        die("deny ip");
    }
    */
    require '../common.php';

    //�ж�ǩ��
    $sign = $_GET['sign'];
    if(!$sign_deny[$sign]){
        info(10004,"ǩ��������");
        die();
    }

    //�ж���Դ
    $from = $_GET['from']; 
    preg_replace("/[^a-z_0-9]+/is","_",$from);
    if(!$from){
        info(10005,"��Դ��Ϣûд");
        die();
    }


    //�ж��ֻ��ţ�֧�ֶ���ֻ��ŷ���
    $phone = $_GET['phone'];
    if(!$phone){
        info(10001,"û���ֻ���");
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
        info(10001,"�ֻ��Ŵ���");
        die();
    }
    $phone = $temp;

    //IP
    $ip = $_GET['ip'];
    if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/is",$ip)){
        $ip = Comm::get_online_ip();
    }

    //�жϷ�����Ϣ
    $msg = $_GET['msg'];
    if(!$msg){
        info(10003,"û����Ϣ");
        die();
    }
    $msg = preg_replace("/php|exec|system|select|union|grant|union|insert|alert|like|drop|create|drop|modify|join/is"," ",$msg);
    $msg = mb_substr($msg,0,460,"gbk");
    //������Ϣ��
    include "api_gst_sms_class.php";
    $msg =$msg;
    $smsObj = SMS::getinstance($from);
    $result = $smsObj->sendSMS($phone,$msg);
    info($result['code'],$result['msg']);

    function info($code,$msg){
        echo json_encode(array("code"=>$code,"msg"=>iconv("gbk","utf-8",$msg)));
        die();
    }