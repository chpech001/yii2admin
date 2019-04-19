<?php

//define("LOGIN_PASSWORD","B8w6w107x7wro4xy7tv10I3o5");
//
//$lifeTime = 60*60*2;
//session_set_cookie_params($lifeTime);
//session_start();
//$mem_key = "login_memcache_".LOGIN_PASSWORD;
//$val = intval($_SESSION[$mem_key]);
//header("Content-type: text/html; charset=utf8");
//if($_POST['cc']!='login' && $val!=1){
//    $str = array();
//    $str[] = "<form action='' method='post'>";
//    $str[] = "<input type='password' name='pas' />";
//    $str[] = "<input type='hidden' name='cc' value='login'/>";
//    $str[] = "<input type='hidden' name='c' value='l'/>";
//    $str[] = "<input type='submit' value='登录'/>";
//    $str[] = "</form>";
//    echo implode("",$str);
//    die();
//}
//if($_POST['cc']=='login' && $_POST['pas']!=LOGIN_PASSWORD){
//    die("error pwd");
//}
//$_SESSION[$mem_key] = 1;


define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once(ROOT_PATH.'/app/include/class_gbk.mysql.php');
require_once(ROOT_PATH."/app/include/config.php");

if ( is_dir('/www/t.3839.com/') ) {
    $db = new DB(TEST_DB_HOST,TEST_DB_USER,TEST_DB_PASSWORD,TEST_DB_NAME,0);
}else {
    $db = new DB(DB_NEWS_HOST,DB_NEWS_USER,DB_NEWS_PASSWORD,DB_NEWS_NAME,0);
}



class Hykb {

    public $table_setting = "news_app_comm_shouyou_global_setting";
    public $table_log     = "news_app_comm_hykb_update_log";

    public $key_setting   = "hykb_index_setting_data";

    /**
     *
     * 配置信息 友链 问答
     *
     * @return array
     */
    public function getSetting () {
        global $db;

        $sql = "select * from ".$this->table_setting." where `key` = '".$this->key_setting."'";

        $res_set = $db->get_one($sql);
        $res = json_decode($res_set['setting'],true);

        return $res;
    }

    /**
     *
     * 获取所有版本日志更新记录
     *
     * @return array
     */
    public function getLogInfo () {
        global $db;

        $sql = "select * from ".$this->table_log." order by update_year desc";

        $query = $db->query($sql);

        while ($row = $db->fetch_row($query)) {
            $list[] = $row;
        }

        return $this->gbk2Utf8($list);
    }

    public function getLogList () {
        global $db;

        $sql = "select * from ".$this->table_log." order by id desc";

        $query = $db->query($sql);

        while ($row = $db->fetch_row($query)) {
            $list[] = $row;
        }

        return $this->gbk2Utf8($list);
    }


    /**
     *
     * 获取最新的更新日志记录
     *
     * @return array
     */
    public function getLastLogInfo () {
        global $db;

        $sql = "select `version_num`,`update_year`,`update_month` from ".$this->table_log." order by id desc";

        $res = $db->get_one($sql);

        return $res;
    }

    public function gbk2Utf8 ( $arr ) {
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $arr[$key] = $this->gbk2Utf8($value);
            }
        } else if (is_string($arr)) {
            $arr = iconv('gbk', 'utf-8//IGNORE', $arr);
        }
        return $arr;
    }
}

function curl_get($url,$timeOut=10){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function convertHttps($content){
	$content = preg_replace('#(<(?:script|link|img|video)[^>]+(?:src|href)=\s*[\'"]?)http:#i','\1',$content);
	$content = str_replace('news.4399.com/js/mtj.js', 'newsimg.5054399.com/js/mtj.js', $content);
	// 去除json中的http:
	$content = str_replace('http:\\/\\/newsimg.5054399.com\\/','\\/\\/newsimg.5054399.com\\/',$content);
	// 去除样式中http:
	$from = array(); $to = array();
	if (preg_match_all('#<style[^>]*>[^<]*</style>#i',$content,$matches)) {
		foreach ($matches[0] as $css_html) {
			if (strpos($css_html,'http://newsimg.5054399.com') !== FALSE) {
				$from[] = $css_html;
				$to[] = str_replace('http://newsimg.5054399.com','//newsimg.5054399.com',$css_html);
			}
		}
	}
	if (preg_match_all('#style=[\'"][^>]+>#',$content,$matches)) {
		foreach ($matches[0] as $css_html) {
			if (strpos($css_html,'http://newsimg.5054399.com') !== FALSE) {
				$from[] = $css_html;
				$to[] = str_replace('http://newsimg.5054399.com','//newsimg.5054399.com',$css_html);
			}
		}
	}
	if ($from) {
		$content = str_replace($from,$to,$content);
	}

	// 如果还存在http://newsimg.5054399.com ,则基本上是js中的，特殊处理
	if (strpos($content,'http://newsimg.5054399.com') !== FALSE) {
		$content = preg_replace('#([\'"])http:(//newsimg.5054399.com/)#','(document.location.protocol=="https:"?"https:":"http:")+\1\2',$content);
	}
    return $content;
}


$hykb = new Hykb();

$index_setting = $hykb->getSetting();

$log_list      = $hykb->getLogInfo();

$logList       = $hykb->getLogList();

$log_last      = $hykb->getLastLogInfo();

$path = "http://newsimg.5054399.com/hykb/wap/";
