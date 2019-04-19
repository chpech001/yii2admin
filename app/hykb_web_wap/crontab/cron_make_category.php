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

//Comm::log('cron__make_allcategory','生成所有分类详情开始');
     /***
      $return=Comm::curl_get(C::$api_category,1800); 
	   if(!$return){die("获取分类详情接口数据失败");}
	   $return=json_decode($return,true);
	   if($return['code']!=100 || empty($return['result'])){
	    die("获取分类详情失败失败");
	   }
	   $catlist=$return['result']['category'];	
	   foreach($catlist as $k=>$v){
	     foreach($v['data'] as $k1=>$v1){
		   $id=$v1['id'];
		   makeOnecategoryAction($id);

		 }
	   } 
	   */
	   for($kn=1;$kn<=300;$kn++){
	     makeOnecategoryAction($kn);
	   }
//Comm::log('cron__make_allcategory','生成所有分类详情结束');
function makeOnecategoryAction($id){
         global $_sc_base_url,$sc_base_url;
	    $typemode=array('hot','new','star');
		foreach($typemode as $type){
	    	$view_url = Comm::get_view_url('category','categorydetail',array('id'=>$id,'type'=>$type));
            $make_url = Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$id,'type'=>$type)); 
			$html=Comm::curl_get($view_url,1800);
			if (strlen($html)<500) {
			    $msg='分类id:'.$id." 生成失败";
				Comm::log('cron_err_make_onecategory',$msg);
				return false;
				//die('文件内容获取失败：'.$html);
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
}












