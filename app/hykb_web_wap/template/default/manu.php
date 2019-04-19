<?php defined('APP_PATH') or die('Access denied');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>好游快爆开发者榜_游戏厂商排行榜-好游快爆app</title>
<meta name="keywords" content="游戏厂商排行榜,游戏公司排名,游戏开发者推荐">
<meta name="description" content="好游快爆开发者榜为您展示高口碑的游戏开发者，了解行业开发者情况，为您喜欢的开发者打call，关注开发者榜就能了解开发者新游戏动态。">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="full-screen" content="yes" />
<meta name="x5-fullscreen" content="true" />
<link rel="canonical" href="https://www.3839.com/top/manu.html">
<link href="<?=C::$cdn_path?>v2/css/style.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
<script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
<script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
<script src="<?=C::$cdn_path?>js/detail.js?v=<?=CDN_V?>"></script>
</head>
<body>
<?php include_once("baidu_js_push.php") ?>
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

<div class="rkDesc rkit4">
    <div class="con">
         <p>展示高口碑的游戏开发者，了解行业开发者情况，为你喜欢的开发者打call，关注开发者榜就能了解开发者新游戏动态</p>
    </div>
</div>

<div class="rankcon">
    <ol class="ulist">
		     <?php
			  $list=$return['result'];
			  foreach($list as $k=>$v){
			  $url=Comm::get_url('manu','detail',array('id'=>$v['uid'],'view_ishtml'=>1));
			  $kz=$k+1;
		      $emcls='<i class="num">'.$kz.'</i>';
			   if($kz<=20){
			    $show='';
				$lz=' lzimg="1" lz_src ';
			   }else{
			    $show='none';
				$lz=' lz_src ';
			   }
			   $sname=$v['title'];
			   if(empty($sname)){$sname=$v['nickname'];}
			   $jurl=Comm::get_url('manu','detail',array('view_ishtml'=>1,'id'=>$v['uid']));
			?>	
        <li style="display:<?=$show?>">
             <?=$emcls?>
            <a class="gameli" href="<?=$jurl?>">
                <div class="img"><img <?=$lz?>="<?=$v['avatar']?>" alt="<?=$v['nickname']?>"></div>  
                <div class="con">
                    <em class="name"><?=$sname?></em>
                    <p class="deta"><span><?=$v['defaule_desc']?></span></p>
                    <p class="info">
                        <span class="spec">口碑<?=$v['votemark']?></span>
                        <span>粉丝数 <?=$v['fans_num']?></span>
                    </p>
                </div>
            </a>
            <a class="btn" href="<?=$jurl?>">+关注</a>
        </li><?php }?>
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
<!-- navFoot -->
<div class="navFootWp">
    <div class="navFoot">    
        <ul class="cf">
		    <?php
			  $home_url=Comm::get_url('home','',array('view_ishtml'=>1));
			  $pai_url=Comm::get_url('top','top',array('type'=>'hot','view_ishtml'=>1));
			  $cat_url=Comm::get_url('category','',array('view_ishtml'=>1));
			  $xq_url=Comm::get_url('newness','',array('view_ishtml'=>1));
			  $wall_url=Comm::get_url('commentwall','',array('view_ishtml'=>1));
			?>
            <li><a href="<?=$home_url?>"><i class="reco"></i>游戏推荐</a> </li>
            <li class="on"><a><i class="rank"></i>排行榜</a></li>
            <li><a href="<?=$xq_url?>"><i class="spec"></i>新奇</a></li>
			<li><a href="<?=$wall_url?>"><i class="wall"></i>安利墙</a></li>
            <li><a href="https://m.bbs.3839.com/"><i class="bbs"></i>论坛</a></li>
        </ul>
    </div>
</div>
 <script language="javascript">
 <?php
   $tpage=ceil($kz/20);
 ?>	
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
	 if (scrollTop1>=$(".ulist li").eq(5).offset().top) {
          $('#gotop').show();
      } else {
         $('#gotop').hide();
     } 
});

    $(document).on('click','a.btn_goto',function(){
        pop_hide();
        if (is_ios) {
            pop2('pop_ios');
            // window.location.href = '//m.3839.com/qd-gaosu3.html';
            return false;
        }
        if (is_wechat) {
            $('#weixin_warn').show();
            return false;
        }
        AndroidConnect.launch('hykb://openTopic?type=gamedetail&gameId='+gameId, function(){
            document.location.href = downurl;
        });
        return false;
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
</body>
</html>
