<?php
/****
if ($_SERVER["REMOTE_ADDR"] <> $_SERVER["SERVER_ADDR"]) {
	echo "What Do u Want to do??";
	exit;
}
*/
error_reporting(E_ALL^E_NOTICE);
header('content-type:text/html;charset=utf-8');
date_default_timezone_set("Asia/Shanghai");

if (is_dir('/www/t.news.4399.com')) {
    define('ROOT_PATH', '/www/t.3839.com');
    define('APP_PATH','/www/t.m.3839.com/app/hykb_web_wap');
} else {
    define('ROOT_PATH', '/www/m.3839.com');
    define('APP_PATH','/www/m.3839.com/app/hykb_web_wap');
}
$t1 = microtime(true);

define('WEB_ROOT', '/app/hykb_web_wap');
define('INC_PATH',APP_PATH.'/include');
define('TPL_PATH',APP_PATH.'/template/default');
require INC_PATH.'/config.php';;//$_sc_root重写，写死路径
require INC_PATH.'/cls_comm.php';
require INC_PATH.'/cls_db.php';
   //生成分类聚合页
    
        $return=Comm::curl_get(C::$api_category,12); 
		$return=json_decode($return,true);
		$catlist=$return['result']['category'];
		$view_url = Comm::get_view_url('category','index');
	    $make_url = Comm::get_url('category','',array('view_ishtml'=>1,'cid'=>$cid));
		$html=Comm::curl_get($view_url,1800);
				$file = $make_url;
				if (strpos($file,$_sc_base_url)===0) {
				 $file = str_replace($_sc_base_url,'',$file);
				}
		   $r=Comm::make_html($file, $html);
	
   //生成合辑聚合页
        $tarr=array('hot','recent');
        foreach($tarr as $k=>$type){
            $view_url=Comm::get_view_url('coll','coll',array('type'=>$type));
            $make_url=Comm::get_url('coll',$type,array('view_ishtml'=>1));
            $html =Comm::curl_get($view_url,1800);
            if (strlen($html)<500) {echo '获取合辑接口失败1';return false;}
            $file = $make_url;
            if (strpos($file,$_sc_base_url)===0) {
                $file = str_replace($_sc_base_url,'',$file);
            }
            Comm::make_html($file, $html);
        }
	
        foreach($tarr as $k=>$type){
            $view_url=Comm::get_view_url('coll','tags',array('type'=>$type));
            $make_url=Comm::get_url('coll','tags',array('view_ishtml'=>1,'type'=>$type));
            $html =curl_get($view_url,1800);
            if (strlen($html)<500) {echo '获取合辑接口失败2';return false;}
            $file = $make_url;
            if (strpos($file,$_sc_base_url)===0) {
                $file = str_replace($_sc_base_url,'',$file);
            }
            Comm::make_html($file, $html);
        }  
   
    //生成合辑详情
	    $tarr=array('hot','recent');
        foreach($tarr as $k=>$type){
            $return=curl_get(C::$api_collection_tags,1800);
            if(!$return){die("获取分类详情接口数据失败".$hot);}
            $return=json_decode($return,true);
            if($return['code']!=100 || empty($return['result'])){
              return false;
            }
            $catlist=$return['result'];
            foreach($catlist as $k=>$v){
                foreach($v['list'] as $k1=>$v1){
                    $id=$v1['id'];
                    makeOnecollectionAction($id,$type);
                }
            }
        }
   
   
 	function makeOnecollectionAction($id,$type){    //type  hot   id  3
	    global $_sc_base_url;
	    $view_url = Comm::get_view_url('coll','coll_detail',array('type'=>$type,'id'=>$id));
        $make_url = Comm::get_url('coll',$type,array('view_ishtml'=>1,'id'=>$id));
        $html =curl_get($view_url,1800);
        if (strlen($html)<500) { 
		  echo '获取合辑接口失败3333';
		  return false;
		} 

        $file = $make_url;
        if (strpos($file,$_sc_base_url)===0) {
            $file = str_replace($_sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);
	}  
   
   
     function curl_get($url, $timeout=6) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch,CURLOPT_FLOOWLOCATION,false);
		 $content = curl_exec($ch);
		if( $content === false){
		  echo curl_error($ch);
		  return false;
		}
		curl_close($ch);
		return $content;
    }	
   
   
   

