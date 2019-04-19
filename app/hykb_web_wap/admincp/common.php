<?php
error_reporting(E_ALL^E_NOTICE);
header('content-type:text/html;charset=utf-8');
date_default_timezone_set("Asia/Shanghai");
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
header('Pragma:no-cache');
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define('APP_PATH',str_replace('\\','/',dirname(dirname(__FILE__))));
define('WEB_ROOT', substr(APP_PATH,strlen(ROOT_PATH)));
define('INC_PATH',APP_PATH.'/include');
define('ADMIN_TPL_PATH',APP_PATH.'/template/admin');

// 登录判断
define('LOGIN_PASSWORD','YUUI^#@jOIUIEE');
require INC_PATH.'/checkLogin.func.php';

require INC_PATH.'/config.php';
require INC_PATH.'/cls_comm.php';
require INC_PATH.'/cls_controller.php';
require INC_PATH.'/cls_db.php';

$db = new DB(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,0);
