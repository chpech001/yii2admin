<?php
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once(ROOT_PATH."/app/include/config.php");

$mem = new memcache;
$mem->connect(MEM_HOST,MEM_PORT);

if (is_dir('/www/t.news.4399.com/')) {
	define('DEBUG', 1);
	define('API_URL','http://ot.newsapp.5054399.com/kuaibao/android/apihd2.php');
	define('GAME_INFO_URL','http://t.newsapp.5054399.com/cdn/android/gameintro-home-1533-id-{yx_id}-level-1.htm');
	define('MEM_PRE','haoyoukb_xiangqing_ot_v1_');
	$cdn_path = 'http://t.news.4399.com';
} elseif (ROOT_PATH == '/www/ot.m.3839.com') {
	define('DEBUG', 1);
	define('API_URL','http://ot.newsapp.5054399.com/kuaibao/android/apihd2.php');
	define('GAME_INFO_URL','http://ot.newsapp.5054399.com/cdn/android/gameintro-home-1533-id-{yx_id}-level-1.htm');
	define('MEM_PRE','haoyoukb_xiangqing_ot_v1_');
	$cdn_path = 'http://newsimg.5054399.com';
} else {
	define('DEBUG', 0);
	define('API_URL','http://newsapp.5054399.com/kuaibao/android/apihd2.php');
	define('GAME_INFO_URL','http://newsapp.5054399.com/cdn/android/gameintro-home-1533-id-{yx_id}-level-1.htm');
	define('MEM_PRE','haoyoukb_xiangqing_v1_');
	$cdn_path = 'http://newsimg.5054399.com';
}

$_kind = array(
    '10' => '休闲娱乐',
    '11' => '儿童教育',
    '12' => '角色扮演',
    '2'  => '动作游戏',
    '3'  => '体育竞技',
    '4'  => '益智游戏',
    '5'  => '射击游戏',
    '6'  => '冒险游戏',
    '7'  => '棋牌天地',
    '8'  => '策略游戏',
    '9'  => '敏捷游戏',
    '13' =>'其他'
);



/*********************************** 相关函数 *******************************************/

function get_data ($key,$yx_id,$times=0) {
    global $mem;

    $data = $mem->get($key);
    $expire = intval($data['expire']);
    $res = isset($data['res']) && $data['res'] ? $data['res'] : array();

    if (DEBUG){
        $data = false;
    }

    if ($data === false || !$res || $expire < time()) {
        $lock_data_key = MEM_PRE.'lock_key_'.$yx_id;
        if ($mem->add($lock_data_key, 1, 0, 10)) {
            $gameInfoUrl = str_replace('{yx_id}', $yx_id, GAME_INFO_URL);
            $rs = curl_get($gameInfoUrl);
            if($rs){
                $res = array();
                $rs = json_decode($rs, true);
                if($rs['code'] == 100 && $rs['result']['data']){
                    $res = $rs['result']['data'];
                    $data = array('res' => $res, 'expire' => time()+1800);
                    $mem->set($key, $data, MEMCACHE_COMPRESSED, time()+3600*24);
                }
            }

            $mem->delete($lock_data_key);
            return $res;
        } else {
            if ($res) {
                return $res;
            } else {
                $times++;
                if ($times < 10) {
                    usleep(200000);
                    return get_data($key, $yx_id, $times);
                }
            }
        }
    }
    return $res;
}

function getDown($kb_id) {
	$kb_id = intval($kb_id);
	if (!$kb_id) {
		return array();
	}
	
	$data = file_get_contents('http://newsapp.5054399.com/cdn/android/apiselect-list-140-gid-'.$kb_id.'.htm');
	$data = json_decode($data,true);
	if ($data['result']['id'] == $kb_id) {
	    return array(
	        'kb_id'   => $kb_id,
	        'apkurl'  => $data['result']['apkurl'],
	        'package' => $data['result']['packag'],
	        'appname' => $data['result']['appname'],
	        'icon'    => $data['result']['icon'],
	        'md5'     => $data['result']['md5']
	    );
	}
	
	return array();
}

function curl_get($url,$timeout=60){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$content = curl_exec($ch);
	curl_close($ch);

	return $content;
}

function Rand_IP(){

    $ip2id= round(rand(600000, 2550000) / 10000); //第一种方法，直接生成
    $ip3id= round(rand(600000, 2550000) / 10000);
    $ip4id= round(rand(600000, 2550000) / 10000);
    //下面是第二种方法，在以下数据中随机抽取
    $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
    $randarr= mt_rand(0,count($arr_1)-1);
    $ip1id = $arr_1[$randarr];
    return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
}

//抓取页面内容
function Curlll($url){
    $ch2 = curl_init();
    $cookie = 'umplusappid=umcenter; __ufrom=https://i.umeng.com/; cn_a61627694930aa9c80cf_dplus=%7B%22distinct_id%22%3A%20%2215d16a70a3c1db-0d7e85c2e-6016147c-1fa400-15d16a70a3daa3%22%2C%22sp%22%3A%20%7B%22%24recent_outside_referrer%22%3A%20%22%24direct%22%7D%2C%22initial_view_time%22%3A%20%221499318273%22%2C%22initial_referrer%22%3A%20%22%24direct%22%2C%22initial_referrer_domain%22%3A%20%22%24direct%22%7D; umengplus_name=shouyou%404399inc.com; umplusuuid=57623b359cfea17f012402fb8680184e; um_lang=zh; umlid_53991372fd98c5f04f012493=20170706; cna=r+zsECmasAACAXxIX6J4QnrL; cn_1260769985_dplus=%7B%22distinct_id%22%3A%20%2215d16a70a3c1db-0d7e85c2e-6016147c-1fa400-15d16a70a3daa3%22%2C%22sp%22%3A%20%7B%22%24_sessionid%22%3A%200%2C%22%24_sessionTime%22%3A%201499323791%2C%22%24dp%22%3A%200%2C%22%24_sessionPVTime%22%3A%201499323791%7D%7D; isg=Av39iOCxeEF28dyt8wYLWDfKDFk3MqftT8Tt1r9Ct9SJ9h0oh-pBvMuk1D9j; __utmt=1; __utma=151771813.118480459.1499323649.1499323660.1499330439.3; __utmb=151771813.3.9.1499330525143; __utmc=151771813; __utmz=151771813.1499323649.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); cn_1259864772_dplus=%7B%22distinct_id%22%3A%20%2215d16a70a3c1db-0d7e85c2e-6016147c-1fa400-15d16a70a3daa3%22%2C%22sp%22%3A%20%7B%22%E6%98%AF%E5%90%A6%E7%99%BB%E5%BD%95%22%3A%20true%2C%22USER%22%3A%20%22shouyou%404399inc.com%22%2C%22%24_sessionid%22%3A%200%2C%22%24_sessionTime%22%3A%201499330524%2C%22%24dp%22%3A%200%2C%22%24_sessionPVTime%22%3A%201499330524%7D%2C%22initial_view_time%22%3A%20%221499322968%22%2C%22initial_referrer%22%3A%20%22http%3A%2F%2Fmobile.umeng.com%2Fapps%22%2C%22initial_referrer_domain%22%3A%20%22mobile.umeng.com%22%7D; UM_distinctid=15d16a70a3c1db-0d7e85c2e-6016147c-1fa400-15d16a70a3daa3; CNZZDATA1259864772=1604751150-1499322968-%7C1499328368; ummo_ss=BAh7CUkiGXdhcmRlbi51c2VyLnVzZXIua2V5BjoGRVRbCEkiCVVzZXIGOwBGWwZvOhNCU09OOjpPYmplY3RJZAY6CkBkYXRhWxFpWGkBmWkYaXdpAf1pAZhpAcVpAfBpVGkGaSlpAZNJIhloV1F2QWVTTU5YckdpNzBscE1PdAY7AFRJIg91bXBsdXN1dWlkBjsARiIlNTc2MjNiMzU5Y2ZlYTE3ZjAxMjQwMmZiODY4MDE4NGVJIhBfY3NyZl90b2tlbgY7AEZJIjFTYnBIRndEUytJaS90VTFiZXZDK0tJSXNiUjY1OFduOWRNNGhyUlFDd3ZNPQY7AEZJIg9zZXNzaW9uX2lkBjsAVEkiJWM4YzYwYWMzYTljNTQzZjdhMzQxZjJmYWIyNGJmYTdkBjsARg%3D%3D--aa20533cb26c93497beda3b40c19a4eee4246f01';
    $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36";//模拟windows用户正常访问
    curl_setopt($ch2, CURLOPT_URL, $url);
    curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
	//追踪返回302状态码，继续抓取
    //curl_setopt($ch2, CURLOPT_HEADER, true); 
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch2,CURLOPT_COOKIE,$cookie);  
    curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($ch2, CURLOPT_NOBODY, false);
    curl_setopt($ch2, CURLOPT_REFERER, 'http://www.baidu.com/');//模拟来路
    curl_setopt($ch2, CURLOPT_USERAGENT, $user_agent);
    $temp = curl_exec($ch2);
    curl_close($ch2);
    return $temp;
}


function info1_api($id){
	$v = 140;
	$ts = time();

	$secret = 'db5c84fc498f0c7ff5d2f2d3544f4fcd';
	$token = md5( '#' . $v . '&' . $secret . '*' . $ts . '|' );

	$urlArr = array(
		'token' => $token,
		'a' => 'bdy',
		'c' => 'forhuodong',
		'ts' => $ts,
		'version' => $v,
		'id' => $id,
	);

	$url = API_URL.'?'.http_build_query($urlArr);
	$data = curl_get($url);

	return $data;
}