<?php
defined('APP_PATH') or exit('Access Denied');
class friendlink extends Controller {
    function init(){
        global $db;
        $this->db = $db;
    }
	
	public function editAction(){
	  $type=(int) $_REQUEST['type'];
	  if($_POST){
        $linkstr=serialize($_POST['links']);
		$upsql="update cpp_hykbwap_friendlink set flink='$linkstr' where type=$type";
		$this->db->query($upsql); 
	    $this->jsAlert('设置成功', "?m=friendlink&ac=edit&type=".$type);
	  }
	  $links=array();
	  $sq="select * from cpp_hykbwap_friendlink where type=".$type;
	  $rs=$this->db->get_one($sq);
	  if(!empty($rs['flink'])){
	    $links=unserialize($rs['flink']);
	  }
	  if($type==1){$typename='排行榜友链';}
	  if($type==2){$typename='新奇友链';}
	  if($type==3){$typename='分类大全友链';}
	  include ADMIN_TPL_PATH.'/friendlink_edit.php'; 
	}	


}