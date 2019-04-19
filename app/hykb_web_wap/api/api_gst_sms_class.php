<?php 
/**
 * 深圳市高斯通信息  短信发送的接口。
 * 
 * 主要功能： 
 *      1、发送即时短信；（已实现）
 *      2、发送定时短信的；（已实现）
 *
 * 说明：
 *      1、发送即时短信时，允许多个手机号发送。但最多不能超过100个。
 *      2、发送限时短信时，10分钟内只能发送3条。如果超过，但不影响正常发送，但手机短信接收不到。
 * 
 * 调用方式
 *      $smsObj = SMS::getinstance($source);  
 *      $smsObj->sendSMS($phone,$msg,$presendTime);
 *
 * 功能开发时间表：
 *      1、2017-12-07    实现发送限时短信功能，记录短信发送日志。
 * 
 *  @author 翁艺财
 *  @version     1.0.0.0
 *
 */

class SMS{
    static $instance=null;

    //日志类
    private $smsLogClass = null;

    //接口链接
    private $urls = array(
        //即时短信的链接
        "sendsms"=>"http://gateway.iems.net.cn/GsmsHttp"
    );

    //关键数据
    private $screte_data = array(
        'username'=>"70955:kb3839",
        'password'=>"FbhXRfRYMhK2",
    );

    //单例
    static function getinstance($source=''){
        if(!$source){
            die("none source");
        }
        if(!self::$instance){
            self::$instance = new SMS($source);
        }
        return self::$instance;
    }

    function __construct($source){
        $this->smsLogClass = SmsLog::getinstance($source);
    }
    
    //发送即时短信的请求
    function sendSMS($phone="",$msg="",$presendTime=""){
        if(!$phone){
            return "error_empty_phone";
        }

        //判断是否是数组
        if(is_array($phone)){
            $temp = array();
            foreach($phone as $k=>$v){
                if(preg_match("/^1(3[0-9]|4[145678]|5[012356789]|66|7[012345678]|8[0-9]|98|99)[0-9]{8}$/",$v)){
                    $temp[] = $v;
                }
            }
            if(count($temp)==0){
                die("error_empty_phones");
            }
            $temp = array_slice($temp,0,100);
            $phone = implode(",",$temp);

        }else{
            if(!preg_match("/^1(3[0-9]|4[145678]|5[012356789]|66|7[012345678]|8[0-9]|98|99)[0-9]{8}$/",$phone)){
                return "error_phone";
            }
        }

        if(!$msg){ return "error_msg";}

        $data = array(
            "username"=>$this->screte_data['username'],
            "password"=>$this->screte_data['password'],
            "to"=>$phone,
            "content"=>$msg,
        );

        if($presendTime && preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/is",$presendTime)){
            $data['presendTime'] = $presendTime;
        }

        $url = $this->urls['sendsms'];
        $url .= "?".http_build_query($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT,10);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($curl);
        curl_close($curl);
        $result = $this->smsLogClass->formatLog($content);
        $this->smsLogClass->saveLog($phone,$result['code'],$result['msg'],$msg,"sendsms");
        return $result;
    }

}

/**
 *  SMS发送日志记录记录。
 */
class SmsLog{
    static $instance=null;
    private $table = "cpp_gst_sms_log";
    private $source = '';
    private $db = null;

    //错误信息。
    private $smsLogErrorData = array(
        "OK"=>"发送成功",
        "ERROR:eUser"=>"用户名称有误",
        "ERROR:eDate"=>"预发送时间格式不对",
        "ERROR:eIllegalPhone"=>"发送号码错误",
        "ERROR:ePassword"=>"密码错误",
        "ERROR:eStop"=>"用户已经停用",
        "ERROR:eDenyDate"=>"帐户过期",
        "ERROR:eBalance"=>"余额不足",
        "ERROR:eFrequent"=>"表示请求频繁",
        "ERROR:eContentLen"=>"短信内容超长",
        "ERROR:nContent"=>"短信内容为空",
        "ERROR:eContentWrong"=>"表示短信模板拦截",
        "ERROR:IPWrong"=>"客户连接IP与报备IP不符",
        "ERROR:eVoice"=>"没有语音通道",
        "ERROR:eVoiceVCode"=>"没有语音验证码通道",
        "ERROR:eContentVCode"=>"验证码只能是10位以内的英文字母或是数字",
        "ERROR"=>"不可预知的错误"
    );

    //单例
    static function getinstance($source){
        if(!self::$instance){
            self::$instance = new SmsLog($source);
        }
        return self::$instance;
    }

    function __construct($source=''){
        $GLOBALS['db'] && $this->db = $GLOBALS['db'];
        $source && $this->source = $source;
    }


    //格式化sms返回过来的信息。提取error值。
    function formatLog($result){
        $result = trim($result);
        $temp = explode(":",$result);
        $error_msg = "";
        switch($temp[0]){
            case "OK":$error_msg = "发送成功";break;
            case "ERROR":
                $error_msg = $this->smsLogErrorData['ERROR'];
                if(isset($this->smsLogErrorData[$result])){
                    $error_msg = $this->smsLogErrorData[$result];
                }
                break;
            default:
                $error_msg = "不可控的错误";
                $temp[0] = 'ERROR_DEFAULT';
        }
        return array(
            "code_full"=>$result,
            "code"=>$temp[0],
            "msg"=>"【".$result."】".$error_msg,
        );
    }

    //保存日志
    function saveLog($phone,$error_code,$result,$content,$mode='sendsms'){

        if(!$this->db){
            return "error_db";
        }
        if(!$this->source){
            return "error_source";
        }

        if(!$phone){
            return "error_empty_phone";
        }

        if($result==''){
            return "error_result";
        }

        if($GLOBALS['ip']){
            $ip = $GLOBALS['ip'];
        }else{
            $ip = get_online_ip();
        }

        $time = time();
        $day = date("Ymd");
        $sql = "insert into ".$this->table."(phone,time,day,ip,mode,source,error_code,content,result) values";
        $sql .= "(";
        $sql .= "'".$phone."',";
        $sql .= "'".$time."',";
        $sql .= "'".$day."',";
        $sql .= "'".$ip."',";
        $sql .= "'".$mode."',";
        $sql .= "'".$this->source."',";
        $sql .= "'".$error_code."',";
        $sql .= "'".mysql_escape_string($content)."',";
        $sql .= "'".$result."'";
        $sql .= ")";
        $this->db->query($sql);
        return "ok";
    }
}