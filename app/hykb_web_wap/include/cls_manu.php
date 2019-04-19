<?php
defined('APP_PATH') or exit('Access Denied');
/**
 * 开发者详情页
 */
class manu extends Controller {

   public function detailAction(){
	  $uid=(int) $_REQUEST['uid'];
    //按时间
		$api_timesort_game=C::$api_timesort_game;
    //按下载量
		$api_downsort_game=C::$api_downsort_game;
    //按评分
		$api_scoresort_game=C::$api_scoresort_game;

		$new_sort=array();
		$score_sort=array();
		$down_sort=array();
		$n1=0;
		$n2=0;
		$n3=0;
    for($kn=1;$kn<=100;$kn++){
      //时间排序数据
		  $timeapi=str_replace('{uid}',$uid,$api_timesort_game);
		  $timeapi=str_replace('{p}',$kn,$timeapi);
		   $return_time=Comm::curl_get($timeapi,12);
		   if(!$return_time){die("获取开发者游戏列表接口失败");}
		   $return_time=json_decode($return_time,true);
		   if($return_time['code']!=100 || empty($return_time['result'])){
			      die("获取开发者游戏列表详情失败");
		   }
		   $list_time=$return_time['result']['data']['list'];
		   if(empty($list_time)){break;}
		   foreach($list_time as $k=>$v){
		    $new_sort[$n1]=$v;

			$n1++;
		   }
       // 评分排序
		  $scoreapi=str_replace('{uid}',$uid,$api_scoresort_game);
		  $scoreapi=str_replace('{p}',$kn,$scoreapi);
		   $return_score=Comm::curl_get($scoreapi,12);
		   if(!$return_score){die("获取开发者游戏列表接口失败");}
		   $return_score=json_decode($return_score,true);
		   if($return_score['code']!=100 || empty($return_score['result'])){
			      die("获取开发者游戏列表详情失败");
		   }
		   $list_score=$return_score['result']['data']['list'];
		   if(empty($list_score)){break;}
		   foreach($list_score as $k=>$v){
		    $score_sort[$n2]=$v;

			$n2++;
		   }
       // 下载排序
		  $downapi=str_replace('{uid}',$uid,$api_downsort_game);
		  $downapi=str_replace('{p}',$kn,$downapi);
		   $return_down=Comm::curl_get($downapi,12);
		   if(!$return_down){die("获取开发者游戏列表接口失败");}
		   $return_down=json_decode($return_down,true);
		   if($return_down['code']!=100 || empty($return_down['result'])){
			      die("获取开发者游戏列表详情失败");
		   }
		   $list_down=$return_down['result']['data']['list'];
		   if(empty($list_down)){break;}
		   foreach($list_down as $k=>$v){
		    $down_sort[$n3]=$v;

			$n3++;
		   }
		}

		//获取开发者基本信息
		 $other_info=Comm::get_kiother($uid);
		 ob_start();
         include TPL_PATH.'/manu_detail.php';
		 $html=ob_get_contents();
		 ob_clean();
		 $html = Comm::reHtml($html);
		 echo $html;
		 die('');
   }



}
