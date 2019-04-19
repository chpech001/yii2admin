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

$per_num = 300;//单次推送数
$new_remain_key = 'hykb_wap_baiduxzh_new_remain';
// $mem->set($new_remain_key,0,0,time()+60);
// $mem->delete($new_remain_key);
$new_remain = $mem->get($new_remain_key);//熊掌号今日新增剩余条数
$new_isover = 0;
if ($new_remain !== false) {
    $new_remain = intval($new_remain);
    if ($new_remain == 0) {
        $new_isover = 1;
    }
}

$timeStart = microtime(true);
echo 'start:'.date('Y-m-d H:i:s').PHP_EOL;

// 获取要推送的游戏
$today_time = strtotime(date('Y-m-d',time()));
if ($new_isover) {
    // 今日新增配额已用完,获取含今日游戏的进行推送
    $sql = "SELECT * FROM ".C::$table_game_push." WHERE push=0 AND addtime<'".($today_time+86400)."' ORDER BY addtime DESC LIMIT {$per_num} ";
} else {
    $sql = "SELECT * FROM ".C::$table_game_push." WHERE push=0 AND addtime<'{$today_time}' ORDER BY addtime DESC LIMIT {$per_num} ";
}

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

if ($push) {
    echo "start push old (".count($push)."):".join(',',array_keys($push)).PHP_EOL;
	$result = push_old($push);
	echo 'push result:'.$result.PHP_EOL;
	$result = json_decode($result,true);
	if(intval(@$result['success_batch'])){
		$push_type = 2;
		$result['success_batch'] = intval($result['success_batch']);
		if ($result['success_batch'] < count($push)) {
			$push_type = 5;
		}
		
		$q = "UPDATE ".C::$table_game_push." SET `push`=".time().",`push_type`='{$push_type}' WHERE `gameid` IN (".join(',',array_keys($push)).")";
		$db->query($q);
		echo 'push success(old):'.mysql_affected_rows().PHP_EOL;
    }
}

echo 'end:'.date('Y-m-d H:i:s')."\r\nUSE TIME : ".round(microtime(true)-$timeStart,2)."\r\n";
echo "\r\n\r\n";

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