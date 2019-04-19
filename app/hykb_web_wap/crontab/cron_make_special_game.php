<?php

# 0 0 * * * /usr/local/php/bin/php /www/m.3839.com/app/hykb_web_wap/crontab/cron_make_special_game.php
/***
if ($_SERVER["REMOTE_ADDR"] <> $_SERVER["SERVER_ADDR"]) {
	echo "What Do u Want to do??";
	exit;
}
*/
error_reporting(E_ALL^E_NOTICE);
header('content-type:text/html;charset=utf-8');
date_default_timezone_set("Asia/Shanghai");

if (is_dir('/www/t.news.4399.com')) {
    define('ROOT_PATH', '/www/t.m.3839.com');
    define('APP_PATH','/www/t.m.3839.com/app/hykb_web_wap');
} else {
    define('ROOT_PATH', '/www/m.3839.com');
    define('APP_PATH','/www/m.3839.com/app/hykb_web_wap');
}
$t1 = microtime(true);
define('WEB_ROOT', substr(APP_PATH,strlen(ROOT_PATH)));
define('INC_PATH',APP_PATH.'/include');
define('TPL_PATH',APP_PATH.'/template/default');
require INC_PATH.'/config.php';
require INC_PATH.'/cls_comm.php';
require INC_PATH.'/cls_db.php';
//$special_ids=array('88149','105476');
$db = new DB(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,0);
 $sql = "SELECT * FROM  hykb_web_sysinfo WHERE code='specialgame' LIMIT 1";
 $rs = $db->get_one($sql);
 $special_ids=explode(",",$rs['data']);
foreach($special_ids as $id){
  $r=makeOneGameDetail($id);
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

    //Comm::updatePush($id,time()); // 更新push表

    if ($r['fullpath']) {
        // 设置所属用户与组
        //chgrp($r['fullpath'], 'www');
        //chown($r['fullpath'], 'www');
    }

    return array('code'=>1,'url'=>$_sc_base_url.$file);
}