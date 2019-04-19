<?php defined("APP_PATH") or die('Access denied');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<?php if($type=='hot'){?>
	<title><?=$catename?>游戏大全_热门<?=$catename?>手游排行榜-好游快爆</title>
    <meta name="Keywords" content="<?=$catename?>游戏大全,热门<?=$catename?>手游排行榜,热门<?=$catename?>手游推荐"/>
    <meta name="Description" content="好游快爆app为您提供<?=$catename?>游戏大全、热门<?=$catename?>手游排行榜、热门<?=$catename?>手游推荐。好游快爆，游戏爱好者自己的APP，致力于好玩的手机游戏分享。"/>
	<link rel="canonical" href="https://www.3839.com/fenlei/cat_hot_<?=$id?>.html">
	<?php }?>
	<?php if($type=='new'){?>
	<title>最新<?=$catename?>游戏_最新<?=$catename?>手游排行榜-好游快爆</title>
    <meta name="Keywords" content="最新<?=$catename?>游戏,最新<?=$catename?>手游排行榜,最新<?=$catename?>手游推荐"/>
    <meta name="Description" content="好游快爆app为您提供最新<?=$catename?>游戏、最新<?=$catename?>手游排行榜、最新<?=$catename?>手游推荐。好游快爆，游戏爱好者自己的APP，致力于好玩的手机游戏分享。"/>
    <link rel="canonical" href="https://www.3839.com/fenlei/cat_new_<?=$id?>.html">
	<?php }?>
	<?php if($type=='star'){?>
	<title>好玩的<?=$catename?>游戏_好玩的<?=$catename?>手游排行榜-好游快爆</title>
    <meta name="Keywords" content="好玩的<?=$catename?>游戏,好玩的<?=$catename?>手游排行榜,好玩的<?=$catename?>手游推荐"/>
    <meta name="Description" content="好游快爆app为您提供好玩的<?=$catename?>游戏、好玩的<?=$catename?>手游排行榜、好玩的<?=$catename?>手游推荐。好游快爆，游戏爱好者自己的APP，致力于好玩的手机游戏分享。"/>
	<link rel="canonical" href="https://www.3839.com/fenlei/cat_star_<?=$id?>.html">
	<?php }?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="<?=C::$cdn_path?>v2/css/novel.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
<script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
<script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<?php include 'common/header.php';?>
<ul class="breadcrumb">
    <li><a href="../wap.html">首页</a></li>
    <li><a href="https://m.3839.com/fenlei/">全部分类</a></li>
    <li><span><?=$catename?></span></li>
</ul>
<ul class="seltab">
            <li class="<?php if($type=='hot'){echo 'on';}?>"><a href="cat_hot_<?=$id?>.html" target="_self"><span>热门推荐</span></a></li>
			<li class="<?php if($type=='new'){echo 'on';}?>"> <a href="cat_new_<?=$id?>.html" target="_self"><span>最新更新</span></a></li>
			<li class="<?php if($type=='star'){echo 'on';}?>"><a href="cat_star_<?=$id?>.html" target="_self"><span>最高评分</span></a></li>
</ul>
<div class="spec-list">
    <ul class="cf">     
			   <?php 
			    $cnt=0;
			    foreach($gamelist as $k1=>$v1){
				  $cnt++;
			      $gamelen=mb_strlen($v1['title'],'utf-8');
				  if($gamelen>12){
				    $gamename=mb_substr($v1['title'],0,12,'utf-8').'...';
				  }else{
				    $gamename=$v1['title'];
				  }
				  $url=Comm::get_url('game_detail','',array('id'=>$v1['id'],'view_ishtml'=>1));
				  if($cnt<=20){
				    $show='';
					$lzimg=' lzimg="1" lz_src';
				  }else{
				    $show='none';
					$lzimg=' lz_src';
				  }
				  $num_size_arr=explode("|",$v1['num_size_lang']);
			   ?>	
            <li style="display:<?=$show?>">
            <a class="gameli" href="<?=$url?>">
				<img class="img" <?=$lzimg?>="<?=$v1['icon']?>" alt="<?=$v1['title']?>下载">
                <div class="con">
                    <em class="name"><?=$gamename?></em>
                    <p class="deta"><?=$v1['tags']?></p>
                    <p class="info">
					   <?php if(!empty($v1['star'])){?>
						<span class="spec"><?=$v1['star']?>分</span>
						<?php }?>
                        <span><?=$num_size_arr[0]?></span>
                        <span><?=$num_size_arr[1]?></span>
                    </p>
                </div>
            </a>
			<?php if($v1['status']==1){?><a class="btn green" href="<?=$url?>">下载</a><?php }?>
			<?php if($v1['status']==4){?><a class="btn yellow" href="<?=$url?>">预约</a><?php }?>
			<?php if($v1['status']==6){?><a class="btn green" href="<?=$url?>">查看详情</a><?php }?>
			<?php if($v1['status']==3 || $v1['status']==5){?><a class="btn green" href="<?=$url?>">查看详情</a><?php }?>
        </li>
		<?php }?>
    </ul>
</div>
<div class="loadtips" style="display:none">
    <span class="ico"></span><span>正在加载中...</span>
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
 <?php $tpage=ceil($cnt/20);?>	
     var p=1;
	 var cscroll=1;
	 var tpage=<?=$tpage?>;
	 var tnum=<?=$cnt?>;
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
							  $(".spec-list li").eq(kn).show().find("img[lz_src]").attr("src",function(){
							    var src=$(this).attr("lz_src");
								$(this).remove("lz_src");
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
   $('#headwp>div.headArea').addClass('fixed');
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>