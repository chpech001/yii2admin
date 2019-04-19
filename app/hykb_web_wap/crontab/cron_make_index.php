<?php
if ($_SERVER["REMOTE_ADDR"] <> $_SERVER["SERVER_ADDR"]) {
	echo "What Do u Want to do??";
	exit;
}

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
require INC_PATH.'/config.php';;//$_sc_root重写，写死路径
require INC_PATH.'/cls_comm.php';
require INC_PATH.'/cls_db.php';
$db = new DB(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,0);

$view_url = Comm::get_view_url('home');
$make_url = Comm::get_url('home','',array('view_ishtml'=>1));

$html = Comm::curl_get($view_url,10);
if (strlen($html)<500) {
    echo 'get content fail, return:'.$html.PHP_EOL;

    // 获取内容失败，重新获取
    echo 'reget content...'.PHP_EOL;
    $html = Comm::curl_get($view_url,10);
    if (strlen($html)<500) {
        Comm::log('cron_err_make_index_'.date("Ymd"),'生成失败；返回内容['.$html.']');
        die('make fail：'.$html.PHP_EOL);
    }
} 



$file = $make_url;
if (strpos($file,$_sc_base_url)===0) {
    $file = str_replace($_sc_base_url,'',$file);
}
$r = Comm::make_html($file, $html);

if ($r['fullpath']) {
    // 设置所属用户与组
    chgrp($r['fullpath'], 'www');
    chown($r['fullpath'], 'www');
}

echo 'index make success'.PHP_EOL;
$t = round(microtime(true) - $t1,2);
echo 'use time:'.$t.PHP_EOL;
