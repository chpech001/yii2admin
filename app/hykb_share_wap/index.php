<?php
require_once dirname(__FILE__) . '/common.php';

$ac = trim(strval($_GET['ac']));
switch($ac){
    case 'arc_detail':
        $id = intval($_GET['id']);
        if(!$id){
            F::redirectIndex();
        }

        $arcInfo = F::getArcInfo($id);
        if(!$arcInfo){
            F::redirectIndex();
        }

        if(!$arcInfo['author']){
            $arcInfo['author'] = '快报用户';
        } else {
            $arcInfo['author'] = str_replace('4399', '', $arcInfo['author']);
        }

        $zq_id = F::getZidByAid($id); //获取文章所在的专区ID
        $kb_id = F::getKbidByZid($zq_id); //通过专区ID获取快爆ID
        $gameInfo = array();
        if($kb_id){
            $gameInfo = F::getGameInfo($kb_id);
        }

        if(!$gameInfo || !$gameInfo['downinfo']){
            $gameInfo = F::getGameInfo(KB_ID);
        }

        //预约人数、下载人数
        $num_yuyue = 0;
        if ($gameInfo['num_yuyue']) {
            preg_match('/\d+(\.\d+)?(万)?/', $gameInfo['num_yuyue'], $match);
            $num_yuyue = $match[0];
        }

        $num_down = 0;
        if ($gameInfo['num_down']) {
            preg_match('/\d+(\.\d+)?(万)?/', $gameInfo['num_down'], $match);
            $num_down = $match[0];
        }

        //评分
        $star = floatval($gameInfo['star']);

        // 下载信息
        $downInfo = array(
            "kb_id" => $gameInfo['downinfo']['id'],
            "apkurl" => $gameInfo['downinfo']['apkurl'],
            "package" => $gameInfo['downinfo']['packag'],
            "appname" => $gameInfo['downinfo']['appname'],
            "icon" => F::dealImg($gameInfo['downinfo']['icon']),
            "md5" => $gameInfo['downinfo']['md5'],
        );

        $newHotList = F::getNewHotList($zq_id);
        $teseMenuList = F::getTeseMenuList($zq_id);
        $newList = $newHotList['new'];
        $hotList = $newHotList['hot'];
        $rankTop = F::rankTop();
        $newSyptztInfo = F::getNewSyptztInfo($zq_id);
        $wap_gsxz_tj = $newSyptztInfo['wap_gsxz_tj'] ? $newSyptztInfo['wap_gsxz_tj'] : array(); //高速下载旁边推荐
        $zq_url = '//m.3839.com/a/' . $gameInfo['id'] . '.htm';

        //文章内容替换
        $arc_replace = F::GetArcReplace($zq_id, $id);
        if($arc_replace['html']){
            $arcInfo['body'] = str_replace($arc_replace['html'], $arc_replace['new_html'], $arcInfo['body']);
        }
        if($arc_replace['new_html'] && strpos($arcInfo['body'], $arc_replace['new_html']) === FALSE){
            $arcInfo['body'] = $arcInfo['body'] . $arc_replace['new_html'];
        }

        $jsConf = array(
            "aid" => $id,
            "sign" => md5($id . '[qbpLW@1FYb+UVu*K%m*B2JwLoPEo1')
        );//获取文章浏览量需要的参数

        include TPL_PATH . 'arc_detail.php';
        break;
    case 'video_detail':
        $id = intval($_GET['id']);
        if(!$id){
            F::redirect404();
        }

        $videoDetail = F::getVideoDetail($id);
        if(!$videoDetail){
            F::redirect404();
        }

        $videoInfo = $videoDetail['data'];
        if(!$videoDetail){
            F::redirect404();
        }

        if(!$videoInfo['author']){
            $videoInfo['author'] = '快报用户';
        } else {
            $videoInfo['author'] = str_replace('4399', '', $videoInfo['author']);
        }

        $zq_id = F::getZidByVid($id);
        $kb_id = F::getKbidByZid($zq_id);
        $gameInfo = array();
        if($kb_id){
            $gameInfo = F::getGameInfo($kb_id);
        }

        if(!$gameInfo || !$gameInfo['downinfo']){
            $gameInfo = F::getGameInfo(KB_ID);
        }

        //预约人数、下载人数
        $num_yuyue = 0;
        if ($gameInfo['num_yuyue']) {
            preg_match('/\d+(\.\d+)?(万)?/', $gameInfo['num_yuyue'], $match);
            $num_yuyue = $match[0];
        }

        $num_down = 0;
        if ($gameInfo['num_down']) {
            preg_match('/\d+(\.\d+)?(万)?/', $gameInfo['num_down'], $match);
            $num_down = $match[0];
        }

        //评分
        $star = floatval($gameInfo['star']);

        // 下载信息
        $downInfo = array(
            "kb_id" => $gameInfo['downinfo']['id'],
            "apkurl" => $gameInfo['downinfo']['apkurl'],
            "package" => $gameInfo['downinfo']['packag'],
            "appname" => $gameInfo['downinfo']['appname'],
            "icon" => F::dealImg($gameInfo['downinfo']['icon']),
            "md5" => $gameInfo['downinfo']['md5'],
        );

        $teseMenuList = F::getTeseMenuList($zq_id);
        $rankTop = F::rankTop();
        $newSyptztInfo = F::getNewSyptztInfo($zq_id);
        $wap_gsxz_tj = $newSyptztInfo['wap_gsxz_tj'] ? $newSyptztInfo['wap_gsxz_tj'] : array(); //高速下载旁边推荐
        $zq_url = '//m.3839.com/a/' . $gameInfo['id'] . '.htm';

        include TPL_PATH . 'video_detail.php';
        break;
    default:
        break;
}

$db->close();
$mem->close();