<?php defined('APP_PATH') or die('Access denied');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<?php if($type=='hot'){?>
<title>好游快爆人气榜_2019手游排行榜-好游快爆app</title>
<meta name="keywords" content="2019手游排行榜,热门手游推荐,好游快爆人气榜">
<meta name="description" content="好游快爆人气榜为您展示当下玩家中人气最高的手游，了解你身边人都在玩什么，关注人气榜就能掌握热门手游市场。">
<link rel="canonical" href="https://www.3839.com/top/hot.html">
<?php }?>
<?php if($type=='sugar'){?>
<title>好游快爆飙升榜_热门手游排行榜-好游快爆app</title>
<meta name="keywords" content="热门手游排行榜,热门手游下载,好游快爆飙升榜">
<meta name="description" content="好游快爆飙升榜为您展示近期下载量飙升的新品手游，发现更多新品和高质量游戏，关注飙升榜就能先人一步发现好游戏。">
<link rel="canonical" href="https://www.3839.com/top/sugar.html">
<?php }?>
<?php if($type=='expect'){?>
<title>好游快爆期待榜_2019新游排行榜-好游快爆app</title>
<meta name="keywords" content="2019新游排行榜,2019新游,新游人气排行榜">
<meta name="description" content="好游快爆期待榜为您展示时下最受期待新游，了解大家都在关注的新游戏，关注期待榜就能掌握最权威的新游信息，好的游戏值得期待。">
<link rel="canonical" href="https://www.3839.com/top/expect.html">
<?php }?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="full-screen" content="yes" />
<meta name="x5-fullscreen" content="true" />
<link href="<?=C::$cdn_path?>v2/css/style.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
<script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
<script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
</head>
<body>
<div class="rkwrap">
<div class="downArea" id="downArea">
    <span class="btn-hide" onClick="$(this).parent().hide()">关闭</span>
    <a href="<?=$GLOBALS['_index_gw']?>"><img class="img" src="<?=C::$cdn_path?>images/applogo.png" alt="好游快爆官网"></a>
    <div class="con">
        <a href="<?=$GLOBALS['_index_gw']?>">
        <em>好游快爆 - 分享好游戏</em>
        <span>一个分享精品游戏的APP</span>
        </a>
    </div>
    <script type="text/javascript">
    if (is_ios) {
        document.write('<a class="btn-down" onclick="pop2(\'pop_ios\')">马上下载</a>');
    } else {
        document.write('<a class="btn-down" href="//d.4399.cn/Q7" rel="external nofollow">马上下载</a>');
    }
    </script>
</div>
<?php include 'common/header.php';?>
<ul class="rkMenu cf">
    <li class="<?php if($type=='hot'){echo 'on';}?>"><a href="<?php echo Comm::get_url('top','hot',array('view_ishtml'=>1));?>"  target="_self">人气榜</a></li>
    <li class="<?php if($type=='sugar'){echo 'on';}?>"><a href="<?php echo Comm::get_url('top','sugar',array('view_ishtml'=>1));?>" target="_self">飙升榜</a></li>
    <li class="<?php if($type=='expect'){echo 'on';}?>"><a href="<?php echo Comm::get_url('top','expect',array('view_ishtml'=>1));?>" target="_self">期待榜</a></li>
	<li class="<?php if($type=='player'){echo 'on';}?>"><a href="<?php echo Comm::get_url('top','player',array('view_ishtml'=>1));?>" target="_self">玩家榜</a></li>
    <li class="<?php if($type=='manu'){echo 'on';}?>"><a href="<?php echo Comm::get_url('top','manu',array('view_ishtml'=>1));?>" target="_self">开发者</a></li>
</ul>
<?php if($type=='hot'){?>
<div class="rkDesc rkit1">
    <div class="con"><p>展示当下玩家中人气最高的手游，了解你身边人都在玩什么，关注人气榜就能掌握热门手游市场。</p></div>
</div><?php }?>
<?php if($type=='sugar'){?>
<div class="rkDesc rkit3">
    <div class="con">
        <p>展示近期下载量飙升的新品手游，发现更多新品和高质量游戏，关注飙升榜就能先人一步发现好游戏。</p>
    </div>
</div>
<?php }?>
<?php if($type=='expect'){?>
<div class="rkDesc rkit2">
    <div class="con">
        <p>展示时下最受期待新游，了解大家都在关注的新游戏，关注期待榜就能掌握最权威的新游信息，好的游戏值得期待。</p>
    </div>
</div>
<?php }?>
<div class="rankcon">
    <ol>
	      <?php
			  $list=$return['result']['data'];
			  foreach($list as $k=>$v){
			  $url=Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
			  $tags=$v['tags'];
			  $kz=$k+1;
              $emcls='<i class="num">'.$kz.'</i>';
			  if($kz<=20){
			    $show='';
				$lz=' lzimg="1" lz_src ';
			   }else{
			    $show='none';
				$lz=' lz_src ';
			   }
			?>	
        <li style="display:<?=$show?>">
		    <?=$emcls?>
            <a class="gameli" href="<?=$url?>">
                <div class="img"><img <?=$lz?>="<?=$v['icon']?>" alt="<?=$v['title']?>下载"></div>                
                <div class="con">
                    <em class="name"><?=$v['title']?></em>
                    <p class="deta"><?php 
					    foreach($tags as $k1=>$v1){
						  if($k1<3){
						?><span><?=$v1['title']?></span><?php }}?>
                    </p>
                    <p class="info">
					   <?php if(!empty($v['score'])){?>
                        <span class="spec"><?=$v['score']?>分</span>
						<?php }?>
						<?php if(!empty($v['downinfo']['size_m'])){?>
                        <span><?=$v['downinfo']['size_m']?></span>
						<?php }?>
						<?php if(!empty($v['num_down'])){?>
                        <span><?=$v['num_down']?></span>
						<?php }?>
                    </p>
                </div>
            </a>
			<?php if($v['downinfo']['status']==1){?><a class="btn green" href="<?=$url?>">下载</a><?php }?>
			<?php if($v['downinfo']['status']==4){?><a class="btn yellow" href="<?=$url?>">预约</a><?php }?>
			<?php if($v['downinfo']['status']==6){?><a class="btn green" href="<?=$url?>">查看详情</a><?php }?>
			<?php if($v['downinfo']['status']==3 || $v1['status']==5){?><a class="btn green" href="<?=$url?>">查看详情</a><?php }?>
        </li>
		<?php }?>
    </ol>
</div>
<div class="loadtips" style="display:none">
    <span class="ico"></span><span>正在加载中...</span>
</div>
<a id="gotop" class="gotop" style="display:none" onClick="go_to($('body'))">返回顶部</a>
<div class="friLink">
    <dt>友情链接</dt>
	<?php 
	if ($toplinks) {
	foreach($toplinks as $k=>$v) {
	echo '<dd><a href="'.$v['url'].'">'.$v['title'].'</a></dd>';
	}
	}
	?>
</div>
<div class="footCopy" id="footer">
<script type="text/javascript" src="//newsimg.5054399.com/hykb/wap/js/footer_wap.js"></script>
</div>
</div>
<div class="navFootWp">
    <div class="navFoot">    
        <ul class="cf">
		    <?php
			  $home_url=Comm::get_url('home','',array('view_ishtml'=>1));
			  $pai_url=Comm::get_url('top','top',array('type'=>'hot','view_ishtml'=>1));
			  $cat_url=Comm::get_url('category','',array('view_ishtml'=>1));
			  $xq_url=Comm::get_url('newness','',array('view_ishtml'=>1));
			?>
            <li><a href="<?=$home_url?>"><i class="reco"></i>游戏推荐</a> </li>
            <li class="on"><a><i class="rank"></i>排行榜</a></li>
            <li><a href="<?=$xq_url?>"><i class="spec"></i>新奇</a></li>
            <li><a href="https://m.bbs.3839.com/"><i class="bbs"></i>论坛</a></li>
        </ul>
    </div>
 </div>
 <script language="javascript">
 <?php $tpage=ceil($kz/20);?>	
     var p=1;
	 var cscroll=1;
	 var tpage=<?=$tpage?>;
	 var tnum=<?=$kz?>;
	 if(tpage>1){
		 $(window).scroll(function(){
				var scrollTop = $(this).scrollTop();var scrollHeight = $(document).height();var windowHeight = $(this).height();
				if(scrollTop + windowHeight > scrollHeight-300){
					 if(cscroll==1){
						 cscroll=0;
						  var s=p*20;
						  var e=s+20;
						  if(e>=tnum){e=tnum;}
						  $(".loadtips").show();
						  setTimeout(function(){ 
							 $(".loadtips").hide();
							 for(var kn=s;kn<e;kn++){
								$(".rankcon li").eq(kn).css("display","").find("img[lz_src]").attr("src",function(){
								   var src=$(this).attr("lz_src");
								   $(this).removeAttr("lz_src");
								   return src;
								});
							 }
							  p=p+1;
							 if(p>=tpage){cscroll=0;}else{cscroll=1;}
						   }, 2000); 
		
					}
				}
			})	
	   } 
$(window).scroll(function(){
    var scrollTop1 = getScrollTop();
    // 顶部浮动
    if (scrollTop1>=$('#headwp').offset().top) {
        $('#headwp>div.headArea').addClass('fixed');
    } else {
        $('#headwp>div.headArea').removeClass('fixed');
    } 
	if (scrollTop1>=$(".rankcon li").eq(5).offset().top) {
          $('#gotop').show();
      } else {
         $('#gotop').hide();
     }  
}); 	   
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>