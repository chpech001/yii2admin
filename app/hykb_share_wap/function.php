<?php
class F{
    static $tids = array(); //专区下所有栏目ID，包括专区ID
    static $ptztInfo = array(); //手游普通专区

    //获取文章信息
    static function getArcInfo($aid){
        if(!$aid){
            return array();
        }

        global $mem;
        $key = MEM_PRE . 'arc_info_' . $aid;
        $data = $mem->get($key);
        $expire = intval($data['expire']);
        $arcInfo = (isset($data['info']) && $data['info']) ? $data['info'] : array();
        if(!$data || $expire < time()){
            $api_url = 'http://newsapp.5054399.com/cdn/android/articlepage-home-1421-id-' . $aid . '-level-4.htm';
            $api_rs = self::getCurl($api_url);
            if($api_rs){
                $api_rs = json_decode($api_rs, true);
                if($api_rs['code'] == 100){
                    $result = $api_rs['result'];
                    $arcInfo = array(
                        'id' => $result['id'],
                        'title' => $result['title'],
                        'author' => $result['author'],
                        'time' => $result['time'],
                        'body' => self::dealBody($result['body']),
                    );
                    $data = array('info' => $arcInfo, 'expire' => time() + 3600);
                    $mem->set($key, $data, MEMCACHE_COMPRESSED, 7200);
                }
            }
        }

        return $arcInfo;
    }

    //获取手游普通专区信息
    static function getPtztInfo($zid){
        $zid = intval($zid);
        if(!$zid){
            return array();
        }

        if(isset(self::$ptztInfo[$zid])){
            return self::$ptztInfo[$zid];
        }

        global $db;
        self::$ptztInfo[$zid] = array();
        $sql = "SELECT `waptuijian`,`navigation`,`istese` FROM `dede_shouyou_ptzt` WHERE `zId`=" . intval($zid) . ' LIMIT 1';
        $row = $db->get_one($sql);
        if($row){
            self::$ptztInfo[$zid] = $row;
        }

        return self::$ptztInfo[$zid];
    }

    //获取新版手游普通专题信息
    static function getNewSyptztInfo($zid){
        $zid = intval($zid);
        if(!$zid){
            return array();
        }

        global $db, $mem;
        $key = MEM_PRE . 'new_syptzt_' . $zid;
        $info = $mem->get($key);
        if($info === FALSE){
            $info = array();
            $sql = "SELECT `hot_tuijian`,`wap_gsxz_tj` FROM `news_app_comm_shouyou_ptzt` WHERE `zq_id`=" . $zid . ' LIMIT 1';
            $row = $db->get_one($sql);
            if($row){
                //导航菜单
                $info['hot_tuijian'] = $row['hot_tuijian'] ? json_decode($row['hot_tuijian'], true): array();
                //高速下载旁推荐
                $info['wap_gsxz_tj'] = $row['wap_gsxz_tj'] ? json_decode($row['wap_gsxz_tj'], true): array();
            }

            $mem->set($key, $info, 0, 43200);
        }

        return $info;
    }

    //获取子栏目
    static function _next_($tid){
        global $db;
        $tid = intval($tid);
        if(!$tid){
            return array();
        }

        if(isset(self::$tids[$tid])){
            return self::$tids[$tid];
        }

        $tids = array($tid);
        //循环3次取下级栏目
        $last = array($tid);
        for($i = 0;$i < 3;$i ++){
            if(!$last){
                break;
            }
            $last_str = join(',', $last);
            $whereStr = count($last) > 1 ? ' IN(' . $last_str . ')' : '= ' . $last_str;
            $q = "SELECT `id` FROM `dede_arctype` WHERE `reid` " . $whereStr;
            $r = $db->query($q);
            $last = array();
            while($r && ($row=mysql_fetch_assoc($r))){
                $last[] = $row['id'];
                $tids[] = $row['id'];
            }
        }

        self::$tids[$tid] = $tids;
        return $tids;
    }

    //获取最新最热列表
    static function getNewHotList($zid){
        global $mem;
        if(!$zid){
            return array();
        }

        $key = MEM_PRE . 'new_hot_list_' . $zid;
        $list = $mem->get($key);
        if($list === FALSE){
            $list = array(
                'new' => F::getNewList($zid),
                'hot' => F::getHotList($zid),
            );
            $mem->set($key, $list, MEMCACHE_COMPRESSED, 43200);
        }

        return $list;
    }

    //最新列表
    static function getNewList($zid){
        if(!$zid){
            return array();
        }

        $tids = self::_next_($zid);
        return self::getArcList($tids, 5, 0, true);
    }

    //热门列表
    static function getHotList($zid){
        if(!$zid){
            return array();
        }

        $ptztInfo = self::getPtztInfo($zid);
        $tjInfo = $ptztInfo['waptuijian'];
        if($tjInfo){
            $waptuijian = explode("@", $tjInfo);
            $tmp = $waptuijian[0];
            $t = explode("|", $tmp);
            if($t[2] == 0){
                $att = "2|3|4|5|6|7|8|9|10|11|21|23|31|37|38|39|40|41|42|43|44|45|46";
            } else {
                $c = explode("*", $t[2]);
                $att = implode("|", $c);
            }
        } else {
            $att = "2|3|4|5|6|7|8|9|10|11|21|23|31|37|38|39|40|41|42|43|44|45|46";
        }

        $tids = self::_next_($zid);
        return self::getArcList($tids, 5, $att, true);
    }

    //批量获取文章信息
    static function getArcList($ids, $limit = 10, $arcatt_ids = 0, $is_lanmu_id = false, $addwhere = ''){
        global $db;
        if (!is_array($ids)) {
            $ids = str_replace(array('|',',','*'),' ',trim(''.$ids));
            $ids = explode(' ', $ids);
        }
        $ids = array_map('intval',$ids);
        $ids = array_filter($ids);
        if (empty($ids)) {
            return array();
        }
        $ids_str   = implode(',', $ids);
        $where_str = $is_lanmu_id ? 'a.typeid' : 'a.id';
        $where_str .= count($ids) > 1 ? " in({$ids_str})" : " = {$ids_str}";
        if ($addwhere) {
            $where_str .= ' '.$addwhere;
        }
        $sql = "SELECT a.id,a.pubdate,a.litpic,a.title,a.description,a.redirecturl FROM dede_arc_shouyou a LEFT JOIN dede_arctype t ON a.typeid=t.id WHERE {$where_str} AND a.arcrank = 0";
        if ($arcatt_ids) {
            if ($arcatt_ids === -1) {
                $sql .= ' AND a.arcatt > 0';
            } else {
                if (!is_array($arcatt_ids)) {
                    $arcatt_ids = str_replace(array('|',',','*'),' ',trim(''.$arcatt_ids));
                    $arcatt_ids = explode(' ', $arcatt_ids);
                }
                $arcatt_ids = array_map('intval',$arcatt_ids);
                $arcatt_ids = array_filter($arcatt_ids);
                if ($arcatt_ids) {
                    $arcatt_ids_str = implode(',', $arcatt_ids);
                    $sql .= ' and a.arcatt ' . (count($arcatt_ids) > 1 ? "in({$arcatt_ids_str})" : "={$arcatt_ids_str}");
                }
            }
        }

        $sql .= ' ORDER BY a.pubdate DESC';
        $limit = intval($limit);
        $limit = $limit < 1 ? 1 : intval($limit);
        $sql .= " LIMIT {$limit}";
        $rs = $db->query($sql);
        $list = array();
        while($rs && $row = mysql_fetch_assoc($rs)) {
            if ($row['redirecturl']) {
                $result = self::convertHykbUrl($row['redirecturl']);
                $url = $result['url'];
            } else {
                $url = self::getArcUrl($row['id']);
            }

            $arr               = array();
            $arr['id']         = $row['id'];
            $arr['url']        = $url;
            $arr['pubdate']    = $row['pubdate'];
            $arr['pic']        = $row['litpic']? ((!preg_match('/^http/', $row['litpic']) ? "//newsimg.5054399.com{$row['litpic']}" : self::reLink($row['litpic']))) : '';
            $arr['title']      = $row['title'];
            $arr['descript']   = $row['description'];
            $list[$arr['id']]  = $arr;
        }

        if (!$is_lanmu_id) { //文章按输入顺序排序
            $tmp = array();
            foreach ($ids as $arc_id) {
                if ($list[$arc_id]) {
                    $tmp[$arc_id] = $list[$arc_id];
                }
            }
            $list = $tmp;
        }
        return $list;
    }

    //获取手机游戏的顶级栏目的数组
    static function getZtTopId(){
        global $db;
        $ztTopId = array();
        $sql = "SELECT `ID` FROM `dede_arctype` WHERE `channeltype`=17 and `reID`=0";
        $query = $db->query($sql);
        while($query && $row = mysql_fetch_assoc($query)){
            $ztTopId[] = $row['ID'];
        }

        return $ztTopId;
    }

    //递归取得文章的所在的专题
    static function get_top_id($reid, $ztTopId = array()){
        $reid = intval($reid);
        if(!$reid){
            return 0;
        }
        global $db;
        $sql = "SELECT `reid` FROM `dede_arctype` WHERE `id`=" . $reid;
        $info = $db->get_one($sql);
        if(in_array($info['reid'], $ztTopId)){
            return intval($reid);
        } else {
            return self::get_top_id($info['reid'], $ztTopId);
        }
    }

    //通过栏目ID获取专区ID
    static function getZidByTid($tid){
        $tid = intval($tid);
        if(!$tid){
            return 0;
        }

        global $db;
        $zid = 0;
        $tmp = array();
        //最多循环10次向上取所有上级栏目ID，倒序后第2个即为专题栏目ID
        for($i = 0;$i < 10;$i ++){
            $q = "SELECT `ID`,`reid` FROM `dede_arctype` WHERE `ID`={$tid} LIMIT 1";
            $row = $db->get_one($q);
            if($row){
                $tid = $row['reid'];
                $tmp[] = $row['ID'];
            } else {
                break;
            }

            if($tid == 0){
                break;
            }
        }

        $tmp = array_reverse($tmp);
        if(count($tmp) >= 2){
            $zid = $tmp[1];
        }

        return $zid;
    }

    //获取游戏信息
    static function getGameInfo($id){
        if(!$id){
            return array();
        }

        global $mem;
        $key = MEM_PRE . 'game_info_' . $id;
        $data = $mem->get($key);
        $expire = intval($data['expire']);
        $gameInfo = (isset($data['info']) && $data['info']) ? $data['info'] : array();
        if(!$data || $expire < time()){
            $url = 'http://newsapp.5054399.com/cdn/android/gameintro-home-1533-id-' . $id . '-level-1.htm';
            $rs = self::getCurl($url);
            if($rs){
                $rs = json_decode($rs, true);
                if($rs['code'] == 100){
                    $api_data = $rs['result']['data'];
                    $gameInfo = array(
                        'id' => $api_data['id'],
                        'status' => $api_data['status'],
                        'title' => $api_data['title'],
                        'icon' => $api_data['icon'],
                        'num_down' => $api_data['num_down'],
                        'num_yuyue' => $api_data['num_yuyue'],
                        'star' => $api_data['star'],
                        'star_usernum' => $api_data['star_usernum'],
                        'tags' => $api_data['tags'],
                        'downinfo' => $api_data['downinfo'],
                        'discover' => $api_data['discover'],
                    );

                    $data = array('info' => $gameInfo, 'expire' => time() + 3600);
                    $mem->set($key, $data, MEMCACHE_COMPRESSED, 7200);
                }
            }
        }

        return $gameInfo;
    }

    //获取文章所在的栏目ID
    static function getTid($aid){
        $aid = intval($aid);
        if(!$aid){
            return 0;
        }

        global $db;
        $sql = "SELECT `typeid` FROM `dede_arc_shouyou` WHERE `id`={$aid} LIMIT 1";
        $info = $db->get_one($sql);
        $tid = intval($info['typeid']);

        return $tid;
    }

    //获取文章所在的专区ID
    static function getZidByAid($aid){
        global $mem;
        if(!$aid){
            return 0;
        }

        $key = MEM_PRE . 'arc_zid_' . $aid;
        $zq_id = $mem->get($key);
        if($zq_id === FALSE){
            $tid = self::getTid($aid);
            $zq_id = self::getZidByTid($tid);
            $mem->set($key, $zq_id, 0, 43200);
        }

        return intval($zq_id);
    }

    //获取某专题下的特色菜单
    static function getTeseMenuList($zid){
        if(!$zid){
            return array();
        }
		
		global $mem;
		$key = MEM_PRE . 'tese_menu_list_' . $zid;
        $menuList = $mem->get($key);
        if($menuList === FALSE){
            $menuList = array();
            $syptztInfo = self::getNewSyptztInfo($zid);
            if($syptztInfo && $syptztInfo['hot_tuijian']['urls'] && is_array($syptztInfo['hot_tuijian']['urls'])){
                foreach($syptztInfo['hot_tuijian']['urls'] as $val){
                    if(($val['platform'] & 2) && $val['title'] && $val['url']){
                        $menuList[] = array(
                            'name' => $val['title'],
                            'url' => self::formatWapUrl($val['url']),
                            'is_red' => $val['is_red']
                        );
                    }
                }
            } else {
                $ptztInfo = self::getPtztInfo($zid);
                $istese = intval($ptztInfo['istese']);
                $navigation = $ptztInfo['navigation'];
                if($istese && $navigation){
                    $navigation = explode("@", $navigation);
                    foreach($navigation as $v){
                        $t = explode("|", $v);
                        $menuList[] = array(
                            "name"=> $t[0],
                            "url" => self::formatWapUrl($t[1]),
                            "is_red" => 0
                        );
                    }
                }
            }

            $mem->set($key, $menuList, MEMCACHE_COMPRESSED, 43200);
        }

        if($menuList){
            foreach($menuList as $k => $v){
                $result = self::convertHykbUrl($v['url']);
                if(!$result['is_save']){
                    unset($menuList[$k]);
                } else {
                    $menuList[$k]['url'] = $result['url'];
                }
            }
        }

        return $menuList;
    }

    //处理文章内容图片
    static function checkImgWidthHeight($match){
        $reg = "/(?:alt)=[\"\'](.*?)[\"\']/is";
        preg_match_all($reg, $match[1] . " " . $match[3], $alt_info);

        $imgPath = parse_url($match[2]);
        if(!$imgPath['host'] || in_array($imgPath['host'], array("news.4399.com"))){
            $file = "http://newsimg.5054399.com" . $imgPath['path'];
        }else{
            $file = $match[2];
        }

        if(!preg_match("#img4399\.com#is", $imgPath['host'])){
            $imgInfo = getimagesize($file);
            $flag = 1;
            $class = "";
            $width = $imgInfo[0];
            if($width > 300){
                $width = 300;
                $flag = $width / $imgInfo[0];
                $class = "showImg";
            }
            $height = intval($flag * $imgInfo[1]);
        } else {
            $class = "showImg";
        }

        return "<img src='" . str_replace("~x300","", $file) . "' alt='" . $alt_info[1][0] . "' class='" . $class . "'/>";
    }

    //转化成快爆链接
    static function convertHykbUrl($url){
        $result = array('url' => $url, 'is_save' => true);
        if(preg_match('#^http://(m\.)?news\.4399\.com/#i', $url)){
            if(preg_match('#(\d+)\.(htm|html)#', $url, $matches)){
                $aid = intval($matches[1]);
                if($aid > 281365){ //手游文章最小ID
                    $result['url'] = self::getArcUrl($aid);
                } else {
                    $result['is_save'] = false; //不保留地址
                }
            } else {
                $result['is_save'] = false; //不保留地址
            }
        } else if(preg_match('#^http://v\.4399pk\.com/#i', $url)){
            if(preg_match('#video\_(\d+)\.htm#', $url, $matches)){
                $vid = intval($matches[1]);
                $result['url'] = self::getVideoDetailUrl($vid);
            } else {
                $result['is_save'] = false; //不保留地址
            }
        }

        return $result;
    }

    //转化为wapUrl
    static function formatWapUrl($url){
        $url = trim($url);
        // http://news.4399.com/mobile/ -> http://m.news.4399.com/
        // http://news.4399.com/xxx -> http://m.news.4399.com/xxx
        if (preg_match('#^http://news\.4399\.com/#', $url)) {
            return str_replace(array('http://news.4399.com/mobile/','http://news.4399.com/'), 'http://m.news.4399.com/', $url);
        }
        // http://v.4399pk.com/ -> http://v.4399pk.com/mobile/
        if (preg_match('#^http://v\.4399pk\.com/#', $url)) {
            if (!preg_match('#^http://v\.4399pk\.com/mobile/#', $url)) {
                $url = str_replace('http://v.4399pk.com/', 'http://v.4399pk.com/mobile/', $url);
            }
            return $url;
        }
        // http://a.4399.cn/game-id-36169.html -> http://a.4399.cn/mobile/36169.html
        // http://i.4399.cn/game-id-146845.html -> http://i.4399.cn/mobile/146845.html
        if (preg_match('#^http://[a|i]\.4399\.cn/game-id-[\d]+\.html#', $url)) {
            return preg_replace('#game-id-([\d]+)#', 'mobile/$1', $url);
        }
        // http://bbs.4399.cn/forums-mtag-82209 -> http://bbs.4399.cn/m/forums-mtag-82209
        if (preg_match('#^http://bbs\.4399\.cn/#', $url)) {
            if (!preg_match('#^http://bbs\.4399\.cn/m/#', $url)) {
                $url = str_replace('http://bbs.4399.cn/', 'http://bbs.4399.cn/m/', $url);
            }
            return $url;
        }
        return $url;
    }

    //处理图片链接
    static function dealImg($imgurl){
        return self::reLink(preg_replace('#f\d{1,3}\.img4399\.com#', 'fs.img4399.com', $imgurl));
    }

    //去掉http:
    static function reLink($link){
        return str_ireplace(array('https://', 'http://'), '//', $link);
    }

    static function dealBody($content){
        $content = preg_replace('#(<(?:img|video)[^>]+(?:src|href)=\s*[\'"]?)http:#i','\1',$content);
        $content = str_replace('http:\\/\\/newsimg.5054399.com\\/', '\\/\\/newsimg.5054399.com\\/', $content);
        $content = preg_replace('#[\'"](/uploads/userup/[a-z0-9/]+.jpg)[\'"]#iUs', '"//newsimg.5054399.com$1"', $content);
        $arcUrl = self::getArcUrl('$2');
        $videoDetailUrl = self::getVideoDetailUrl('$1');
        $content = preg_replace(array('#http://(m.)?news.4399.com[a-z0-9/]+(\d{6,}).(htm|html)#iUs', '#http://v.4399pk.com[a-z0-9/]+video_(\d+).htm#iUs'), array($arcUrl, $videoDetailUrl), $content);
        return $content;
    }

    static function clearBody($content){
        $reg = array(
            "/width=(\'|\").*?(\'|\")/is",
            "/<table.*?>/is",
            "/<div style=\"MARGIN: 0px auto; WIDTH: 600px\">/is",
            "/<img.*?src=\".*?\/include\/FCKeditor.*?\".*?\/>/",
            "/#p#.*?#e#/",
            "/&nbsp;/is",
            "/style=\".*?\"/is",
            "/#cp#/is",
            "/#ce#/is",
            "/#cp2#/is",
            "/#ce2#/is",
            "/#cp3#/is",
            "/#ce3#/is",
        );
        $replace = array(
            "",
            "<table border='0' width='100%' cellpadding='0' cellspacing='0'>",
            "<div>",
            "",
            "",
            "","",
            "",
            "",
            "",
            "",
        );

        $content = preg_replace($reg, $replace, $content);
        $pattern = "/<img([^>]*?)src=(?:\"|\')(.*?)(?:\"|\')(.*?)\/>/is";
        $content = preg_replace_callback($pattern, "F::checkImgWidthHeight", $content);
        //投票处理
        $regCallback2 = "/\<center(?:\s+?)data-info=\"toupiao_(\d{1,6})_(\d{1})\">(?:.*?)<\/center>/is";
        $content = preg_replace_callback($regCallback2, "F::show_toupiao", $content);
        $content = str_replace('target="_blank"', '', $content);
        $content = self::dealBody($content);
        return $content;
    }

    //投票的处理的替换回调函数
    static function show_toupiao($match){
        $toupiao_id = intval($match[1]);
        $po = intval($match[2]);
        $html = array();
        if($toupiao_id > 0 && $toupiao_id < 99999){
            $html[] = '<center>';
            $html[] = '<iframe id="HuatiVoteFrame_'.$po.'" name="HuatiVoteFrame_'.$po.'" width="100%" scrolling="no" allowtransparency="true" src="http://m.news.4399.com/js/huati_vote_wap.html?id='.$toupiao_id.'&autoheight=0&po='.$po.'&bgcolor=FFFFFF&switch=0&r='.time().'" frameborder="0"></iframe></center>';
        }
        return implode("",$html);
    }

    //获取文章链接
    static function getArcUrl($id){
        return '//' . $_SERVER['HTTP_HOST'] . '/article/' . $id . '.htm';
    }

    //获取视频详情页链接
    static function getVideoDetailUrl($id){
        return '//' . $_SERVER['HTTP_HOST'] . '/video/' . $id . '.htm';
    }

    //中英文截取
    static function cn_substr($string, $length, $change = '', $charset = 'utf-8'){
        if(iconv_strlen($string, $charset) <= $length){
            return $string;
        }

        return iconv_substr($string, 0, $length, $charset) . $change;
    }

    //人气榜
    static function rankTop(){
        global $mem;
        $key = MEM_PRE . 'rank_top';
        $rankTop = $mem->get($key);
        $expire = intval($rankTop['expire']);
        $data = (isset($rankTop['data']) && $rankTop['data']) ? $rankTop['data'] : array();
        if(!$rankTop || $expire < time()){
            $url = 'http://newsapp.5054399.com/cdn/android/ranktop-home-140-type-hot.htm';
            $rs = self::getCurl($url);
            if($rs){
                $rs = json_decode($rs, true);
                if($rs['code'] == 100){
                    $api_data = $rs['result']['data'];
                    if($api_data && is_array($api_data)){
                        $data = array_slice($api_data, 0, 10);
                        $rankTop = array('data' => $data, 'expire' => time() + 3600);
                        $mem->set($key, $rankTop, MEMCACHE_COMPRESSED, 7200);
                    }
                }
            }
        }
        return $data;
    }

    //获取文章内容替换信息
    static function GetArcReplace($zid, $aid){
        if(!$zid || !$aid){
            return array();
        }

        global $db, $mem;
        $key = MEM_PRE . 'arc_replace_' . $aid;
        $data = $mem->get($key);
        if($data === FALSE){
            $sql = "SELECT `wap_html`,`new_html` FROM `news_app_comm_arc_replace` WHERE `aid` = " . intval($aid) . " LIMIT 1";
            $row = $db->get_one($sql);
            if(!$row){
                $sql = "SELECT `wap_html`,`new_html` FROM `news_app_comm_arc_replace` WHERE `zid` = " . intval($zid) . " AND aid = 0 LIMIT 1";
                $row = $db->get_one($sql);
            }
            $data = array();
            if($row){
                $data = array('html' => $row['wap_html'] ? self::mb_unserialize($row['wap_html']) : array(), 'new_html' => $row['new_html']);
            } else {
                $sql = "SELECT `setting` FROM `news_app_comm_shouyou_global_setting` WHERE `key` = 'news_app_comm_arc_replace' LIMIT 1";
                $row = $db->get_one($sql);
                $t_data = $row['setting'] ? self::mb_unserialize($row['setting']) : array();
                $data = array('html' => array(), 'new_html' => $t_data['html']);
            }

            $data['html'] = array_filter($data['html']);
            $data['html'] = $data['html'] ? array_map("F::clearBody", $data['html']) : array();
            $data['new_html'] = $data['new_html'] ? str_replace('http://www.3839.com','http://m.3839.com', F::clearBody($data['new_html'])) : '';
            $mem->set($key, $data, MEMCACHE_COMPRESSED, 43200);
        }

        return $data;
    }

    //获取视频详情信息（从接口获得）
    static function getVideoDetail($id){
        if(!$id){
            return array();
        }

        global $mem;
        $key = MEM_PRE . 'video_detail_' . $id;
        $data = $mem->get($key);
        $expire = intval($data['expire']);
        $videoInfo = (isset($data['info']) && $data['info']) ? $data['info'] : array();
        if(!$data || $expire < time()){
            $api_url = 'http://newsapp.5054399.com/cdn/android/videodetail-home-140-id-' . $id . '.htm';
            $api_rs = self::getCurl($api_url);
            if($api_rs){
                $api_rs = json_decode($api_rs, true);
                if($api_rs['code'] == 100){
                    $videoInfo = $api_rs['result'];
                    $data = array('info' => $videoInfo, 'expire' => time() + 3600);
                    $mem->set($key, $data, MEMCACHE_COMPRESSED, 7200);
                }
            }
        }

        return $videoInfo;
    }

    //获取视频信息（从数据库获得）
    static function getVideoData($id){
        $id = intval($id);
        if(!$id){
            return array();
        }

        global $db;
        $videoInfo = array();
        $sql = "SELECT `gameid` FROM `dede_video` WHERE `id`={$id} LIMIT 1";
        $rs = $db->get_one($sql);
        if($rs){
            $videoInfo = $rs;
        }

        return $videoInfo;
    }

    //游戏视频信息
    static function getVideoGameInfo($gid){
        $gid = intval($gid);
        if(!$gid){
            return array();
        }

        global $db;
        $videoGameInfo = array();
        $sql = "SELECT `newslanmuid` FROM `dede_videogame` WHERE `id`=" . $gid . " LIMIT 1";
        $rs = $db->get_one($sql);
        if($rs){
            $videoGameInfo = $rs;
        }

        return $videoGameInfo;
    }

    //通过视频ID获取专区ID
    static function getZidByVid($id){
        if(!$id){
            return 0;
        }

        global $mem;
        $key = MEM_PRE . 'video_zid_' . $id;
        $zid = $mem->get($key);
        if($zid === FALSE){
            $zid = 0;
            $videoInfo = self::getVideoData($id);
            $gameid = intval($videoInfo['gameid']);
            if($gameid){
                $videoGameInfo = self::getVideoGameInfo($gameid);
                $zid = $videoGameInfo['newslanmuid'];
            }

            $mem->set($key, $zid, 0, 43200);
        }

        return intval($zid);
    }

    //通过专区ID获取快爆ID
    static function getKbidByZid($zid){
        if(!$zid){
            return 0;
        }

        global $db, $mem;
        $key = MEM_PRE . 'kb_id_' . $zid;
        $kb_id = $mem->get($key);
        if($kb_id === FALSE){
            $kb_id = 0;
            $sql = "SELECT `kb_id` FROM `app_comm_hykb_download_sync` WHERE `zq_id`={$zid} LIMIT 1";
            $info = $db->get_one($sql);
            if($info){
                $kb_id = $info['kb_id'];
            }
            $mem->set($key, $kb_id, 0, 86400);
        }

        return intval($kb_id);
    }

    //解决utf-8编码下unserialize问题
    static function mb_unserialize($serial_str) {
        $serial_str = str_replace("\r", "", $serial_str);
        $serial_str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str);
        return self::strip_recursive(unserialize($serial_str));
    }

    static function strip_recursive($str){
        if( is_array($str) ){
            foreach($str as $k => $v){
                $str[$k] = str_replace('\"', '"', $v);
            }
        } else if( is_string($str) ){
            $str = str_replace('\"', '"', $str);
        }
        return $str;
    }

    static function getCurl($url, $post_data = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($post_data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        $resp = curl_exec($ch);
        curl_close($ch);
        return $resp;
    }

    //跳到3839首页
    static function redirectIndex(){
        header('Location:https://m.3839.com/wap.html');
        die();
    }

    //跳转到404
    static function redirect404(){
        header('Location:https://www.3839.com/search/search_404.html');
        die();
    }

    static function g2u($data){
        return is_array($data) ? array_map(array(__CLASS__, 'g2u'), $data) : iconv("GBK", "UTF-8//IGNORE", $data);
    }

    static function u2g($data){
        return is_array($data) ? array_map(array(__CLASS__, 'u2g'), $data) : iconv("UTF-8", "GBK//IGNORE", $data);
    }

}


