<?php 
/**
 * �����и�˹ͨ��Ϣ  ���ŷ��͵Ľӿڡ�
 * 
 * ��Ҫ���ܣ� 
 *      1�����ͼ�ʱ���ţ�����ʵ�֣�
 *      2�����Ͷ�ʱ���ŵģ�����ʵ�֣�
 *
 * ˵����
 *      1�����ͼ�ʱ����ʱ���������ֻ��ŷ��͡�����಻�ܳ���100����
 *      2��������ʱ����ʱ��10������ֻ�ܷ���3�����������������Ӱ���������ͣ����ֻ����Ž��ղ�����
 * 
 * ���÷�ʽ
 *      $smsObj = SMS::getinstance($source);  
 *      $smsObj->sendSMS($phone,$msg,$presendTime);
 *
 * ���ܿ���ʱ���
 *      1��2017-12-07    ʵ�ַ�����ʱ���Ź��ܣ���¼���ŷ�����־��
 * 
 *  @author ���ղ�
 *  @version     1.0.0.0
 *
 */

class SMS{
    static $instance=null;

    //��־��
    private $smsLogClass = null;

    //�ӿ�����
    private $urls = array(
        //��ʱ���ŵ�����
        "sendsms"=>"http://gateway.iems.net.cn/GsmsHttp"
    );

    //�ؼ�����
    private $screte_data = array(
        'username'=>"70955:kb3839",
        'password'=>"FbhXRfRYMhK2",
    );

    //����
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
    
    //���ͼ�ʱ���ŵ�����
    function sendSMS($phone="",$msg="",$presendTime=""){
        if(!$phone){
            return "error_empty_phone";
        }

        //�ж��Ƿ�������
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
 *  SMS������־��¼��¼��
 */
class SmsLog{
    static $instance=null;
    private $table = "cpp_gst_sms_log";
    private $source = '';
    private $db = null;

    //������Ϣ��
    private $smsLogErrorData = array(
        "OK"=>"���ͳɹ�",
        "ERROR:eUser"=>"�û���������",
        "ERROR:eDate"=>"Ԥ����ʱ���ʽ����",
        "ERROR:eIllegalPhone"=>"���ͺ������",
        "ERROR:ePassword"=>"�������",
        "ERROR:eStop"=>"�û��Ѿ�ͣ��",
        "ERROR:eDenyDate"=>"�ʻ�����",
        "ERROR:eBalance"=>"����",
        "ERROR:eFrequent"=>"��ʾ����Ƶ��",
        "ERROR:eContentLen"=>"�������ݳ���",
        "ERROR:nContent"=>"��������Ϊ��",
        "ERROR:eContentWrong"=>"��ʾ����ģ������",
        "ERROR:IPWrong"=>"�ͻ�����IP�뱨��IP����",
        "ERROR:eVoice"=>"û������ͨ��",
        "ERROR:eVoiceVCode"=>"û��������֤��ͨ��",
        "ERROR:eContentVCode"=>"��֤��ֻ����10λ���ڵ�Ӣ����ĸ��������",
        "ERROR"=>"����Ԥ֪�Ĵ���"
    );

    //����
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


    //��ʽ��sms���ع�������Ϣ����ȡerrorֵ��
    function formatLog($result){
        $result = trim($result);
        $temp = explode(":",$result);
        $error_msg = "";
        switch($temp[0]){
            case "OK":$error_msg = "���ͳɹ�";break;
            case "ERROR":
                $error_msg = $this->smsLogErrorData['ERROR'];
                if(isset($this->smsLogErrorData[$result])){
                    $error_msg = $this->smsLogErrorData[$result];
                }
                break;
            default:
                $error_msg = "���ɿصĴ���";
                $temp[0] = 'ERROR_DEFAULT';
        }
        return array(
            "code_full"=>$result,
            "code"=>$temp[0],
            "msg"=>"��".$result."��".$error_msg,
        );
    }

    //������־
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