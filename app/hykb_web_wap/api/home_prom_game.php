<?php
// 首页头图下方广告
error_reporting(E_ALL^E_NOTICE);
header('content-type:text/html;charset=utf-8');
date_default_timezone_set("Asia/Shanghai");

if (is_dir('/www/t.news.4399.com')) {
    define('ROOT_PATH', '/www/t.3839.com');
    define('APP_PATH','/www/t.m.3839.com/app/hykb_web_wap');
} elseif (is_dir('/www/m.3839.com')) {
    define('ROOT_PATH', '/www/m.3839.com');
    define('APP_PATH','/www/m.3839.com/app/hykb_web_wap');
} else {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
    define('APP_PATH',str_replace('\\','/',dirname(dirname(__FILE__))));
}

define('WEB_ROOT', substr(APP_PATH,strlen(ROOT_PATH)));
define('INC_PATH',APP_PATH.'/include');
define('TPL_PATH',APP_PATH.'/template/default');
require INC_PATH.'/config.php';
require INC_PATH.'/cls_comm.php';
require INC_PATH.'/cls_db.php';

$promgameHtml = getIndexPromGame();
$promgameHtml = preg_replace('#(<(?:script|link|img)[^>]+(?:src|href)=\s*[\'"]?)http:#i','\1',$promgameHtml);
// 去除json中的http:
$promgameHtml = str_replace('http:\\/\\/newsimg.5054399.com\\/','\\/\\/newsimg.5054399.com\\/',$promgameHtml);
//替换图片地址,f{数字}.img4399.com不支持https,改成fs.img4399.com
$promgameHtml = preg_replace('#f\d{1,3}\.img4399\.com#','fs.img4399.com',$promgameHtml);
echo $promgameHtml; 

function getIndexPromGame() {
    $return = Comm::curl_get(C::$api_home_prom);
    if (!$return) {
        return '';
    }
    $return = json_decode($return,true);
    if ($return['code']==100 && $return['gameinfo']) {
        $data = $return['gameinfo'][0];
    }

    $url = Comm::get_url('game_detail','',array('id'=>$data['gameid']));

    if(strpos($data['bigicon'],"//up.3839.com")!==false){
	    $data['bigicon'] = "http:".$data['bigicon'];
    }

    $str .= '<div class="item hezuo">'.PHP_EOL;
    $str .= '    <div class="itemhd">'.PHP_EOL;
    $str .= '        <a href="'.$url.'"><div class="item-game">'.PHP_EOL;
    $str .= '            <img src="'.$data['icon'].'" alt="'.$data['gamename'].'下载">'.PHP_EOL;
    $str .= '               <div class="deta">'.PHP_EOL;
    $str .= '                <em class="name">'.$data['gamename'].'</em>'.PHP_EOL;
    $str .= '                <div class="tags">'.PHP_EOL;
    foreach($data['tags'] as $m=>$t) {
        if ($m>=3) break;
        $str .= '<span>'.$t.'</span>';
    }
    $str .= '                </div>'.PHP_EOL;
    $str .= '            </div>'.PHP_EOL;
    $str .= '        </div></a>'.PHP_EOL;
    $str .= '        <div class="patron" id="prom_game_patron" onclick="$(this).find(\'a.link\').toggle()">'.PHP_EOL;
    $str .= '            <span class="menu"></span>'.PHP_EOL;
    $str .= '            <a class="link" href="'.$data['coopurl'].'" style="display:none"><span>'.$data['cooptitle'].'</span></a>'.PHP_EOL;
    $str .= '        </div>'.PHP_EOL;
    $str .= ''.PHP_EOL;
    $str .= '    </div>'.PHP_EOL;
    $str .= '    <a href="'.$url.'"><div class="img">'.PHP_EOL;
    $str .= '        <img src="'.$data['bigicon'].'" alt="'.$data['gamename'].'安卓版">'.($data['tips']?'<span class="tag">'.$data['tips'].'</span>':'').''.PHP_EOL;
    $str .= '    </div>'.PHP_EOL;
    $str .= '    <div class="desc">'.$data['description'].'</div>'.PHP_EOL;
    $str .= '    <div class="gameinfo">'.PHP_EOL;
    $str .= '        <div class="total">'.PHP_EOL;
    if ($data['num'] && strpos($data['num'],'预约')===false) {
        $str .= '            <span class="download">'.$data['num'].'</span>'.PHP_EOL;
    }

    $str .= '            <span class="review">'.$data['comment'].'</span>'.PHP_EOL;
    $str .= '        </div>'.PHP_EOL;
    $str .= '    </div></a>'.PHP_EOL;
    $str .= '</div>'.PHP_EOL;

    return $str;
}
