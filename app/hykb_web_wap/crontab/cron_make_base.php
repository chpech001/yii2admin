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
   //生成排行榜
     $tarr=array('expect','sugar','hot','manu','player');
	 $api_top=C::$api_top; 
	 foreach($tarr as $k=>$type){
        $view_url=Comm::get_view_url('top','top',array('type'=>$type));
	    $make_url=Comm::get_url('top',$type,array('view_ishtml'=>1));
        $html = Comm::curl_get($view_url,1800);
        $file = $make_url;
        if (strpos($file,$_sc_base_url)===0) {
            $file = str_replace($_sc_base_url,'',$file);
        }
       $r=Comm::make_html($file, $html);
	 }	 

   //生成新奇首页
 
	    $view_url = Comm::get_view_url('newness');
        $make_url = Comm::get_url('newness','',array('view_ishtml'=>1));
        $html = Comm::curl_get($view_url,1800);
        $file = $make_url;
        if (strpos($file,$_sc_base_url)===0) {
            $file = str_replace($_sc_base_url,'',$file);
        }
        $r=Comm::make_html($file, $html);
		/***
	   if($r['fullpath']){
	    chgrp($r['fullpath'],'nobody');
		chown($r['fullpath'],'nobody');
	   }
	   */
