<?php
defined('APP_PATH') or exit('Access Denied...');
/**
 * 通用函数
 */
class Comm{

    public static function getGameData($gameid) {
        $url = str_replace('{gameid}',$gameid,C::$api_gameinfo);
        $return = self::curl_get($url);
        if (!$return) {
            return array();
        }
        $return = json_decode($return,true);
        if ($return['code']!=100 || !$return['result']['data']) {
            return array();
        }

        return $return['result']['data'];
    }


    public static function getModeName($str){
        $str    = ucwords(str_replace('_', ' ', trim($str)));
        $str{0} = strtolower($str{0});
        return str_replace(' ','',$str);
    }

    public static function curl_get($url, $timeout=6) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch,CURLOPT_FLOOWLOCATION,false);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public static function curl_post($url, $post_data, $timeout=6)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }


    // 获取链接地址
    public static function get_url($mode,$ac='',$param=array()){
        global $_sc_path,$_sc_base_url;
        if (isset($param['view_ishtml'])) {
            $view_ishtml = $param['view_ishtml'];
        } elseif (isset($_GET['view_ishtml'])) {
            $view_ishtml = $_GET['view_ishtml'] == 0 ? 0 : 1;
        } elseif (defined('IN_TEST')) {
            $view_ishtml = 0;
        } else {
            $view_ishtml = true;
        }

        if (!$view_ishtml) {

            $url = 'index.php?m='.$mode;
            if ($ac) {
                $url .= '&ac='.$ac;
            }
            if ($param) {
                $url .= '&'.http_build_query($param,'','&');
            }
            return WEB_ROOT.'/'.$url;
        } else {
            if (!isset($_sc_path)) {
                die('静态根路径没有设置');
            }
            switch($mode) {
                case 'home':
                    return $_sc_base_url.$_sc_path.'wap.html';
                break;
                case 'newness':
                    return $_sc_base_url.$_sc_path.'xinqi.html';
                break;
                case 'game_detail':
                    if (!$param['id']) die('参数错误');
                    return $_sc_base_url.$_sc_path.'a/'.$param['id'].'.htm';

                break;

                case 'coll':
                    if ($ac == 'detail') {
                        if (!$param['id']) {
                            die('参数错误');
                        }
                        return $_sc_base_url.$_sc_path.'heji/'.$param['id'].'.html';

                    } elseif ($ac == 'list') {
                        return $_sc_base_url.$_sc_path.'heji/';

                    }else if ($ac == 'hot' && !$param['id']) {   //合辑热门列表
                        return $_sc_base_url.$_sc_path.'heji/hot.html';

                    }else if ($ac == 'hot' && $param['id']) {   //合辑热门 id列表
                        return $_sc_base_url.$_sc_path.'heji/hot_'.$param['id'].'.html';

                    }  elseif ($ac == 'recent' && !$param['id']) {  //合辑近期列表
                        return $_sc_base_url.$_sc_path.'heji/recent.html';

                    } elseif ($ac == 'recent' && $param['id']) {   //合辑近期 id 列表
                        return $_sc_base_url.$_sc_path.'heji/recent_'.$param['id'].'.html';

                    }else if ($ac == 'tags') {   //合辑标签列表
                        return $_sc_base_url.$_sc_path.'heji/tags_'.$param['type'].'.html';
                    }
                    break;

                /*case 'coll':
                    if ($ac == 'detail') {
                        if (!$param['id']) {
                            die('参数错误');
                        }
                        return $_sc_base_url.$_sc_path.'collection/'.$param['id'].'.html';
                    } elseif ($ac == 'list') {
                        return $_sc_base_url.$_sc_path.'collection_list/'.($page==1||$page==0?'':$page.'.html');
                    }
                break;*/

                case 'category':
                    if ($ac == '' || $ac == 'index') {
					    $cid = $param['cid'] ? $param['cid'] : '';
						if(empty($cid)){
						  $page='';
						}else{
						  $page='type_'.$cid.'.html';
						}
                        return $_sc_base_url.$_sc_path.'fenlei/'.$page;
                    } elseif ($ac == 'detail') {
                        if (!$param['id']) {
                            die('参数错误');
                        }
                        $param['type'] = $param['type'] ? $param['type'] : 'hot';
                        return $_sc_base_url.$_sc_path.'fenlei/cat_'.$param['type'].'_'.$param['id'].'.html';
                    }
                break;

                case 'commentwall':
                    if ($ac == '' || $ac == 'index') {
                        return $_sc_base_url.$_sc_path.'anli/';
                    } elseif ($ac == 'detail') {
                        if (!$param['id']) {
                            die('参数错误');
                        }

                        return $_sc_base_url.$_sc_path.'anli/'.$param['id'].'.html';
                    }else if($ac == 'anli_coll'){

                        return $_sc_base_url.$_sc_path.'anli/anli_coll.html';;
                    }
                    break;

                case 'huodong':
                    return $_sc_base_url.$_sc_path.'huodong/'.($param['page']==1||!$param['page']?'':$param['page'].'.html');
                break;

                case 'findings':
                    return $_sc_base_url.$_sc_path.'findings/';
                break;

                case 'review':
                    if ($ac == '' || $ac == 'index') {
                        return $_sc_base_url.$_sc_path.'review/';
                    } elseif ($ac == 'detail') {
                        if (!$param['id']) {
                            die('参数错误');
                        }
                        return $_sc_base_url.$_sc_path.'review/'.$param['id'].'.html';
                    }
                break;

                case 'top':
                    if ($ac == 'hot') {
                        return $_sc_base_url.$_sc_path.'top/hot.html';
                    } elseif ($ac == 'sugar') {
                        return $_sc_base_url.$_sc_path.'top/sugar.html';
                    } elseif ($ac == 'manu') {
                        return $_sc_base_url.$_sc_path.'top/manu.html';
                    }elseif ($ac == 'expect') {
					   return $_sc_base_url.$_sc_path.'top/expect.html';
					}elseif ($ac == 'player') {
					   return $_sc_base_url.$_sc_path.'top/player.html';
					}
                break;
                case 'manu':
                    if ($ac == 'detail') {
					    if (!$param['id']) {die('参数错误');}
                        return $_sc_base_url.$_sc_path.'cp/'.$param['id'].'.html';
                    }
                break;
            }
        }
    }

    public static function getUrlByInterface($interface_type,$interface_id, $url='') {
        // if ($url && preg_match('#^https://www.onebiji.com/hykb/card/\d+\.html#i',$url)) {
        //     if ($interface_id) {
        //         return self::get_url('category','detail',array('id'=>$interface_id));
        //     } else {
        //         return '';
        //     }
        // }

        $interface_id = intval($interface_id);
        if (!$interface_id) return '';

        $url2 = '';

        switch ($interface_type) {
            case 1: //活动详情
                $url2 = $url;
            break;

            case 2: //活动列表

            break;

            case 3: //分类
                // $url2 = self::get_url('category','detail',array('id'=>$interface_id));
            break;

            case 4: //排行榜

            break;

            case 5: //视频列表

            break;

            case 6: //视频详情

            break;

            case 7: //原创专栏

            break;

            case 8: //原创专栏某专栏

            break;

            case 9: //工具详情

            break;

            case 10: //工具列表

            break;

            case 11: //文章详情

            break;

            case 12: //游戏专区

            break;

            case 13: //QQ群

            break;

            case 14: //招募

            break;

            case 15: //视频列表-分类样式

            break;
            case 16: //合辑详情

            break;

            case 17: //推荐游戏 [版本>=153]
                $url2 = self::get_url('game_detail','',array('id'=>$interface_id));
            break;

            case 18: //合辑列表

            break;

            case 19: //视频全屏播放

            break;

            case 20: //跳转链接

            break;

            case 21: //分类列表页[新奇页]

            break;

            case 22: //讨论帖-详情页

            break;

            case 23: //游戏讨论区

            break;

            case 24: //个人主页

            break;

            default:
                $url2 = '';
            break;
        }

        // if (!$url2 && $url) {
        //     $url2 = $url;
        // }
        return $url2;
    }

    public static function replaceImg($imgurl) {
        return preg_replace('#f\d{1,3}\.img4399\.com#','fs.img4399.com',$imgurl);
    }

    public static function reLink($link) {
        return str_ireplace(array('https://','http://'),'//',$link);
    }


    //https地址转换
    public static function reHtml($html){
        $body_pos = stripos($html,'<body');
        if ($body_pos !== false) {
            $head_content = substr($html,0,$body_pos);
            $body_content = stristr($html,'<body');
            // $body_content = str_replace(array('newsimg.5054399.com/js/mtj.js','news.4399.com/js/mtj.js'),'newsimg.5054399.com/js/kbtj.js',$body_content);

            $content = preg_replace('#(<(?:script|link|img)[^>]+(?:src|href)=\s*[\'"]?)(http|https):#i','\1',$head_content.$body_content);
            // 去除json中的http:
            $content = str_replace('http:\\/\\/newsimg.5054399.com\\/','\\/\\/newsimg.5054399.com\\/',$content);
            //替换图片地址,f{数字}.img4399.com不支持https,改成fs.img4399.com
            $content = preg_replace('#f\d{1,3}\.img4399\.com#','fs.img4399.com',$content);
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

            // 压缩代码
            $content = preg_replace(array("/> *([^ ]*) *</","/\t/",'/>[ ]+</'),array(">\\1<",'','><'),$content);

            // 如果还存在http://newsimg.5054399.com ,则基本上是js中的，特殊处��??
            if (strpos($content,'http://newsimg.5054399.com') !== FALSE) {
                $content = preg_replace('#([\'"])http:(//newsimg.5054399.com/)#','(document.location.protocol=="https:"?"https:":"http:")+\1\2',$content);
            }
        }
        return $content;
    }

    public static function make_html($path, $content) {
        global $_sc_root,$_sc_base_url;

        if (strpos($path,$_sc_base_url)===0) {
            $path = str_replace($_sc_base_url,'',$path);
        }

        if (strpos($path, '.')===false) {
            $path = $path.'/index.html';
        }
        $path = preg_replace('#[/]+#','/',$path);
        $path = ltrim($path, '/');
        if (!self::check_path($path)) {
            die('path error');
        }

        if (strpos($path,$_sc_root) !== 0) {
            $path = $_sc_root."/{$path}";
        }
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!is_dir($dir) || (!is_file($path) && !is_writable($dir)) || (is_file($path) && !is_writable($path))) {
            die('<font color="red">请联系技术，文件没有写入权限</font>');
        }
        file_put_contents($path,$content);
        return array('fullpath'=>$path);
    }

    public static function check_path($path){
        $path = trim($path);
        //非法路径
        if (!$path || strpos($path,'..') !== false || strpos($path,'/.') !== false) {
            return false;
        }
        //路径只能包含  字母./
        if (!preg_match('#^[0-9a-zA-z/._-]+$#',$path)) {
            return false;
        }
        //不允许空路径
        if (!trim($path,'/')) {
            return false;
        }
        //只允许生成html或者htm后缀的文件
        $suffix = strtolower(strstr($path,'.'));
        if ($suffix && !in_array($suffix,array('.html','.htm'))) {
            return false;
        }
        return true;
    }

    // 获取前端指定页面的预览地址
    public static function get_view_url($mode,$ac='',$param=array()) {
        global $_view_base_url;
        $param['view_ishtml'] = 0;
        $view_url = self::get_url($mode,$ac,$param);
        $view_url = str_replace('view_ishtml=0','view_ishtml=1',$view_url);
        if (!preg_match('/^http/i',$view_url)) {
            $view_url = $_view_base_url.$view_url;
        }
        return $view_url;
    }

    public static function log($which,$item){
        $logFile = APP_PATH.'/log/'.$which.'.log';

        $dir = dirname($logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fh = @fopen($logFile, "a");
        @fwrite($fh, date("Y-m-d H:i:s").','.$item."\r\n");
        @fclose($fh);
        return true;
    }
    //获取开发者的简单信息
  	public static function get_kiother($uid){
  	   $url = str_replace('{uid}',$uid,C::$api_kiother);
          $return = self::curl_get($url);
          if (!$return) {
              return array();
          }
          $return = json_decode($return,true);
          if ($return['code']!=100 || !$return['result']['data']) {
              return array();
          }
          return $return['result']['data'];
  	}

    // 更新游戏push表
    public static function updatePush($gameid,$addtime=0) {
        global $db;
        $tmp = $db->get_one("SELECT * FROM ".C::$table_game_push." WHERE gameid='".$gameid."' ");
        if (!$tmp) {
            $gameurl = self::getGamePushUrl($gameid);
            $ishtml = 1;
            if (!$addtime) $addtime = time();
            $db->query("INSERT INTO ".C::$table_game_push."(gameid,gameurl,ishtml,addtime) VALUES ('{$gameid}','{$gameurl}','{$ishtml}','{$addtime}')");
        }
    }

    public static function getGamePushUrl($gameid) {
        global $_sc_base_url;
        $gameurl = Comm::get_url('game_detail','',array('view_ishtml'=>1,'id'=>$gameid));
        $gameurl = str_replace($_sc_base_url,'',$gameurl);
        $gameurl = 'https://m.3839.com'.$gameurl;
        return $gameurl;
    }

     static function get_online_ip() {
	     if($_SERVER['HTTP_CDN_SRC_IP'] && strcasecmp($_SERVER['HTTP_CDN_SRC_IP'],'unknown')) {
		         $onlineip = $_SERVER['HTTP_CDN_SRC_IP'];
         }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
                $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
                $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
                $onlineip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                $onlineip = $_SERVER['REMOTE_ADDR'];
        }

        if(!preg_match("/^[\d\.]{7,15}$/", $onlineip)){
                $onlineip = 'unknown';
        }
        return $onlineip;
    }



}
