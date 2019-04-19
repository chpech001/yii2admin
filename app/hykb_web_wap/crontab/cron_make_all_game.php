<?php

# 0 0 * * * /usr/local/php/bin/php /www/m.3839.com/app/hykb_web_wap/crontab/cron_make_all_game.php

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
require INC_PATH.'/config.php';
require INC_PATH.'/cls_comm.php';
require INC_PATH.'/cls_db.php';
$db = new DB(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,0);

//获取接口游戏ID
$ids = getApiGameIds();
if (!$ids) die('get Api Game Ids fail')."\n";


echo 'tongbu IDs...'."\n";
$ids_arr = array_chunk($ids,2000,true);

//初始化状态5[待处理]；新增状态为1，更新状态为2；更新其它状态为5的状态为3（删除状态）
$sql = "UPDATE ".C::$table_game." SET status=5";
$db->query($sql);

$t1 = microtime(true);
Comm::log('cron_make_gamedetail_'.date("Ymd"),'开始同步数据：'.date("Y-m-d H:i:s",time()));

$insert_num = $update_num = $del_num = 0;
foreach($ids_arr as $a) {
    $ids2 = array();
    $update_ids = array();
    $del_ids = array();
    $insert_ids = array();

    $sql = "SELECT gameid FROM ".C::$table_game." WHERE gameid IN (".implode(',',$a).")";
    $query = $db->query($sql);
    while($rs = mysql_fetch_assoc($query)) {
        $ids2[$rs['gameid']] = $rs['gameid'];
    }
    foreach($a as $id1) {
        if ($ids2[$id1]) {//更新ID
            $update_ids[$id1] = $id1;
            $update_num++;
        } else {//插入ID
            $insert_ids[$id1] = $id1;
            $insert_num++;
        }
    }
    //插入游戏，状态为1
    if ($insert_ids) {
        $strs = array();
        foreach ($insert_ids as $id) {
            $strs[] = "('{$id}',1)";
        }
        $strs = implode(',',$strs);
        $sql = "INSERT INTO ".C::$table_game."(gameid,status) VALUES {$strs}";
        $db->query($sql);
    }
    //更新游戏状态，状态为2
    if ($update_ids) {
        $sql = "UPDATE ".C::$table_game." SET status=2 WHERE gameid IN(".implode(',',$update_ids).")";
        $db->query($sql);
    }

    
    
}

echo 'pending insert games: '.$insert_num."\n";

echo 'pending update games: '.$update_num."\n";

$sql = "UPDATE ".C::$table_game." SET status=3 WHERE status=5";
$db->query($sql);
$del_num = intval($db->affected_rows());
if ($del_num) {
    echo 'pending del games: '.$del_num."\n";
}

echo "\n\n";

echo 'making...'."\n";

Comm::log('cron_make_gamedetail_'.date("Ymd"),'待插入数:'.$insert_num.'，待更新数:'.$update_num.'，待删除数:'.$del_num);
Comm::log('cron_make_gamedetail_'.date("Ymd"),'开始生成：'.date("Y-m-d H:i:s",time()));


$sql = "SELECT count(*) as c FROM ".C::$table_game;
$query = $db->query($sql);
$temp = mysql_fetch_assoc($query);
echo 'count:'.$temp['c'].PHP_EOL;

$sql = "SELECT * FROM ".C::$table_game." ORDER BY gameid DESC LIMIT 20000";
$query = $db->query($sql);

while($rs = mysql_fetch_assoc($query)) {
    
    if ($rs['status'] == 1 || $rs['status'] == 2) {
        echo 'game id['.$rs['gameid'].'] makeing ...';
        $return = makeOneGameDetail($rs['gameid'],false);
        if ($return['code']==1) {
            $sql = "UPDATE ".C::$table_game." SET status=9 WHERE gameid='".$rs['gameid']."'";
            $db->query($sql);
            echo '  success'.PHP_EOL;
        } else {
            Comm::log('cron_make_gamedetail_'.date("Ymd"),'生成失败,游戏ID['.$rs['gameid'].']：'.$return['msg']);
            if (strpos($return['msg'],'show_url')===0) {
                $sql = "UPDATE ".C::$table_game." SET status=98 WHERE gameid='".$rs['gameid']."'";
                $db->query($sql);
                if (delGameFile($rs['gameid'])) {
                    echo '  show_url=1,del game file'.PHP_EOL;
                } else {
                    echo '  show_url=1,no make'.PHP_EOL;
                }
            } else {
                $sql = "UPDATE ".C::$table_game." SET status=99 WHERE gameid='".$rs['gameid']."'";
                $db->query($sql);
                echo '   fail...'.PHP_EOL;
            }
            
        }
        
    } elseif ($rs['status'] == 3) {
        delGameFile($rs['gameid']);
        $sql = "DELETE FROM ".C::$table_game." WHERE gameid='".$rs['gameid']."' ";
        $db->query($sql);
        echo 'game id['.$rs['gameid'].'] deleted'.PHP_EOL;
    }
}

// 生成失败的重新生成一次

echo 'remake fail in making games'.PHP_EOL;

$sql = "SELECT * FROM ".C::$table_game." WHERE status=99 ORDER BY gameid DESC LIMIT 1000";
$query = $db->query($sql);
while($rs = mysql_fetch_assoc($query)) {
    echo 'game id['.$rs['gameid'].'] makeing ...';
    $return = makeOneGameDetail($rs['gameid'],false);
    if ($return['code']==1) {
        $sql = "UPDATE ".C::$table_game." SET status=9 WHERE gameid='".$rs['gameid']."'";
        $db->query($sql);
        echo '  success'.PHP_EOL;
    } else {
        Comm::log('cron_make_gamedetail_'.date("Ymd"),'生成失败,游戏ID['.$rs['gameid'].']：'.$return['msg']);
        echo '   fail...'.PHP_EOL;
    }
}

$t = round(microtime(true) - $t1,2);
Comm::log('cron_make_gamedetail_'.date("Ymd"),'结束时间：'.date("Y-m-d H:i:s",microtime(true)).'，用时'.$t);
echo 'use time: '.$t.PHP_EOL;


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

    Comm::updatePush($id,time()); // 更新push表

    if ($r['fullpath']) {
        // 设置所属用户与组
        chgrp($r['fullpath'], 'www');
        chown($r['fullpath'], 'www');
    }

    return array('code'=>1,'url'=>$_sc_base_url.$file);
}

function getApiGameIds() {
    $data = array(
        'c' => 'apiselect',
        'a' => 'getGamesGids',
        'timestamp' => time(),
        'version' => '1.4.0',
    );
    $secret = 'd263319194a6f3830bb21f6892245ebf';
    $data['token'] = md5( '#' . $data['version'] . '&' . $secret . '*' . $data['timestamp'] . '|' );

    $ids = array();
    $return = Comm::curl_post(C::$api_gids, json_encode($data));
    if ($return) {
        $return = json_decode($return, true);
        if ($return['code']== 100 && $return['result']) {
            $ids = $return['result'];
        }
    }
    return $ids;
}

function delGameFile($gameid) {
    global $_sc_base_url,$_sc_root;
    $file = Comm::get_url('game_detail','',array('view_ishtml'=>1,'id'=>$gameid));
    if (strpos($file,$_sc_base_url)===0) {
        $file = str_replace($_sc_base_url,'',$file);
    }
    $file = $_sc_root."/{$file}";
    $flag = 0;
    if (is_file($file)) {
        @unlink($file);
        $flag = 1;
    }
    return $flag;
}