<?php
  defined('APP_PATH') or exit('Access Denied');
/**
 * 新奇页面生成
 */ 
class make2 extends Controller {
    function init(){
        global $db;
        $this->db = $db;
    }
    function indexAction(){
	  $newness_url=Comm::get_view_url('newness');
	  $category_url=Comm::get_view_url('category');
	  $collection_url=Comm::get_view_url('coll');
	  $top_url=Comm::get_view_url('top','top',array('type'=>'hot'));
	  $wall_url=Comm::get_view_url('commentwall','index');
	  $anli_coll=Comm::get_view_url('commentwall','anli_coll');
	  $coll_url=Comm::get_view_url('coll','coll',array('type'=>'hot'));
	  $collrecent_url=Comm::get_view_url('coll','coll',array('type'=>'recent'));
	  $search_result_url=Comm::get_view_url('search','search_result');
	  $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='specialgame' LIMIT 1";
      $rs = $this->db->get_one($sql);
      include ADMIN_TPL_PATH.'/make2_index.php'; 
    }
	
	//生成新奇页面
	function makeNewnessAction(){
	    $view_url = Comm::get_view_url('newness');
        $make_url = Comm::get_url('newness','',array('view_ishtml'=>1));
        $html =Comm::curl_get($view_url,1800);
        if (strlen($html)<500) {
            Comm::log('err_make_newness_'.date("Ymd"),'生成失败：'.$html);
            die('文件内容获取失败：'.$html);
        } 

        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);

        echo '新奇页面生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>';
	}
	
	
	
	//生成搜索结果页
	function makeSearchresultAction(){
	    $view_url = Comm::get_view_url('search','search404');
        $make_url = Comm::get_url('search','nosearch',array('view_ishtml'=>1));
        $html = Comm::curl_get($view_url,1800);
        if (strlen($html)<500) {
            Comm::log('err_make_search404_'.date("Ymd"),'生成失败：'.$html);
            die('文件内容获取失败：'.$html);
        } 

        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);

        echo '搜索404页生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>';
	}	
	
	
	
	//生成分类首页
	function makeCategoryindexAction(){
        $return=Comm::curl_get(C::$api_category,12); 
		$return=json_decode($return,true);
		$catlist=$return['result']['category'];
			$view_url = Comm::get_view_url('category','index',array('cid'=>$cid));
			$make_url = Comm::get_url('category','',array('view_ishtml'=>1,'cid'=>$cid));
			$html=Comm::curl_get($view_url,300);
				if (strlen($html)<500) {
					Comm::log('err_make_categoryindex_'.date("Ymd"),'生成失败：'.$html);
					die('文件内容获取失败：'.$html);
				} 
	
				$file = $make_url;
				if (strpos($file,$this->sc_base_url)===0) {
				 $file = str_replace($this->sc_base_url,'',$file);
				}
			   Comm::make_html($file, $html);
			   echo '分类聚合页生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";	

		
	}
	
	function makeCategoryallAction(){
	  $return=Comm::curl_get(C::$api_category,1800); 
	   if(!$return){die("获取分类详情接口数据失败");}
	   $return=json_decode($return,true);
	   if($return['code']!=100 || empty($return['result'])){
	    die("获取分类详情失败失败");
	   }
	   $catlist=$return['result']['category'];	
	   foreach($catlist as $k=>$v){
	     foreach($v['data'] as $k1=>$v1){
		   $id=$v1['id'];
		    $this->makeOnecategoryAction($id);

		 }
	   } 
	}
	
	//生成分类详情
	function makeCategoryAction(){
	   set_time_limit(0);
	   $ids=$_REQUEST['ids'];
	   $idarr=explode(",",$ids);
	   if(empty($idarr)){
	     die("请填写分类ID");
	   }
	   foreach($idarr as $k=>$v){
	      $id=(int) $v;
		 $this->makeOnecategoryAction($id);
	   } 
	}



	//生成单个分类的详情
	function makeOnecategoryAction($id){
	    $typemode=array('hot','new','star');
		foreach($typemode as $type){
		    $view_url = Comm::get_view_url('category','categorydetail',array('id'=>$id,'type'=>$type));
            $make_url = Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$id,'type'=>$type)); 
			$html=Comm::curl_get($view_url,300);
			if (strlen($html)<500) {
				//Comm::log('err_make_onecategory_'.date("Ymd"),'分类id:'.$id.'生成失败：'.$html);
				//die('文件内容获取失败：'.$html);
				echo '分类id:'.$id.'生成失败'.'<br/>';
			} 

            $file = $make_url;
            if (strpos($file,$this->sc_base_url)===0) {
             $file = str_replace($this->sc_base_url,'',$file);
            }
           Comm::make_html($file, $html);
           echo '分类页面生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";			
		} 
	}


    //生成合辑首页
    function makeCollAction(){

        $tarr=array('hot','recent');

        foreach($tarr as $k=>$type){
            $view_url=Comm::get_view_url('coll','coll',array('type'=>$type));
            $make_url=Comm::get_url('coll',$type,array('view_ishtml'=>1));
            $html =Comm::curl_get($view_url,1800);
            if (strlen($html)<500) {
                Comm::log('err_make_coll_'.date("Ymd"),'生成失败：'.$html);
                die('文件内容获取失败：'.$html);
            }
            $file = $make_url;
            if (strpos($file,$this->sc_base_url)===0) {
                $file = str_replace($this->sc_base_url,'',$file);
            }
            Comm::make_html($file, $html);

            echo '合辑页面生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";
        }

        foreach($tarr as $k=>$type){
            $view_url=Comm::get_view_url('coll','tags',array('type'=>$type));
            $make_url=Comm::get_url('coll','tags',array('view_ishtml'=>1,'type'=>$type));

            $html =Comm::curl_get($view_url,1800);
            if (strlen($html)<500) {
                Comm::log('err_make_coll_tags_'.date("Ymd"),'生成失败：'.$html);
                die('文件内容获取失败：'.$html);
            }
            $file = $make_url;
            if (strpos($file,$this->sc_base_url)===0) {
                $file = str_replace($this->sc_base_url,'',$file);
            }
            Comm::make_html($file, $html);

            echo '合辑标签页面生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";
        }
    }

    function makeCollallAction(){

        $tarr=array('hot','recent');

        foreach($tarr as $k=>$type){

            $return=Comm::curl_get(C::$api_collection_tags,1800);
            if(!$return){die("获取分类详情接口数据失败");}
            $return=json_decode($return,true);
            if($return['code']!=100 || empty($return['result'])){
                die("获取分类详情失败失败");
            }
            $catlist=$return['result'];
            foreach($catlist as $k=>$v){
                foreach($v['list'] as $k1=>$v1){
                    $id=$v1['id'];
                    $this->makeOnecollectionAction($id,$type);
                }
            }
        }
    }
	
	
	//生成单个合辑的详情
	function makeOnecollectionAction($id,$type){    //type  hot   id  3
	    $view_url = Comm::get_view_url('coll','coll_detail',array('type'=>$type,'id'=>$id));
        $make_url = Comm::get_url('coll',$type,array('view_ishtml'=>1,'id'=>$id));
        $html =Comm::curl_get($view_url,1800);
        if (strlen($html)<500) {
            Comm::log('err_make_colldetail_'.date("Ymd"),'生成失败：'.$html);
            die('文件内容获取失败：'.$html);
        } 

        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);

        echo '合辑id:'.$type.'_'.$id.'生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";
	}

    //生成合辑文章详情
    function makeCollarcAction(){

        set_time_limit(0);
        $ids=$_REQUEST['ids'];
        $idarr=explode(",",$ids);
        if(empty($idarr)){
            die("请填写合辑文章ID");
        }
        foreach($idarr as $k=>$v){

            $id=intval($v);
            $view_url = Comm::get_view_url('coll','arcdetail',array('id'=>$id));
            $make_url = Comm::get_url('coll','detail',array('id'=>$id,'view_ishtml'=>1));
            $html =Comm::curl_get($view_url,1800);
            if (strlen($html)<500) {
                Comm::log('err_make_collarcdetail_'.date("Ymd"),'生成失败：'.$html);
                die('合辑id_'.$v.'文件内容获取失败：'.$html);
            }

            $file = $make_url;
            if (strpos($file,$this->sc_base_url)===0) {
                $file = str_replace($this->sc_base_url,'',$file);
            }
            Comm::make_html($file, $html);

            echo '合辑id_'.$id.'生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";
        }
    }

    //生成安利墙首页
    function makeCommentwallAction(){

        $tarr = array('index', 'anli_coll');
        foreach ($tarr as $k => $ac) {

            $view_url = Comm::get_view_url('commentwall', $ac);
            $make_url = Comm::get_url('commentwall', $ac, array('view_ishtml' => 1));
            $html = Comm::curl_get($view_url, 1800);
            if (strlen($html) < 500) {
                Comm::log('err_make_commentwall_' . date("Ymd"), '生成失败：' . $html);
                die('文件内容获取失败：' . $html);
            }

            $file = $make_url;
            if (strpos($file, $this->sc_base_url) === 0) {
                $file = str_replace($this->sc_base_url, '', $file);
            }
            Comm::make_html($file, $html);

            echo '安利墙首页生成成功: <a href="' . $this->sc_base_url . $file . '?t=' . time() . '">' . $file . '</a></br>';
        }
    }
   //生成排行榜页面
   function makeTopAction(){
     $tarr=array('expect','sugar','hot','manu','player');
	 $api_top=C::$api_top; 
	 foreach($tarr as $k=>$type){
        $view_url=Comm::get_view_url('top','top',array('type'=>$type));
	    $make_url=Comm::get_url('top',$type,array('view_ishtml'=>1));
        $html =Comm::curl_get($view_url,1800);
        if (strlen($html)<500) {
            Comm::log('err_make_top_'.date("Ymd"),'生成失败：'.$html);
            die('文件内容获取失败：'.$html);
        } 
        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);

        echo '排行榜页面生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";		
	 }
   }	
   

   
   
   
   //生成安利墙详情
   
   /*function makewalldetailAction(){
	   $api_commentwall=C::$api_commentwalllist;
	   $allwall=array();$cnt=0;
	   for($kn=1;$kn<=50;$kn++){
	       $gapi=str_replace('{p}',$kn,$api_commentwall);
		   $return=Comm::curl_get($gapi,12); 
		   if(!$return){die("获取安利墙接口数据失败");}
		   $return=json_decode($return,true);
		   if($return['code']!=100 || empty($return['result'])){
			die("获取安利墙详情失败");
		   } 
		   $data=$return['result']['data'];
		   if(empty($data)){break;}
		   foreach($data as $k=>$v){
		     $allwall[$cnt]=$v;
			 $cnt++;
		   }
	   } 
	    $gwall=array_rand($allwall,7);//随机评论
		foreach($gwall as $k=>$v){
		 $rand_wall[$k]=$allwall[$v];
		}
	    foreach($allwall as $k=>$v){
	         $make_url=Comm::get_url('commentwall','detail',array('id'=>$v['fid'],'view_ishtml'=>1));
			 $view_url = Comm::get_view_url('commentwall','detail');
			 $html =Comm::curl_post($view_url,array('data'=>serialize($v),'randdata'=>serialize($rand_wall)));
		     if (strlen($html)<500) {
               Comm::log('err_make_commentwall_detail'.date("Ymd"),'生成失败：'.$html);
               die('文件内容获取失败：'.$html);
            } 
            $file = $make_url;
            if (strpos($file,$this->sc_base_url)===0) {
              $file = str_replace($this->sc_base_url,'',$file);
            }
            Comm::make_html($file, $html); 
		  }	   
     }*/
	 
	 
	 
	 
	 
	   

   //生成单个开发者详情页
   function makeOnemanuAction($id){
     	$view_url = Comm::get_view_url('manu','detail',array('uid'=>$id));
        $make_url = Comm::get_url('manu','detail',array('view_ishtml'=>1,'id'=>$id));
        $html =Comm::curl_get($view_url,1800);
        if (strlen($html)<500) {
            Comm::log('cron_err_make_manu'.date("Ymd"),'生成失败：'.$html);
            die('文件内容获取失败：'.$html);
        } 

        $file = $make_url;
        if (strpos($file,$this->sc_base_url)===0) {
            $file = str_replace($this->sc_base_url,'',$file);
        }
        Comm::make_html($file, $html);

        echo '开发者详情uid:'.$id.'生成成功: <a href="'.$this->sc_base_url.$file.'?t='.time().'">'.$file.'</a>'."<br/>";	
   }
   
   
  	//生成开发者详情
	function makemanuAction(){
	   set_time_limit(0);
	   $ids=$_REQUEST['ids'];
	   $idarr=explode(",",$ids);
	   if(empty($idarr)){
	     die("请填写合辑ID");
	   }
	   foreach($idarr as $k=>$v){
	      $id=(int) $v;
		  $this->makeOnemanuAction($id);
	   } 
	}    
   
    //指定游戏ID列表，每半小时生成一次的，保存游戏ID
    function makeSpecialgameAction(){
	  $ids=$_REQUEST['ids'];
	  $sql = "UPDATE " . C::$table_sysinfo . " SET data='{$ids}' WHERE code = 'specialgame'";
      $this->db->query($sql);
      $this->jsAlert('操作成功', "?m=make2");
    }
	function testAction(){
	  $sql="insert into hykb_web_sysinfo (code) values ('specialgame')";
	  $result=$this->db->query($sql); 
	  if($result){
	    echo 'yes';
	  }else{
	    echo 'no';
	  }
	}

}