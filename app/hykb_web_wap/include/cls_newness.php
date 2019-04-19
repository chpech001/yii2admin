<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 新奇首页
 */ 
class newness extends Controller {
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
   public function indexAction(){
      global $db;
     //获取新奇页面接口数据
	 $return=Comm::curl_get(C::$api_newness);
	 if(!$return){
	   die('获取新奇页面接口数据失败');
	 }
	 $return=json_decode($return,true);
	 if($return['code']!=100 || empty($return['result'])){
	   die('新奇页面接口信息获取出错');
	 }
	 $result=$return['result'];
     $indexinfo = $this->getIndexinfo();
	  //获取新奇页面配置信息
	   $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='newnessinfo' LIMIT 1 ";
       $rs = $db->get_one($sql);
	   $newnessinfo = $rs['data'];
        if ($newnessinfo) {
            $newnessinfo = json_decode($newnessinfo,true);
        }  
			//获取新奇友链
		 $sq="select * from cpp_hykbwap_friendlink where type=2";
	     $rs=$db->get_one($sq);
	     $newnesslinks=unserialize($rs['flink']); 
	   //获取所有分类
       $return1=Comm::curl_get(C::$api_category,1800); 
	   if(!$return1){die("获取分类详情接口数据失败");}
	   $return1=json_decode($return1,true);	
	   $category_arr=array();   
	   $catlist=$return1['result']['category'];	  
	   foreach($catlist as $k=>$v){
	     if(!empty($v['data'])){
			 foreach($v['data'] as $k1=>$v1){
			   $category_arr[]=$v1['id'];
			 }
		 }
	   } 
	 $category_arr[]=108;	   
     ob_start();
	 include TPL_PATH.'/newness.php';
	 $html=ob_get_contents();
	 ob_clean();
	 $html = Comm::reHtml($html);
	 echo $html;
	 die('');
   } 
}