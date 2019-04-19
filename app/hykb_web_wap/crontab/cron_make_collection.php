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
       $api_collectionlist=C::$api_collection_recent;
	   for($p=1;$p<=100;$p++){
	     $gapi=str_replace('{p}',$p,$api_collectionlist);
		 $return=Comm::curl_get($gapi,12); 
		 if(!$return){die("获取合辑接口数据失败");}
		 $return=json_decode($return,true);
	     if($return['code']!=100 || empty($return['result'])){
	     die("获取合辑列表详情失败");
		 }
		 $all=$return['result']['data']['all']['list'];
		 if(empty($all)){break;}
		 foreach($all as $k=>$v){
		   makeOnecollectionAction($v['id']);
		 }
	   } 	
	   
	      
	//生成单个合辑的详情
	function makeOnecollectionAction($id){
	    global $_sc_base_url,$sc_base_url;
	    $view_url = Comm::get_view_url('coll','arcdetail',array('id'=>$id));
        $make_url = Comm::get_url('coll','detail',array('view_ishtml'=>1,'id'=>$id));
        $html = file_get_contents($view_url);
        if (strlen($html)<500) {
		       // $msg='合辑id:'.$id." 生成失败";
				//Comm::log('cron_err_make_onecollection',$msg);
				return false;
        } 

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
	}
