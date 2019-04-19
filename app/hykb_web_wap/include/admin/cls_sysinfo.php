<?php
defined('APP_PATH') or exit('Access Denied');
class sysinfo extends Controller {

    function init(){
        global $db;
        $this->db = $db;
    }
    // 首页配置
    function indexinfoAction(){
        $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='wap_indexinfo' LIMIT 1";
        $rs = $this->db->get_one($sql);
        $indexinfo = $rs['data'];
        if ($indexinfo) {
            $indexinfo = json_decode($indexinfo,true);
        }
        if (!$indexinfo['links']) {
            $indexinfo['links'] = array(array(),array());
        }
        include ADMIN_TPL_PATH.'/sysinfo_indexinfo.php';
    }
    // 保存首页配置
    function indexinfoSaveAction(){
        $indexinfo = $this->getRequestVal('post.indexinfo','','trim,htmlspecialchars');
        $this->filterEmptyArr($indexinfo['links']);
        $indexinfo = json_encode($indexinfo);
        $indexinfo = mysql_real_escape_string($indexinfo);
        $sql = "UPDATE " . C::$table_sysinfo . " SET data='{$indexinfo}' WHERE code = 'wap_indexinfo'";
        $this->db->query($sql);
        $this->jsAlert('操作成功', "?m=sysinfo&ac=indexinfo");
    }

    // 游戏友链全局配置
    function commGamelinkAction(){
        $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='wap_comm_gamelink' LIMIT 1";
        $rs = $this->db->get_one($sql);
        $comm_gamelink = $rs['data'];
        if ($comm_gamelink) {
            $comm_gamelink = json_decode($comm_gamelink,true);
        }
        if (!$comm_gamelink) {
            $comm_gamelink = array(array(),array());
        }
        include ADMIN_TPL_PATH.'/sysinfo_comm_gamelink.php';
    }
    // 保存游戏友链全局配置
    function commGamelinkSaveAction(){
        $comm_gamelink = $this->getRequestVal('post.comm_gamelink','','trim,htmlspecialchars');
        $this->filterEmptyArr($comm_gamelink);
        $comm_gamelink = json_encode($comm_gamelink);
        $comm_gamelink = mysql_real_escape_string($comm_gamelink);
        $sql = "UPDATE " . C::$table_sysinfo . " SET data='{$comm_gamelink}' WHERE code = 'wap_comm_gamelink'";
        $this->db->query($sql);
        $this->jsAlert('操作成功', "?m=sysinfo&ac=comm_gamelink");
    }
    // 游戏友链列表
    function gamelinkListAction(){
        include INC_PATH.'/admin/cls_pager.php'; 
        $keyword = $this->getRequestVal('post.keyword','','trim,htmlspecialchars');
        $where  = '';
        if ($keyword) {
            if (preg_match('/^\d+$/',$keyword)) {
                $where = " WHERE gameid='{$keyword}'";
            } else {
                $where = " WHERE gamename like '%{$keyword}%'";
            }
        }

        $sql = "SELECT COUNT(*) AS c FROM ".C::$table_game_link." {$where}  ";
        $temp = $this->db->get_one($sql);
        $count = $temp['c'];
        $pagesize = 15;
        $page = intval($_REQUEST['pg']);
        $page = max(1,$page);

        $list = array();
        $sql = "SELECT gameid,gamename FROM ".C::$table_game_link." {$where} ORDER BY addtime DESC,gameid ASC LIMIT ".(($page-1)*$pagesize).",$pagesize";
        $query = $this->db->query($sql);
        while($rs = mysql_fetch_assoc($query)) {
            $list[] = $rs;
        }
        
        include ADMIN_TPL_PATH.'/sysinfo_gamelink_list.php';
    }
    // 编辑单个游戏友链接
    function gamelinkEditAction(){
        $gameid = intval($_REQUEST['gameid']);
        $links = array();
        if ($gameid>0) {
            $sql = "select * from ".C::$table_game_link." WHERE gameid='{$gameid}' ";
            $rs = $this->db->get_one($sql);
            if ($rs['links']) {
                $links = json_decode($rs['links'],true);
            }
        }
        if (!$links) {
            $links = array(array(),array());
        }
        
        include ADMIN_TPL_PATH.'/sysinfo_gamelink_edit.php';
    }
    // ajax根据游戏ID获取游戏名称
    function gamelinkGetnameAction(){
        $gameid = intval($_POST['gameid']);
        $result = array();
        if ($gameid>0) {
            $return = Comm::getGameData($gameid);
            if ($return['title']) {
                $result = array('status'=>1,'title'=>$return['title']);
                echo json_encode($result);
                die('');
            } else {
                $result = array('status'=>0,'msg'=>'获取不到游戏信息，请检查游戏ID填写是否正确');
                echo json_encode($result);
                die('');
            }
        } else {
            $result = array('status'=>0,'msg'=>'游戏ID填写错误');
            echo json_encode($result);
            die('');
        }
    }
    // 保存单个游戏友链接
    function gamelinkSaveAction(){
        $gameid = intval($_POST['gameid']);
        $gamename = $this->getRequestVal('post.gamename','','trim,htmlspecialchars');
        $links = $this->getRequestVal('post.links','','trim,htmlspecialchars');
        $this->filterEmptyArr($links);
        $links = json_encode($links);
        $links = mysql_real_escape_string($links);

        $sql = "SELECT * FROM ".C::$table_game_link." WHERE gameid='{$gameid}' ";
        $r = $this->db->get_one($sql);
        if ($r) {
            $sql = "UPDATE ".C::$table_game_link." SET gameid='{$gameid}',gamename='{$gamename}',links='{$links}' WHERE gameid='{$gameid}' ";
            $this->db->query($sql);
            $this->jsAlert('更新成功', "?m=sysinfo&ac=gamelink_list");
        } else {
            $sql = "INSERT INTO ".C::$table_game_link."(gameid,gamename,links,addtime) VALUES('{$gameid}','{$gamename}','{$links}','".time()."') ";
            $this->db->query($sql);
            $this->jsAlert('添加成功', "?m=sysinfo&ac=gamelink_list");
        }
    }
    // 删除单个友链
    function gamelinkDelAction(){
        $gameid = intval($_REQUEST['gameid']);
        if ($gameid<=0){
            die('参数错误');
        }
        $sql = "DELETE FROM ".C::$table_game_link." WHERE gameid='{$gameid}' ";
        $this->db->query($sql);
        $this->jsAlert('删除成功', "?m=sysinfo&ac=gamelink_list");
    }
    /**
     * 过滤空数组
     * @param $arr
     */
    public function filterEmptyArr(&$arr){
        if (is_array($arr)) {
            foreach ($arr as $key => $val) {
                if (is_array($val)) {
                    $this->filterEmptyArr($arr[$key]);
                }
            }
            $is_all_empty = true;
            foreach ($arr as $val){
                if (!empty($val)) {
                    $is_all_empty = false;
                    break;
                }
            }
            if ($is_all_empty) {
                $arr = array();
            }
            foreach ($arr as $key => $val) {
                if (is_array($val) && !$val) {
                    unset($arr[$key]);
                }
            }
        }
    }
}