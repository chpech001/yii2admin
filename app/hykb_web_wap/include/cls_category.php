<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 分类页
 */ 
class category extends Controller {
    // 获取首页配置
    function getIndexinfo(){
        global $db;
        $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='wap_indexinfo' LIMIT 1 ";
        $temp = $db->get_one($sql);
        $indexinfo = array();
        if ($temp['data']) {
            $indexinfo = json_decode($temp['data'],true);
        }
        return $indexinfo;
    }

   //生成分类聚合页
   public function indexAction(){
        global $db;
       $cid=(int) $_REQUEST['cid'];
       $return=Comm::curl_get(C::$api_category,12); 
	   if(!$return){die("获取分类详情接口数据失败");}
	   $return=json_decode($return,true);
	   if($return['code']!=100 || empty($return['result'])){
	    die("获取分类详情失败失败");
	   }   
	  $indexinfo = $this->getIndexinfo();  
	  $sq="select * from cpp_hykbwap_friendlink where type=3";
	  $rs=$db->get_one($sq);
	  $catlinks=unserialize($rs['flink']);	      
       ob_start();
	  include TPL_PATH.'/category_index.php';
	  $html=ob_get_contents();
	  ob_clean();
	  $html = Comm::reHtml($html);
	  echo $html;
	  die('');
	 
   } 
  
   //生成单个分类页面
   public function categoryDetailAction(){
     $id=(int) $_REQUEST['id'];
	 $type=$_REQUEST['type'];
	 $typemode=array('hot','new','star');
	 if(!in_array($type,$typemode) || empty($id)){
	   die('Access Denied');
	 }
	 if($type=='hot'){$api=C::$api_category_detail_hot;}
	 if($type=='new'){$api=C::$api_category_detail_new;}
	 if($type=='star'){$api=C::$api_category_detail_star;}
	 $api=str_replace('{cid}',$id,$api);
     $catename='';$cnt=0;
	 $gamelist=array();
	 for($p=1;$p<=50;$p++){
	   $gapi=str_replace('{p}',$p,$api);
       $return=Comm::curl_get($gapi);
       $return=json_decode($return,true);
	   $list=$return['result']['data']['list'];
	   if($return['code']!=100){ die('新奇页面接口信息获取出错');}
	   if(empty($list)){break;}
	   if($p==1){$catename=$return['result']['data']['title'];}
	   foreach($list as $k=>$v){
	     $gamelist[$cnt]['star']=$v['star'];
		 $gamelist[$cnt]['title']=$v['title'];
		 $gamelist[$cnt]['icon']=$v['icon'];
		 $gamelist[$cnt]['id']=$v['id'];
		 $gamelist[$cnt]['status']=$v['downinfo']['status'];
		 $gamelist[$cnt]['num_size_lang']=$v['num_size_lang'];
         $tags=$v['tags'];
		 $tagstr='';$taglen=0;
		 for($kz=0;$kz<3;$kz++){
		   $ta=$tags[$kz]['title'];
		   if(!empty($ta)){
		    $taglen=mb_strlen($ta)+$taglen;
			if($taglen<=30){$tagstr.='<span>'.$ta.'</span>';}else{
			 break;
			}
		   }
		 }
		  $gamelist[$cnt]['tags']=$tagstr;
		 $cnt++;
	   }
	 }
     ob_start();
	 include TPL_PATH.'/category_detail.php';
	$html=ob_get_contents();
	ob_clean();
	 $html = Comm::reHtml($html);
	echo $html;
	die('');
   }
       
   
}