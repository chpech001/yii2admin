<?php
header('content-type:text/html;charset=utf-8');
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define('APP_PATH', dirname(__FILE__));
define('TPL_PATH', APP_PATH . '/tpl/');
define('MEM_PRE', 'hykb_arc_share_wap');
define('TEST', is_dir('/www/t.news.4399.com/') ? TRUE : FALSE);
define('KB_ID', 84974);
define('VERSION', 'v2');

require_once ROOT_PATH . '/app/include/news_db_slave_config.php';
require_once ROOT_PATH . '/app/include/class.mysql.php';

$db = new DB(DB_NEWS_HOST, DB_NEWS_USER, DB_NEWS_PASSWORD, DB_NEWS_NAME, 0);//正式服
if(TEST){
    $wapUrl = 'http://t.news.4399.com/hykb/static/hykb_web_wap/';
} else {
    $wapUrl = '//newsimg.5054399.com/hykb/static/hykb_web_wap/';
}

$mem = new Memcache();
$mem->connect(MEM_HOST, MEM_PORT);

require_once APP_PATH . '/function.php';