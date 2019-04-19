<?php
if ($_SERVER["REMOTE_ADDR"] <> $_SERVER["SERVER_ADDR"]) {
	//echo "What Do u Want to do??";
	//exit;
}
error_reporting(E_ALL^E_NOTICE);
header('content-type:text/html;charset=utf-8');
date_default_timezone_set("Asia/Shanghai");

if (is_dir('/www/t.news.4399.com')) {
    define('ROOT_PATH', '/www/t.3839.com');
    define('APP_PATH','/www/t.m.3839.com/app/hykb_web_wap');
} else {
    define('ROOT_PATH', '/www/m.3839.com');
    define('APP_PATH','/www/m.3839.com/app/hykb_web_wap');
}
$t1 = microtime(true);

define('WEB_ROOT', '/app/hykb_web_wap');
define('INC_PATH',APP_PATH.'/include');
define('TPL_PATH',APP_PATH.'/template/default');
require INC_PATH.'/config.php';;//$_sc_root重写，写死路径
require INC_PATH.'/cls_comm.php';
require INC_PATH.'/cls_db.php';
$db = new DB(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,0);
  $gamelist=array();
  $return = Comm::curl_get(C::$api_home);
  if(!$return) { die('首页接口获取失败'); }
  $return = json_decode($return,true);
  $result=$return['result'];
  if($return['code']!=100 || !$return['result']) {die('首页接口信息获取出错');}
  $slide = $result['slide'];
  if($slide['interface_type']==17){$gamelist[]=$slide['interface_id'];}
  $cnt=0;
  $datalist = $result['data'];
  foreach($datalist as $k=>$v){
    $type=$v['type'];
	if($type==0 && $cnt<=17){
	 $gamelist[]=$v['id'];
	 $cnt++;
	}
	if($type==99){
	  foreach($v['host_list'] as $k1=>$v1){
	   $gamelist[]=$v1['id'];
	  }
	}
  }
  $return1 = Comm::curl_get(C::$api_home_prom);
  if(!$return1) { die('首页广告接口失败'); }
  $return1 = json_decode($return1,true);
  $glist=$return1['gameinfo'];
  foreach($glist as $k3=>$v3){
    $gamelist[]=$v3['gameid'];
  }
  //获取排行榜游戏
  $type=array('expect','sugar','hot');
  $api_top=C::$api_top; 
  foreach($type as $v3){
   $get_api_top=str_replace('{type}',$v3,$api_top);
   $return=Comm::curl_get($get_api_top,60); 
   $return=json_decode($return,true);
   $list=$return['result']['data'];
   foreach($list as $k=>$v){
     if($k<30){
	   $gamelist[]=$v['id'];
	 }
   }
  }
  foreach($gamelist as $k=>$v){
   makeOneGameDetail($v);
  }
  

function makeOneGameDetail($id,$islog=false){
    global $_sc_base_url,$_sc_root;
    $id = intval($id);
    if ($id<=0) {
        return array('code'=>0,'msg'=>'gameid error');
    }

    $view_url = Comm::get_view_url('game_detail','',array('id'=>$id));
    $make_url = Comm::get_url('game_detail','',array('view_ishtml'=>1,'id'=>$id));
    
    $html = Comm::curl_get($view_url,10);
    if (strlen($html)<500) {
        if ($islog) Comm::log('cron_err_make_gamedetail_'.date("Ymd"),'生成失败,游戏ID['.$id.']：'.$html);
        return array('code'=>0,'msg'=>$html);
    } 

    $file = $make_url;
    if (strpos($file,$_sc_base_url)===0) {
        $file = str_replace($_sc_base_url,'',$file);
    }
    $r = Comm::make_html($file, $html);
   /***
    if ($r['fullpath']) {
        chown($r['fullpath'], 'nobody:nobody');//设置生成用户
    }
    */
    return array('code'=>1,'url'=>$_sc_base_url.$file);
}
