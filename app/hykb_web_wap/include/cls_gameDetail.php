<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 首页
 */ 
 
class gameDetail extends Controller {
    // 获取游戏详情通用友链
    function getCommGamelink(){
        global $db;
        $sql = "SELECT * FROM ".C::$table_sysinfo." WHERE code='wap_comm_gamelink' LIMIT 1 ";
        $temp = $db->get_one($sql);
        $comm_gamelink = array();
        if ($temp['data']) {
            $comm_gamelink = json_decode($temp['data'],true);
        }
        return $comm_gamelink;
    }

    // 获取指定游戏友链
    function getGameLink($gameid) {
        global $db;
        $sql = "SELECT * FROM ".C::$table_game_link." WHERE gameid='{$gameid}' ";
        $rs = $db->get_one($sql);
        $links = array();
        if ($rs) {
            $links = json_decode($rs['links'],true);
        } else {
            $links = $this->getCommGamelink();
        }
        return $links;
    }
    function indexAction() {
        global $db,$_sc_base_url,$_sc_root;
        $id = intval($_REQUEST['id']);
        if ($id<=0) {
            die('参数错误');
        }

        $data = Comm::getGameData($id);

        if (!$data) {
            die('详情接口获取失败');
        }
        
        if ($data['show_url']==1) {
            // 不展示PC/wap页面
            die('show_url:不展示PC/wap页面'); // 提示信息show_url:...，不可更改，生成时调用到，更新数据表的生成状态
        }

        // 图片及视频地址替换
        $video_img = $video_link = '';
        if ($data['videoinfo']['icon']) {
            $video_img = Comm::reLink(Comm::replaceImg($data['videoinfo']['icon']));
            $video_link = Comm::reLink($data['videoinfo']['vlink']);
        }


        //预约人数、下载人数
        if ($data['num_yuyue']) {
            preg_match('/\d+(\.\d+)?(万)?/',$data['num_yuyue'],$match);
            $num_yuyue = $match[0];
        }

        if ($data['num_down']) {
            preg_match('/\d+(\.\d+)?(万)?/',$data['num_down'],$match);
            $num_down = $match[0];
        }

        // 下载信息
        $downInfo = array(
            "kb_id" => $data['downinfo']['id'],
            "apkurl" => $data['downinfo']['apkurl'],
            "package" => $data['downinfo']['packag'],
            "appname" => $data['downinfo']['appname'],
            "icon" => Comm::reLink(Comm::replaceImg($data['downinfo']['icon'])),
            "md5" => $data['downinfo']['md5'],
        );

        // 二维码
        $ewm = '//newsimg.5054399.com/uploads/allimg/171010/397_1047102004.jpg';
		//专区地址
		 $topic_id=$data['topicinfo']['id'];
         $modid=$topic_id%1000;
		 $zurl='https://m.3839.com/zhuanqu/'.$modid.'/'.$topic_id.'.htm';
        // SEO标题\分享文案
        $star = floatval($data['star']);
        if ($star) $seo_title_ext[] = $star.'分';
        if ($data['status']==4 && $data['num_yuyue']) {
            $seo_title_ext[] = $num_yuyue.'预约';
        } elseif ($data['status']==1 && $data['num_down']) {
            $seo_title_ext[] = $num_down.'人在玩';
        }
        if (count($seo_title_ext)>=2) {
            $seo_title_ext = $seo_title_ext ? '('.implode('，',$seo_title_ext).')' : '';
        } else {
            $seo_title_ext = '';
        }
        $share_title = $data['title'].$seo_title_ext.'_好游快爆app_分享新鲜好玩游戏';
        $share_desc = $data['title'].',';
        if ($data['editor_recommend']) {
            $share_desc .= $data['editor_recommend'];
            $fh_str = mb_substr($share_desc, -1, 1, 'UTF-8');
            if (!($fh_str == '!' || $fh_str == '.'  || $fh_str == ','  || $fh_str == '！' || $fh_str == '。' || $fh_str == '，')){
                $share_desc .= ',';
            }
        }
        $share_desc = $share_desc.'赶快来好游快爆app，发现好游戏！';
        //游戏定制seo
		$seo_sql="select * from cpp_hykbwap_seogame where gameid=".$id;;
		$seogame=$db->get_one($seo_sql);
        // 底部友链
        $gamelinks = $this->getGameLink($id);

        /**
         * 熊掌号 发布时间与更新时间
         * 发布时间:若未生成则为当前时间
         */

        $gameurl = Comm::getGamePushUrl($id);
        $gamepath = $_sc_root.str_replace('https://m.3839.com','',$gameurl);
        $pubDate = $upDate = 0;
        
        $tmp = $db->get_one("SELECT * FROM ".C::$table_game_push." WHERE gameid='{$id}' ");
        if ($tmp['addtime']) {
            $pubDate = $tmp['addtime'];
            if (is_file($gamepath)) {
                $upDate = filemtime($gamepath);
            }
            if ($upDate < $pubDate) $upDate = $pubDate;
        } else {
            // 未生成过(发布时间与更新时间为当前时间)
            $pubDate = $upDate = time();
        }
        ob_start();
		include TPL_PATH.'/game_detail.php';
        $html = ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        echo $html;
        die('');
    }
	
	//sem页面游戏详情页
    function semgameAction() {
        global $db,$_sc_base_url,$_sc_root;
        $id = intval($_REQUEST['id']);
        if ($id<=0) {
            die('参数错误');
        }

        $data = Comm::getGameData($id);

        if (!$data) {
            die('详情接口获取失败');
        }
        
        if ($data['show_url']==1) {
            // 不展示PC/wap页面
            die('show_url:不展示PC/wap页面'); // 提示信息show_url:...，不可更改，生成时调用到，更新数据表的生成状态
        }

        // 图片及视频地址替换
        $video_img = $video_link = '';
        if ($data['videoinfo']['icon']) {
            $video_img = Comm::reLink(Comm::replaceImg($data['videoinfo']['icon']));
            $video_link = Comm::reLink($data['videoinfo']['vlink']);
        }


        //预约人数、下载人数
        if ($data['num_yuyue']) {
            preg_match('/\d+(\.\d+)?(万)?/',$data['num_yuyue'],$match);
            $num_yuyue = $match[0];
        }

        if ($data['num_down']) {
            preg_match('/\d+(\.\d+)?(万)?/',$data['num_down'],$match);
            $num_down = $match[0];
        }

        // 下载信息
        $downInfo = array(
            "kb_id" => $data['downinfo']['id'],
            "apkurl" => $data['downinfo']['apkurl'],
            "package" => $data['downinfo']['packag'],
            "appname" => $data['downinfo']['appname'],
            "icon" => Comm::reLink(Comm::replaceImg($data['downinfo']['icon'])),
            "md5" => $data['downinfo']['md5'],
        );

        // 二维码
        $ewm = '//newsimg.5054399.com/uploads/allimg/171010/397_1047102004.jpg';

        // SEO标题\分享文案
        $star = floatval($data['star']);
        if ($star) $seo_title_ext[] = $star.'分';
        if ($data['status']==4 && $data['num_yuyue']) {
            $seo_title_ext[] = $num_yuyue.'预约';
        } elseif ($data['status']==1 && $data['num_down']) {
            $seo_title_ext[] = $num_down.'人在玩';
        }
        if (count($seo_title_ext)>=2) {
            $seo_title_ext = $seo_title_ext ? '('.implode('，',$seo_title_ext).')' : '';
        } else {
            $seo_title_ext = '';
        }

        $share_title = $data['title'].$seo_title_ext.'_好游快爆app_分享新鲜好玩游戏';
        $share_desc = $data['title'].',';
        if ($data['editor_recommend']) {
            $share_desc .= $data['editor_recommend'];
            $fh_str = mb_substr($share_desc, -1, 1, 'UTF-8');
            if (!($fh_str == '!' || $fh_str == '.'  || $fh_str == ','  || $fh_str == '！' || $fh_str == '。' || $fh_str == '，')){
                $share_desc .= ',';
            }
        }
        $share_desc = $share_desc.'赶快来好游快爆app，发现好游戏！';
        //游戏定制seo
		$seo_sql="select * from cpp_hykbwap_seogame where gameid=".$id;;
		$seogame=$db->get_one($seo_sql);
        // 底部友链
        $gamelinks = $this->getGameLink($id);
      
        /**
         * 熊掌号 发布时间与更新时间
         * 发布时间:若未生成则为当前时间
         */
        $gameurl = Comm::getGamePushUrl($id);
        $gamepath = $_sc_root.str_replace('https://m.3839.com','',$gameurl);
        $pubDate = $upDate = 0;
		 //专区地址
		 $topic_id=$data['topicinfo']['id'];
         $modid=$topic_id%1000;
		 $zurl='https://m.3839.com/zhuanqu/'.$modid.'/'.$topic_id.'.htm';
        
        $tmp = $db->get_one("SELECT * FROM ".C::$table_game_push." WHERE gameid='{$id}' ");
        if ($tmp['addtime']) {
            $pubDate = $tmp['addtime'];
            if (is_file($gamepath)) {
                $upDate = filemtime($gamepath);
            }
            if ($upDate < $pubDate) $upDate = $pubDate;
        } else {
            // 未生成过(发布时间与更新时间为当前时间)
            $pubDate = $upDate = time();
        }
        ob_start();
		include TPL_PATH.'/sem_game_detail.php';
        $html = ob_get_contents();
        ob_clean();
        $html = Comm::reHtml($html);
        echo $html;
        die('');
    }	

	function sendsmsAction(){
	  header("Access-Control-Allow-Origin: *");
	  global $db;
	  $mobile=$_REQUEST['mobile'];
	  if(empty($mobile)){ echo json_encode(array("code"=>'error',"msg"=>'请输入手机号码'));die();}
	  if(!preg_match('/^1[34578]\d{9}$/',$mobile)){echo json_encode(array("code"=>'error',"msg"=>'您输入的手机号码格式不正确'));die();}
	  $day=date("Ymd");
	  $sq="select count(*) as num from cpp_gst_sms_log where phone=$mobile and day=$day";
	  $row=$db->get_one($sq);
	  if($row['num']>=5){
	   echo json_encode(array("code"=>'error',"msg"=>'每天最多只能发送5次短信'));die();
	  }
	  $check_code=rand(100000,999999); 
	  $rkey=md5($check_code.'hykb_yuyue4399'.$mobile);
	  $msg=$check_code.'快爆验证码，15分钟内有效，仅用于预约游戏，请勿告知他人。';
	  $msg=iconv("utf-8","gbk",$msg);
	  //setcookie('hykb_yuyue_code',$check_code.'|'.$rkey,time()+900,'/');
	  $expire=time()+900;
	  $sq="insert into cpp_wap_yy_yzm(yzm,rkey,expire) value($check_code,'$rkey',$expire)";
	  $db->query($sq); 
	  $api="https://m.3839.com/app/hykb_web_wap/api/api_gst_sms.php?sign=hykb&phone={$mobile}&msg={$msg}&from=hykb_yuyue";
	  $result=Comm::curl_get($api,1800);
	  echo $result;
	}
	
	function yygameAction(){
	  header("Access-Control-Allow-Origin: *");
	  global $db;
	  $mobile=$_REQUEST['mobile'];
	  $game_id=(int) $_REQUEST['game_id'];
	  $yzm=(int) $_REQUEST['yzm'];
	  $sq="select * from cpp_wap_yy_yzm where yzm=".$yzm;
	  $yinfo=$db->get_one($sq);
	  //list($check_code,$rkey)=explode("|",$_COOKIE['hykb_yuyue_code']);
	  if(empty($yzm)){echo json_encode(array("code"=>'error',"msg"=>'请输入验证码'));die();}
	  if(empty($yinfo)){echo json_encode(array("code"=>'error',"msg"=>'验证码有误'));die();}
	  if($yinfo['expire']<time()){echo json_encode(array("code"=>'error',"msg"=>'验证码有误'));die();}
	  if($yinfo['rkey']!=md5($yzm.'hykb_yuyue4399'.$mobile)){
	   echo json_encode(array("code"=>'error',"msg"=>'验证码有误'));die();
	  }
	  if($yinfo['yzm']!=$yzm){echo json_encode(array("code"=>'error',"msg"=>'验证码有误'));die();}
	  if(empty($mobile)){echo json_encode(array("code"=>'error',"msg"=>'请输入手机号码'));die();}
	  if(!preg_match('/^1[34578]\d{9}$/',$mobile)){echo json_encode(array("code"=>'error',"msg"=>'您输入的手机号码格式不正确'));die();}
	  $day=date("Ymd");
	  $ynum_key='ynum_v1'.date("Ymd");
      $ynum=(int) $_COOKIE[$ynum_key];
	  if($ynum>=3){echo json_encode(array("code"=>'error1',"msg"=>'今日预约次数过多'.$ynum));die();}
	  $sq="select count(*) as num from cpp_wap_yy_log where phone=$mobile and day=$day";
	  $row=$db->get_one($sq);
	  if($row['num']>=3){ echo json_encode(array("code"=>'error1',"msg"=>'今日预约次数过多'));die();}	 
	  $time=time();
	  $version=140;
	  $secret = 'db5c84fc498f0c7ff5d2f2d3544f4fcd';
      $token = md5( '#' . $version . '&' . $secret . '*' . $time . '|' );
	  $api="http://newsapp.5054399.com/kuaibao/android/apihd2.php?a=appointment&c=forhuodong&version=140&gid={$game_id}&phone_num={$mobile}&ts={$time}&token={$token}";
	  $result=Comm::curl_get($api);
	  $arr=json_decode($result,true);
	  if($arr['code']==100){
	    $ynum=$ynum+1;
		$day=date("Ymd");
		setcookie($ynum_key,$ynum,time()+24*3600,'/');
		$isql="insert into cpp_wap_yy_log(phone,day,game_id) values ($mobile,$day,$game_id)";
		$db->query($isql);
	  }	  
      echo $result;
	}
	//通过ip查询地址
	/****
	function iplocationAction(){
	  header("Access-Control-Allow-Origin: *");
	  include 'api/IP138.php';
	  $ip=Comm::get_online_ip();
	  $location = IP138::find($ip);
	  $zcity=$location[1];
	  if($zcity=='北京' || $zcity=='上海' || $zcity=='天津' || $zcity=='重庆'){
	   $city=$zcity;
	  }else{
      $city=$location[2];
	  }
	  $setfile=APP_PATH.'/setsem.txt';
	  $arr=unserialize(file_get_contents($setfile));
	  if(in_array($city,$arr['city'])){
	   $arr=array(
	    'show_nor_down_win'=>$arr['show']['showwin'],
		'show_nor_down'=>$arr['show']['showbtn'],
		'ybtn_style'=>$arr['show']['showyz'],
		'ycontent'=>htmlspecialchars_decode($arr['show']['ycontent'])
	   );
	  }else{
	   	$arr=array(
	    'show_nor_down_win'=>$arr['show']['showwin1'],
		'show_nor_down'=>$arr['show']['showbtn1'],
		'ybtn_style'=>$arr['show']['showyz1'],
		'ycontent'=>htmlspecialchars_decode($arr['show']['ycontent'])
	   );
	  }
	  echo json_encode($arr);
	  exit();
	}	
	*/
	function iplocationAction(){
	  header("Access-Control-Allow-Origin: *");
	  $setfile=APP_PATH.'/setsem.txt';
	  $arr=unserialize(file_get_contents($setfile));
	   $arr=array(
	    'show_nor_down_win'=>$arr['show']['showwin'],
		'show_nor_down'=>$arr['show']['showbtn'],
		'ybtn_style'=>$arr['show']['showyz'],
		'ycontent'=>htmlspecialchars_decode($arr['show']['ycontent'])
	   );
	  echo json_encode($arr);
	  exit();
	}
}