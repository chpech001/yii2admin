<?php
defined('APP_PATH') or exit('Access Denied');
class gameseo extends Controller {
    function init(){
        global $db;
        $this->db = $db;
    }
	
	public function listAction(){
        include INC_PATH.'/admin/cls_pager.php'; 
        $keyword = $this->getRequestVal('post.keyword','','trim,htmlspecialchars');
        $where  = '';
        if ($keyword) {
            if (preg_match('/^\d+$/',$keyword)) {
                $where = " WHERE gameid=$keyword";
            } else {
                $where = " WHERE gamename like '%{$keyword}%'";
            }
        }

        $sql = "SELECT COUNT(*) AS c FROM cpp_hykbwap_seogame {$where}  ";
        $temp = $this->db->get_one($sql);
        $count = $temp['c'];
        $pagesize = 15;
        $page = intval($_REQUEST['pg']);
        $page = max(1,$page);

        $list = array();
        $sql = "SELECT * FROM cpp_hykbwap_seogame {$where}  LIMIT ".(($page-1)*$pagesize).",$pagesize";
        $query = $this->db->query($sql);
        while($rs = mysql_fetch_assoc($query)) {
            $list[] = $rs;
        }
        
        include ADMIN_TPL_PATH.'/gameseo_list.php';
	}	
	public function editAction(){
	  $gameid=(int) $_REQUEST['gameid'];
	  $sq="select * from cpp_hykbwap_seogame where gameid=".$gameid;
	  $rs=$this->db->get_one($sq);
	  if(!empty($_POST)){
	     $gamename=htmlspecialchars($this->_format($_REQUEST['gamename']));
		 $title=htmlspecialchars($this->_format($_REQUEST['title']));
		 $keyword=htmlspecialchars($this->_format($_REQUEST['keyword']));
		 $desc=htmlspecialchars($this->_format($_REQUEST['desc']));
		 if(empty($gameid) || empty($gamename) || empty($keyword) || empty($desc) || empty($title)){
		   $this->jsAlert('请填写完整的信息');  
		 }
	     if(!empty($rs)){
		   $upsql="update cpp_hykbwap_seogame set gamename='$gamename',title='$title',keyword='$keyword',desc1='$desc' where gameid=".$gameid;
		   $this->db->query($upsql);
		   $this->jsAlert('更新成功', "?m=gameseo&ac=list"); 
		 }else{
		   $isql="insert into cpp_hykbwap_seogame (gameid,gamename,title,keyword,desc1) values($gameid,'$gamename','$title','$keyword','$desc')";
		   $this->db->query($isql);
		   $this->jsAlert('添加成功', "?m=gameseo&ac=list");
		 }
	  }
	  include ADMIN_TPL_PATH.'/gameseo_edit.php';
	}
	
	public function _format($msg){
	    $reg = "/script|select|join|union|where|insert|delete|update|like|drop|create|modify|rename|alter|cas|load_file|outfile|truncate|declare|>|#|<|\&|css|\/|\"|\'|\(|\)|prompt|=|%/i";
		$str =trim(preg_replace($reg,"",$msg));	
	    return $str;
	}

	public function delAction(){
	  $gameid=(int) $_REQUEST['gameid'];
	  $sq="delete from cpp_hykbwap_seogame where gameid=".$gameid;
	  $this->db->query($sq);
	  $this->jsAlert('删除成功', "?m=gameseo&ac=list");
	}	
	
	
	public function genAction(){
	    $id=(int) $_REQUEST['gameid'];
	    $view_url = Comm::get_view_url('game_detail','',array('id'=>$id));
        $make_url = Comm::get_url('game_detail','',array('view_ishtml'=>1,'id'=>$id));
        $html = Comm::curl_get($view_url,1800);
        if (strlen($html)<500) { die('文件内容获取失败：'.$html);} 
        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);
        echo '页面生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>';
	}	

}