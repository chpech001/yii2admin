<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 新奇首页
 */ 
class top extends Controller {
   private function getIndexinfo(){
        global $db;
        $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='wap_indexinfo' LIMIT 1 ";
        $temp = $db->get_one($sql);
        $indexinfo = array();
        if ($temp['data']) {
            $indexinfo = json_decode($temp['data'],true);
        }
        return $indexinfo;
    }
   //生成排行榜页面
   public function topAction(){
      global $db;
	  $type=$_REQUEST['type'];
	  if(!in_array($type,array('expect','sugar','hot','manu','player'))){die("参数错误");} 
	   if($type=='player'){ 
	       $api_top=C::$api_hotplayer; 
	   }elseif($type=='manu'){
           $api_top=C::$api_hotmanu; 
		}else{
		   $api_top=C::$api_top; 
		   $api_top=str_replace('{type}',$type,$api_top);
		}
		   $return=Comm::curl_get($api_top,12); 
		   if(!$return){die("获取排行榜接口数据失败");}
		   $return=json_decode($return,true);
		   if($return['code']!=100 || empty($return['result'])){
			die("获取排行榜数据详情失败");
		   } 
		   
		//获取排行榜友情链接 
	    $sq="select * from cpp_hykbwap_friendlink where type=1";
	    $rs=$db->get_one($sq);
	    $toplinks=unserialize($rs['flink']);		      
	   if($type=='hot'){$title='人气排行榜';}
	   if($type=='expect'){$title='新游期待榜';}
	   if($type=='sugar'){$title='新品飙升榜';} 
	   if($type=='manu'){$title='热门开发者';}
	   if($type=='player'){$title='热门玩家排行榜';} 
	    $indexinfo = $this->getIndexinfo();             
        ob_start();
		 if($type=='player'){
		  include TPL_PATH.'/player.php';
		 }elseif($type=='manu'){
		  include TPL_PATH.'/manu.php';
		 }else{
		  include TPL_PATH.'/top.php';
		 }
		 $html=ob_get_contents();
		 ob_clean();
		 $html = Comm::reHtml($html);
	     $html = preg_replace('#http://fs.img4399.com#','//fs.img4399.com',$html);
		 $html = preg_replace('#http://imga.3839.com#','//imga.3839.com',$html);
		 echo $html;
		 die('');
   }   
   
}