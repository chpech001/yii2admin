<?php
// 游戏详情页百度熊掌号定时新增推送
# 0 0 * * * /usr/local/php/bin/php /www/m.3839.com/app/hykb_web_wap/crontab/cron_baidu_xzh_push_new.php
if ($_SERVER["REMOTE_ADDR"] <> $_SERVER["SERVER_ADDR"]) {
	echo "What Do u Want to do??";
	exit;
}

if (is_dir('/www/t.news.4399.com')) {
    define('APP_PATH','/www/t.m.3839.com/app/hykb_web_wap');
} else {
    define('APP_PATH','/www/m.3839.com/app/hykb_web_wap');
}
require APP_PATH.'/include/config.php';
require APP_PATH.'/include/cls_db.php';
require APP_PATH.'/include/cls_comm.php';
// 连接数据库
$db = new DB(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,0);

$mem = new memcache;
$mem->connect(MEM_HOST,MEM_PORT);

$per_num = 10;//单次推送数
$new_remain_key = 'hykb_wap_baiduxzh_new_remain';
$new_remain = $mem->get($new_remain_key);//熊掌号今日剩余条数

if ($new_remain === false) {
    
} elseif ($new_remain == 0) {
    // 今日最新额度已用完
    die('');
}

$new_remain = intval($new_remain);
if ($new_remain && $per_num > $new_remain) $per_num = $new_remain;


$timeStart = microtime(true);
echo 'start:'.date('Y-m-d H:i:s').PHP_EOL;

// 获取今日要推送的游戏
$today_time = strtotime(date('Y-m-d',time()));
$min_time = strtotime('2018-09-29 15:58:10');

if ($today_time<$min_time) $today_time = $min_time;

$sql = "SELECT * FROM ".C::$table_game_push." WHERE push=0 AND addtime>='{$today_time}' ORDER BY addtime DESC LIMIT {$per_num} ";
$query = $db->query($sql);
$push = array();
$c1 = $c2 = 0;
while($rs=mysql_fetch_assoc($query)) {
    $gameurl = Comm::getGamePushUrl($rs['gameid']);
    $gamepath = $_sc_root.str_replace('https://m.3839.com','',$gameurl);
    if (is_file($gamepath)) {
        if (!$rs['filemtime']) {
            $db->query("UPDATE ".C::$table_game_push." SET filemtime='".filemtime($gamepath)."' WHERE gameid='".$rs['gameid']."' ");
            $c1++;
        }
        $push[$rs['gameid']] = $rs['gameurl'];
    } else {
        if ($rs['filemtime']) {
            $db->query("UPDATE ".C::$table_game_push." SET filemtime=0 WHERE gameid='".$rs['gameid']."' ");
            $c2++;
        }
    }
}
// print_r($push);
if ($push) {
    echo "start push new (".count($push)."):".join(',',array_keys($push)).PHP_EOL;
	$result = push_new($push);
	echo 'push result:'.$result.PHP_EOL;
	$result = json_decode($result,true);
	if(intval(@$result['success_realtime'])){
		$push_type = 1;
		$result['success_realtime'] = intval($result['success_realtime']);
		if ($result['success_realtime'] < count($push)) {
			$push_type = 3;
		}
		
		$q = "UPDATE ".C::$table_game_push." SET `push`=".time().",`push_type`='{$push_type}' WHERE `gameid` IN (".join(',',array_keys($push)).")";
		$db->query($q);
		echo 'push success(new):'.mysql_affected_rows().PHP_EOL;

        
    }
    if (isset($result['remain_realtime'])) {
        $remain_realtime = intval($result['remain_realtime']);
        $mem->set($new_remain_key,$remain_realtime,0,$today_time+86400);
    }
}

echo 'end:'.date('Y-m-d H:i:s')."\r\nUSE TIME : ".round(microtime(true)-$timeStart,2)."\r\n";
echo "\r\n\r\n";

function getGamePath($gameid) {
    global $_sc_base_url,$_sc_root;
    $gameurl_0 = Comm::get_url('game_detail','',array('view_ishtml'=>1,'id'=>$id));
    $gameurl_0 = str_replace($_sc_base_url,'',$gameurl_0);
    // $gameurl = 'https://m.3839.com'.$gameurl_0;
    $gamepath = $_sc_root.$gameurl_0;
    return $gamepath;
}

function push_new($urls) {
    $api = 'http://data.zz.baidu.com/urls?appid=1604934640021042&token=IpSUpgMf80DpGc07&type=realtime';
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