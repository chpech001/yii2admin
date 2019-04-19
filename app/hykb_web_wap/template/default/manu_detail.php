<?php defined('APP_PATH') or die('Access Denied');?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?=$other_info['nickname']?>游戏下载_<?=$other_info['nickname']?>手游排行榜-好游快爆app</title>
  <meta name="keywords" content="<?=$other_info['nickname']?>,<?=$other_info['nickname']?>游戏下载,<?=$other_info['nickname']?>手游排行榜">
  <meta name="description" content="好游快爆<?=$other_info['nickname']?>专区为您提供<?=$other_info['nickname']?>有什么游戏、<?=$other_info['nickname']?>手游排行榜、<?=$other_info['nickname']?>游戏下载。好游快爆，游戏爱好者自己的APP，致力于好玩的手机游戏分享。">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="format-detection" content="telephone=no">
  <meta name="full-screen" content="yes" />
  <meta name="x5-fullscreen" content="true" />
  <link rel="canonical" href="//www.3839.com/cp/<?=$other_info['uid']?>.html">
  <script src="//newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
  <link href="<?=C::$cdn_path?>cs_detail_static/css/style.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">

  <script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
  <script src="<?=C::$cdn_path?>cs_detail_static/js/zepto.min.js"></script>
</head>
<body>
  <script>
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https'){
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else{
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
<div class="rkwrap">

<!-- <div class="headArea">
    <a href="#">
        <span class="applogo" href="#">好游快爆</span>
        <span class="downtip" href="#">下载好游快爆</span>
    </a>
    <a class="link-sch" href="//m.3839.com/search/">搜索</a>
</div> -->
<?php include 'common/header.php';?>

<?php $top_manu_url=Comm::get_url('top','manu',array('view_ishtml'=>1));?>
<ul class="breadcrumb">
    <li><a href="<?=$GLOBALS['_index_url']?>">首页</a></li>
    <li><a href="<?=$top_manu_url?>">厂商</a></li>
    <li><span class="bbsname"><?=$other_info['nickname']?></span></li>
</ul>

<div class="makerHead">
    <img src="<?php echo $other_info['bgimg']?$other_info['bgimg']: C::$cdn_path.'cs_detail_static/images/maker.jpg'; ?>" alt="">
</div>

<div class="makerInfo">
    <img class="img" src="<?=$other_info['avatar']?>" alt="<?=$other_info['nickname']?>">
    <div class="cf">
        <a class="feed" href="#" onClick="pop('kfz');return false;">关注TA</a>
    </div>
    <div class="con">
        <div class="name">
            <em><?=$other_info['nickname']?></em>
            <span class="ident">开发者</span>
            <?php if ($other_info['votemark']){ ?>
              <span class="lvl"><i><?=$other_info['votemark']?></i>口碑</span>
            <?php } ?>
        </div>
        <?php if ($other_info['identity_info']) {?>
          <p class="desc"><em>官方认证：</em><?=$other_info['identity_info']?></p>
        <?php }?>
        <?php if ($other_info['follow_num']>0 || $other_info['fans_num']>0) {?>
          <div class="info">
          <span><i><?=$other_info['follow_num']?></i>关注</span>
          <span><i><?=$other_info['fans_num']?></i>粉丝</span>
          <span><i><?php
            if ($other_info['visit_num']>=100000) {
              $visit_num = round($other_info['visit_num']/10000,0) .'万';
            }elseif ($other_info['visit_num']>=10000) {
              $visit_num = round($other_info['visit_num']/10000,1) .'万';
            }else {
              $visit_num = $other_info['visit_num'];
            }?><?=$visit_num?></i>访客总量</span>
          </div>
        <?php }?>
    </div>
</div>


<div class="makerSort">
    <div class="rkSort">
        <?php if($other_info['game_num']==0){?>
          <em>该开发者还没有游戏</em>
          <?php }else{?>
            <em>旗下游戏（<?=$other_info['game_num']?>）</em>
            <div class="rk-sort">
              <span class="">最新更新</span>
              <ul id="tab">
                <li class="on">最新更新</li>
                <li>下载次数</li>
                <li>游戏评分</li>
              </ul>
            </div>
          <?php }?>
    </div>
</div>


<div class="rankcon">
    <ol id="list">
        <?php
       foreach($new_sort as $k=>$v){
         $url=Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
         $tags=$v['tags'];
         $tagstr='';
       for($kz=0;$kz<3;$kz++){
         $ta=$tags[$kz]['title'];
         if(!empty($ta)){$tagstr.='<span>'.$ta.'</span>';}
         }
       if($k<20){
         $lzimg=' lzimg="1" lz_src';$show='';
       }else{
         $lzimg=' lz_src';$show='none';
       }
       $gameinfo=Comm::getGameData($v['id']);
        $status=(int) $v['downinfo']['status'];
         if($status==1){$button='<a href="'.$url.'" class="btn">下载</a>';}
         if($status==2){$button='<a href="'.$url.'" class="btn">敬请期待</a>';}
         if($status==3 || $status==5 || $status==6){$button='<a href="'.$url.'" class="btn">查看详情</a>';}
         if($status==4){$button='<a href="'.$url.'" class="btn yellow">预约</a>';}
       $game_des=$gameinfo['editor_recommend'];
    ?>
    <li style="display:<?=$show?>">
        <a class="gameli" href="<?=$url?>">
            <div class="img"><img <?=$lzimg?>="<?=$v['icon']?>" alt="<?=$v['title']?>下载"></div>
            <div class="con">
                <em class="name"><?=$v['title']?></em>
                <p class="deta">
                    <?=$tagstr?>
                </p>
                <p class="info">

                    <?php if(!empty($v['score'])){?>
                      <span class="spec"><?=$v['score']?>分</span>
                    <?php }?>
                    <?php if(!empty($v['size']) && $status!=3 && $status!=5 && $status!=6){?>
                              <span><?=$v['size']?></span>
                    <?php }?>
                    <?php if(!empty($v['down_num']) && $status!=3 && $status!=5 && $status!=6){?>
                              <span><?=$v['down_num']?></span>
                    <?php }?>
                </p>
            </div>
        </a>
        <?=$button?>
    </li>
   <?php unset($status);unset($button);unset($tagstr);}?>
    </ol>
    <ol id="downlist" style="display:none;">
        <?php
       foreach($down_sort as $k=>$v){
         $url=Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
         $tags=$v['tags'];
         $tagstr='';
       for($kz=0;$kz<3;$kz++){
         $ta=$tags[$kz]['title'];
         if(!empty($ta)){$tagstr.='<span>'.$ta.'</span>';}
         }
       if($k<20){
         $lzimg=' lzimg="1" lz_src';$show='';
       }else{
         $lzimg=' lz_src';$show='none';
       }
       $gameinfo=Comm::getGameData($v['id']);
        $status=(int) $v['downinfo']['status'];
         if($status==1){$button='<a href="'.$url.'" class="btn">下载</a>';}
         if($status==2){$button='<a href="'.$url.'" class="btn">敬请期待</a>';}
         if($status==3 || $status==5 || $status==6){$button='<a href="'.$url.'" class="btn">查看详情</a>';}
         if($status==4){$button='<a href="'.$url.'" class="btn yellow">预约</a>';}
       $game_des=$gameinfo['editor_recommend'];
    ?>
    <li style="display:<?=$show?>">
        <a class="gameli" href="<?=$url?>">
            <div class="img"><img <?=$lzimg?>="<?=$v['icon']?>" alt="<?=$v['title']?>下载"></div>
            <div class="con">
                <em class="name"><?=$v['title']?></em>
                <p class="deta">
                    <?=$tagstr?>
                </p>
                <p class="info">

                    <?php if(!empty($v['score'])){?>
                      <span class="spec"><?=$v['score']?>分</span>
                    <?php }?>
                    <?php if(!empty($v['size']) && $status!=3 && $status!=5 && $status!=6){?>
                              <span><?=$v['size']?></span>
                    <?php }?>
                    <?php if(!empty($v['down_num']) && $status!=3 && $status!=5 && $status!=6){?>
                              <span><?=$v['down_num']?></span>
                    <?php }?>
                </p>
            </div>
        </a>
        <?=$button?>
    </li>
   <?php unset($status);unset($button);unset($tagstr);}?>
    </ol>
    <ol id="scorelist" style="display:none;">
        <?php
       foreach($score_sort as $k=>$v){
         $url=Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
         $tags=$v['tags'];
         $tagstr='';
       for($kz=0;$kz<3;$kz++){
         $ta=$tags[$kz]['title'];
         if(!empty($ta)){$tagstr.='<span>'.$ta.'</span>';}
         }
       if($k<20){
         $lzimg=' lzimg="1" lz_src';$show='';
       }else{
         $lzimg=' lz_src';$show='none';
       }
       $gameinfo=Comm::getGameData($v['id']);
        $status=(int) $v['downinfo']['status'];
         if($status==1){$button='<a href="'.$url.'" class="btn">下载</a>';}
         if($status==2){$button='<a href="'.$url.'" class="btn">敬请期待</a>';}
         if($status==3 || $status==5 || $status==6){$button='<a href="'.$url.'" class="btn">查看详情</a>';}
         if($status==4){$button='<a href="'.$url.'" class="btn yellow">预约</a>';}
       $game_des=$gameinfo['editor_recommend'];
    ?>
    <li style="display:<?=$show?>">
        <a class="gameli" href="<?=$url?>">
            <div class="img"><img <?=$lzimg?>="<?=$v['icon']?>" alt="<?=$v['title']?>下载"></div>
            <div class="con">
                <em class="name"><?=$v['title']?></em>
                <p class="deta">
                    <?=$tagstr?>
                </p>
                <p class="info">

                    <?php if(!empty($v['score'])){?>
                      <span class="spec"><?=$v['score']?>分</span>
                    <?php }?>
                    <?php if(!empty($v['size']) && $status!=3 && $status!=5 && $status!=6){?>
                              <span><?=$v['size']?></span>
                    <?php }?>
                    <?php if(!empty($v['down_num']) && $status!=3 && $status!=5 && $status!=6){?>
                              <span><?=$v['down_num']?></span>
                    <?php }?>
                </p>
            </div>
        </a>
        <?=$button?>
    </li>
   <?php unset($status);unset($button);unset($tagstr);}?>
    </ol>
</div>
<div id="more"></div>
<!-- loading -->
<?php if (count($new_sort)>=20) {?>
  <div id="1">
  <div class="loadtips" id="listload">
  <span class="ico"></span><span>正在加载中...</span>
  </div>
  </div>
  <div id="2" style="display:none;">
  <div class="loadtips" id="downlistload">
  <span class="ico"></span><span>正在加载中...</span>
  </div>
  </div>
  <div id="3" style="display:none;">
  <div class="loadtips" id="scorelistload">
  <span class="ico"></span><span>正在加载中...</span>
  </div>
  </div>
<?php }?>

</div>
<script type="text/javascript" src="//newsimg.5054399.com/hykb/wap/js/footer_wapinner.js"></script>

<div class="downArea fixed-bottom" id="bomDownDiv">
    <span class="btn-hide" onclick="$(this).parent().hide()">关闭</span>
    <a href="<?=$GLOBALS['_index_gw']?>"><img class="img" src="<?=C::$cdn_path?>images/applogo.png" alt="好游快爆官网"></a>
    <div class="con">
        <a href="<?=$GLOBALS['_index_gw']?>">
            <em>好游快爆 - 分享好游戏</em>
            <span>一个分享精品游戏的APP</span>
        </a>
    </div>
    <script type="text/javascript">
        if (is_ios) {
            document.write('<a class="btn-down" onclick="pop2(\'pop_ios\')">马上下载</a>')
        } else {
            document.write('<a class="btn-down" href="//d.4399.cn/Q7" rel="external nofollow">马上下载</a>');
        }
    </script>
</div>

<script language="javascript">
$(function(){
  $(window).scroll(function(){
      var scrollTop1 = getScrollTop();
      // 顶部浮动
      if (scrollTop1>=$('#headwp').offset().top) {
          $('#headwp>div.headArea').addClass('fixed');
      } else {
          $('#headwp>div.headArea').removeClass('fixed');
      }
  });
});
// 切换排序
$(".rk-sort").click(function(event) {
  $(this).find('ul').toggle();
});
$(".rk-sort ul li").click(function(event) {
  $("#tab li").each(function(){
	   $(this).removeClass('on');
  })
  $(".rk-sort span").text($(this).text());
  $(this).toggleClass('on');
  $(this).find('ul').toggle();
  var tab = $(this).index();
  $(".rankcon ol").each(function(){
		$(this).css('display','none');
	})
	for($i=1;$i<=3;$i++){
		$("#"+$i).hide();
	}
  if(tab==1){
  	$("#downlist").css('display','block');
  	$("#2").toggle();
  }else if(tab==2){
  	$("#scorelist").css('display','block');
  	$("#3").toggle();
  }else if(tab==0){
  	$("#list").css('display','block');
  	$("#1").toggle();
  }
});
 var np=1;
 var allp=<?php echo ceil($n1/20);?>;
 var cnt=<?=$n1?>;
 console.log(cnt);
 function showmore(){
  np=np+1;
  if(np>=allp){ np=allp; $(".btn-bar").css("display","none");}
  var s1=(np-1)*20;
  var e1=s1+20;
  if(e1>=cnt){e1=cnt;}
  for(var k=s1;k<e1;k++){
    $(".collection-list li").eq(k).css("display","").find("img[lz_src]").attr("src",function(){
	   var src=$(this).attr("lz_src");
	   $(this).removeAttr("lz_src");
	   return src;
	});
  }
 }
 function show_download_pop(){
  zdialog.show($('#dtc'), '', $('#dtc').find('.close'));
 }
 // 加载更多
 var tab_id = false;
 var loadding = false;
  function loadMore() {
  			$("#tab li").each(function(){
  				var tab_on = $(this).attr('class');
  				if(tab_on=='on'){
      if(!tab_id && !loadding) {
          loadding = true;
 					var tab_name = $(this).text();
  					if(tab_name=='最新更新'){
  						var tab_id = 'list';
  					}else if(tab_name=='下载次数'){
  						var tab_id = 'downlist';
  					}else if(tab_name=='游戏评分'){
  						var tab_id = 'scorelist';
  					}
          setTimeout(function(){
  					$('#'+tab_id).children('li').filter(':hidden').slice(0,20).show().find('img[lz_src]').attr('src',function(){return $(this).attr('lz_src')}).removeAttr('lz_src');

  					if ($('#'+tab_id).children('li').filter(':hidden').length==0) {
  						$('#'+tab_id+'load').hide();
  						tab_id = true;
  					}
  					loadding=false
  					return false;
          },1000)
      }
  				}
  			})
  }
// $(window).scroll(function () {
//   if ($(window).scrollTop() > $(document).height() - ($(window).height() + 100)) {
//   loadMore();
//   }
// });
$(window).scroll(function () {
  // 获得div的高度
  var h = $("#more").offset().top;
  if($(window).scrollTop()+$(window).height()>h){
  // 滚动到指定位置
  loadMore();
  }
});
popData['kfz'] = '<div class="pop" style="display:block"><a class="pclose">关闭</a>'
	+ '    <div class="ptit">下载好游快爆，和开发者面对面</div>'
	+ '    <div class="pcon">'
	+ '        <p class="pf24 grey tac">了解开发者最新动态，新游资讯抢先知道<br>和开发者近距离互动，随时随地提出建议</p>'
	+ '    </div>'
	+ '    <div class="pbtn">'
	+ '        ' + (is_ios ? '<a onclick="pop(\'ios\')" rel="external nofollow">马上下载</a>' : '<a href="//d.4399.cn/Q7">马上下载</a>')
	+ '    </div>'
	+ '</div>';

</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
<script src="<?=C::$cdn_path?>cs_detail_static/js/fastclick.js"></script>
</body>
</html>
