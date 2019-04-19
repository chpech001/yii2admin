<?php
defined('APP_PATH') or exit('Access Denied');
class baiduxzh extends Controller {

    // 推送记录
    function pushHistoryAction() {
        global $db;
        $sql = "SELECT * FROM ".C::$table_game_push." WHERE push>0 ORDER BY push DESC LIMIT 400";
        $query = $db->query($sql);
        $list = array();
        while($rs=mysql_fetch_assoc($query)) {
            $list[] = $rs;
        }
        include ADMIN_TPL_PATH.'/baiduxzh_push_history.php';
    }

    // 历史手动推送
    function oldPushAction(){
        global $db,$_sc_root;
        if ($_REQUEST['type']=='dopush') {
            $urls = trim($_POST['urls']);
            if (!$urls) {
                die("地址不能为空");
            }
            $urls = explode(PHP_EOL,$urls);
            $push = array();
            foreach($urls as $v){
                $v = trim($v);
                if (stripos($v,'m.3839.com')===0){
                    $v = 'https://'.$v;
                }
                if (!preg_match('/^https:\/\/m\.3839\.com/i',$v)){
                    die('地址错误：'.$v);
                }
                $push[] = $v;
            }
            
            if (!$push){
                die('没有要推送的地址');
            }
            
            $flag_err = false;
            $str_err = '';
            foreach($push as $v) {
                $filename = $_sc_root.str_replace('https://m.3839.com','',$v);
                if(!is_file($filename)){
                    $flag_err = true;
                    $str_err .= $v.'[文件不存在]'.'<br>';
                }
            }
            if ($flag_err){
                die($str_err);
            }
            $str = '';
            if ($push) {
                $str .= '<br>'."开始push（历史）".count($push)."个:<br>".implode('<br>',$push).'<br><br>';
                $result = $this->push_old($push);
                $str .= 'push结果（历史）:<br>'.$result.'<br>';
                if(intval(@$result['success_batch'])){
                    $remain_batch = intval($result['remain_batch']);
                    if ($remain_batch<=0) {
                        $str .= '今日额度已用完'.'<br>';
                    }
                }
            }
            echo $str;

            die('<a href="?m=baiduxzh&ac=old_push">点击返回</a>');
        } else {

        }
        include ADMIN_TPL_PATH.'/baiduxzh_old_push.php';
    }

    function push_old($urls) {
        $api = 'http://data.zz.baidu.com/urls?appid=1604934640021042&token=IpSUpgMf80DpGc07&type=batch';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        // print_r($urls);
        // exit;
        $result = curl_exec($ch);
        return $result;
    }
	
	//熊掌号设置
	function setAction(){
	  $setfile=APP_PATH.'/setsem.txt';
	  $arr=unserialize(file_get_contents($setfile));
	  include ADMIN_TPL_PATH.'/baiduxzh_set.php';
	}
	function setcityAction(){
	   $setfile=APP_PATH.'/setsem.txt';
	   $arr=unserialize(file_get_contents($setfile));
	   $city=$_POST['city'];
	   $acity=array();
	   foreach($city as $k=>$v){
	     if(!empty($v)){$acity[$k]=$v;}
	   }
	   $arr['city']=$acity;
	   file_put_contents($setfile,serialize($arr));
	   $this->jsAlert('添加成功', "?m=baiduxzh&ac=set");
	}
  
 	function setshowAction(){
	   $setfile=APP_PATH.'/setsem.txt';
	   $arr=unserialize(file_get_contents($setfile));
       $showbtn=(int) $_POST['showbtn'];
	   $showwin=(int) $_POST['showwin'];
	   $showyz=(int) $_POST['showyz'];
	   $showbtn1=(int) $_POST['showbtn1'];
	   $showwin1=(int) $_POST['showwin1'];
	   $showyz1=(int) $_POST['showyz1'];  
	   $ycontent=$_POST['ycontent'];
	   if(get_magic_quotes_gpc()){
	    $ycontent=stripslashes($ycontent);
	   }
	   $arr['show']['showbtn']=$showbtn;
	   $arr['show']['showwin']=$showwin;
	   $arr['show']['showyz']=$showyz;
	   $arr['show']['showbtn1']=$showbtn1;
	   $arr['show']['showwin1']=$showwin1;
	   $arr['show']['showyz1']=$showyz1;	   
	   $arr['show']['ycontent']=htmlspecialchars($ycontent);	
	   file_put_contents($setfile,serialize($arr));
	   $this->jsAlert('添加成功', "?m=baiduxzh&ac=set");
	} 	  
}
