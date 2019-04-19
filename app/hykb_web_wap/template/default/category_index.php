<?php defined("APP_PATH") or die('Access denied');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>手游分类大全_热门游戏分类排行榜-好游快爆app</title>
<meta name="keywords" content="手游分类大全,热门游戏分类排行榜,手游类型分类">
<meta name="description" content="好游快爆分类大全为您提供丰富的游戏种类选择，这里集合了热门单机游戏、moba游戏、卡牌游戏、射击游戏等多种类型手游，热门游戏分类一应俱全，总有一款适合您。">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="canonical" href="//www.3839.com/fenlei/">
<link href="<?=C::$cdn_path?>v2/css/novel.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
<script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
<script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<?php include 'common/header.php';?>
<ul class="breadcrumb">
    <li><a href="../wap.html">首页</a></li>
    <li><a>全部分类</a></li>
</ul>
<ul class="spec-reco">
    <?php
	  $hcat=$return['result']['hot'];
	  foreach($hcat as $k1=>$v1){
	   $h_cat_url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v1['id']));
	?>
    <li><a href="<?=$h_cat_url?>"><img src="<?=$v1['icon']?>" alt="<?=$v1['title']?>分类"><?=$v1['title']?><span class="num"><?=$v1['num']?>款</span></a></li>
	<?php }?>
</ul>
<a class="loadmore" href="#">点击查看更多分类</a>
<div class="friLink" id="friLink">
    <dt>友情链接</dt>
<?php 
if ($catlinks) {
foreach($catlinks as $k=>$v) {
echo '<dd><a href="'.$v['url'].'">'.$v['title'].'</a></dd>';
}
}
?>
</div>
<div class="footCopy" id="footer">
<script type="text/javascript" src="//newsimg.5054399.com/hykb/wap/js/footer_wap.js"></script>
</div>
<a class="specmenu" href="#">菜单</a>
<?php $cat_list=$return['result']['category'];?>
<div class="mask"></div>
<div class="specnav" style="display:none;">
    <ul class="hd hdtab">
        <li class="on" rel="0"><span class="it3"></span>玩法</li>
        <li rel="1"><span class="it4"></span>风格</li>
        <li rel="2"><span class="it2"></span>题材</li>
	    <li rel="3"><span class="it1"></span>特色</li>
    </ul>
    <div class="bd bdtab">
        <ul>
            <li>
			    <?php $wf_cat=$cat_list[0];?>
                <div class="item">玩法<span>（ <?=count($wf_cat['data'])?> ）</span></div>
                <div class="link">
				   <?php 
				    foreach($wf_cat['data'] as $k=>$v){
					 $wf_cat_url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v['id']));
				   ?>
                    <a href="<?=$wf_cat_url?>"><?=$v['title']?></a>
				   <?php }?>
                </div>
            </li>
            <li style="display:none">
			     <?php $fg_cat=$cat_list[1];?>
                <div class="item">风格<span>（ <?=count($fg_cat['data'])?> ）</span></div>
                <div class="link">
				   <?php 
				    foreach($fg_cat['data'] as $k=>$v){
					 $fc_cat_url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v['id']));
				   ?>
                    <a href="<?=$fc_cat_url?>"><?=$v['title']?></a>
				   <?php }?>
                </div>
            </li>
            <li style="display:none">
			    <?php $tc_cat=$cat_list[2];?>
                <div class="item">题材<span>（ <?=count($tc_cat['data'])?> ）</span></div>
                <div class="link">
				   <?php 
				    foreach($tc_cat['data'] as $k=>$v){
					 $tc_cat_url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v['id']));
				   ?>
                    <a href="<?=$tc_cat_url?>"><?=$v['title']?></a>
				   <?php }?>
                </div>
            </li>			
            <li style="display:none">
			    <?php $ts_cat=$cat_list[3];?>
                <div class="item">特色<span>（ <?=count($ts_cat['data'])?> ）</span></div>
                <div class="link">
				   <?php 
				    foreach($ts_cat['data'] as $k=>$v){
					 $ts_cat_url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v['id']));
				   ?>
                    <a href="<?=$ts_cat_url?>"><?=$v['title']?></a>
				   <?php }?>
                </div>
            </li>			
			
			
        </ul>
    </div>
</div>
<script src="<?=C::$cdn_path?>v2/js/fastclick.js"></script>
<script>
$(function() {
    FastClick.attach(document.body);
    $('.specmenu').click(function(){
        if($(this).hasClass('mnhide')){
            $(this).removeClass('mnhide');
            $('.specnav,.mask').hide();
        }else{
            $(this).addClass('mnhide');
            $('.specnav,.mask').show();
        }
		return false;
    })
	
    $('.loadmore').click(function(){
         if($('.specmenu').hasClass('mnhide')){
            $('.specmenu').removeClass('mnhide');
            $('.specnav,.mask').hide();
        }else{
            $('.specmenu').addClass('mnhide');
            $('.specnav,.mask').show();
        }
		return false;
    })
	
   $(".hdtab li").click(function(){
     var tab_id=$(this).attr("rel");
	 $(".hdtab li").attr("class","");
	 $(this).attr("class","on");
	 $(".bdtab li").hide();
	 $(".bdtab li").eq(tab_id).show();
   });
   $('#headwp>div.headArea').addClass('fixed');		
});
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>