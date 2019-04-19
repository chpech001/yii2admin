<?php defined("APP_PATH") or die('Access denied');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>好玩的手机游戏_好玩的安卓手游推荐-好游快爆app</title>
<meta name="keywords" content="好玩的手机游戏,好玩的安卓手游推荐,新奇游戏">
<meta name="description" content="好游快爆新奇频道汇聚了新鲜好玩的手机游戏，实时同步各大应用市场的新奇手游，为您提供高质量、有趣好玩的安卓手游推荐， 关注好游快爆新奇频道，抢先发现新鲜好游戏。">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="canonical" href="https://www.3839.com/xinqi.html">
<link href="<?=C::$cdn_path?>v2/css/novel.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
<script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
<script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
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
<div class="heji-slide">
    <div class="content" id="slide">
        <ul class="swipe-wrap cf swiper-wrapper">
		    <?php
			   $slide=$result['slide'];
			   $lnum=0;
			   foreach($slide as $k1=>$v1){
			   		     if(!empty($v1['link'])){
						   $surl=$v1['link'];
						  }else{
						   $surl=Comm::get_url('game_detail','',array('id'=>$v1['interface_id'],'view_ishtml'=>1));
						  }
			    if($v1['interface_type']==12){
				$lnum=0;
			?>
            <li class="swiper-slide"><a href="<?=$surl?>"><img src="<?=$v1['icon']?>" alt="<?=$v1['title']?>"/><?=$lnum?></a></li>
			<?php }}?>
			    <?php
				       $otherslide=explode("\r\n",trim($newnessinfo['slide']));
					   foreach($otherslide as $k=>$v){
					     if(!empty($v)){
						 $sinfo=explode("|",trim($v));
						 $lnum++;
						 $sinfo[1]=str_replace("www.3839.com","m.3839.com",$sinfo[1]);
						 $sinfo[1]=str_replace("https:","",$sinfo[1]);
						 $sinfo[2]=str_replace("https:","",$sinfo[2]);
						 if(!preg_match('/heji/',$sinfo[1])){
					  ?>
					    <li class="swiper-slide"><a href="<?=$sinfo[1]?>"><img src="<?=$sinfo[2]?>" alt="<?=$sinfo[0]?>"/><?=$lnum?></a></li>
					 <?php }}}?>		
        </ul>
    </div> 
</div>
<div class="heji-nav">
      <ul>     <?php
				  $card1=$result['card'];
				  $cat_index=Comm::get_url('category','index',array('view_ishtml'=>1));
				  $card=array();$knz=0;
				  foreach($card1 as $k1=>$v1){
				   if($v1['interface_type']==3 || $v1['interface_id']==174){
				     $card[$knz]=$v1;
					 $knz++;
				   }
				  }
				  $cardnum=count($card);
				  for($kn=0;$kn<$cardnum;$kn++){
				  $v1=$card[$kn];
				  $interface_type=$v1['interface_type'];
				  if($interface_type==3){
				   $url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v1['interface_id']));
				   if($v1['interface_id']==197){
				     $url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v1['interface_id'],'type'=>'new'));
				   }
				  }else if($interface_type==18){
				   $url=Comm::get_url('coll','list',array('view_ishtml'=>1));
				  }
				?>
				<li><a href="<?=$url?>"><span class="img"><img src="<?=$v1['icon']?>" alt="<?=$v1['title']?>" ></span><?=$v1['title']?></a></li>
				<?php }?>
				<?php
				  if($carnum<8){
				   $dnum=8-$cardnum;
				   $othercard=explode("\r\n",trim($newnessinfo['card']));
				  }
				  foreach($othercard as $km=>$vm){
				    $str=$vm;
					$info=explode("|",$str);
					if(!preg_match("/heji/",$info[1])){
					if($dnum>0){
					$dnum--;
					$info[1]=str_replace("www.3839.com","m.3839.com",$info[1]);
				    $info[1]=str_replace("https:","",$info[1]);
					$info[2]=str_replace("https:","",$info[2]);
				?>
				<li><a href="<?=$info[1]?>"><span class="img"><img src="<?=$info[2]?>" alt="<?=$info[0]?>" ></span><?=$info[0]?></a></li>
				<?php }}}?>		
		        <li><a href="<?=$cat_index?>"><span class="img"><img src="//m.3839.com/static/hykb/images/nimg9.png"></span>更多分类</a></li>
    </ul>
</div>
 <?php
    $flist=$result['data']; 
	$ncount=0;
     foreach($flist as $k2=>$v2){
	  if(!empty($v2['tag_id']) || !empty($v2['list_hd']) || !empty($v2['list_cate'])){
	  $ncount++;
	  if($ncount<=17){
	    $show=''; $cls='';
		$lz=' lzimg="1" lz_src';
	  }else{
	    $show='none';$cls='npart';
		$lz=' lz_src';
	  }
  ?><div class="area <?=$cls?>" style="display:<?=$show?>">
      <?php
	   if(!empty($v2['tag_id'])){
	     $tlist=$v2['list_tag'];
		 if($v2['tag_id']!=197){
		  $url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v2['tag_id']));
		 }else{
		  $url=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v2['tag_id'],'type'=>'new'));
		 }
       ?>
	   <?php if(in_array($v2['tag_id'],$category_arr)){?>
          <div class="hd">
           <em><?=$v2['title']?></em>
            <a class="more" href="<?=$url?>">显示全部</a>
          </div><?php }else{?>
          <div class="hd">
           <em><?=$v2['title']?></em>
            <a class="more" href="<?=$url?>">显示全部</a>
          </div><?php }?>	   
   <div class="bd">
        <ul class="glist">
		    <?php 
			  foreach($tlist as $k5=>$v5){
			   $gurl=Comm::get_url('game_detail','',array('id'=>$v5['id'],'view_ishtml'=>1));
			?>
            <li><a href="<?=$gurl?>"> <img <?=$lz?>="<?=$v5['icon']?>" alt="<?=$v5['title']?>下载"><?=$v5['title']?></a></li>
			<?php }?>
        </ul>
    </div><?php }?> 
   <?php
	   if(!empty($v2['list_hd'])){
	    $tlist=$v2['list_hd'];
    ?>
    <div class="hd">
        <em><?=$v2['title']?></em>
        <a class="more" href="#" onClick="pop('toapp3');return false;">显示全部</a>
    </div>
    <div class="bd">
        <ul class="hdlist">
		  <?php foreach($tlist as $k5=>$v5){?>
            <li><a onClick="pop('toapp');return false;"><img <?=$lz?>="<?=$v5['icon']?>" alt="<?=$v5['title']?>"><span><?=$v5['title']?></span></a></li>
		    <?php }?>      
        </ul>
    </div><?php }?>
   <?php
	   if(!empty($v2['list_cate'])){
	    $tlist=$v2['list_cate'];
		$cat_url=Comm::get_url('category','index',array('view_ishtml'=>1));
    ?>
    <div class="hd">
        <em><?=$v2['title']?></em>
        <a class="more" href="<?=$cat_url?>">显示全部</a>
    </div>
    <div class="bd">
        <ul class="itlist">
		 <?php 
		   $cnum=0;
		   foreach($tlist as $k5=>$v5){
		    $cnum++;
		    if($cnum<=10){
		    $curl=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v5['id']));
		 ?>
            <li>
                <a href="<?=$curl?>">
                    <div class="img"><img <?=$lz?>="<?=$v5['icon']?>" alt="<?=$v5['title']?>"><span><?=$v5['num']?>款</span></div>
                    <span class="name"><?=$v5['title']?></span>
                    <p class="desc"><?=$v5['description']?></p>
                </a>
            </li>
			<?php }}?>
        </ul>
    </div><?php }?>
	</div><?php }}?>       
<div class="loadtips" style="display:none">
    <span class="ico"></span><span>正在加载中...</span>
</div>
<a id="gotop" class="gotop" style="display:none" onClick="go_to($('body'))">返回顶部</a>
<div class="friLink">
    <dt>友情链接</dt>
	<?php 
	if ($newnesslinks) {
	foreach($newnesslinks as $k=>$v) {
	echo '<dd><a href="'.$v['url'].'">'.$v['title'].'</a></dd>';
	}
	}
	?>
</div>
<div class="footCopy" id="footer">
<script type="text/javascript" src="//newsimg.5054399.com/hykb/wap/js/footer_wap.js"></script>
</div>
<div class="navFootWp">
    <div class="navFoot">    
        <ul class="cf">
		    <?php
			  $home_url=Comm::get_url('home','',array('view_ishtml'=>1));
			  $pai_url=Comm::get_url('top','hot',array('view_ishtml'=>1));
			  $cat_url=Comm::get_url('category','',array('view_ishtml'=>1));
			  $xq_url=Comm::get_url('newness','',array('view_ishtml'=>1));
			?>
            <li><a href="<?=$home_url?>"><i class="reco"></i>游戏推荐</a> </li>
            <li><a href="<?=$pai_url?>"><i class="rank"></i>排行榜</a></li>
            <li class="on"><a><i class="spec"></i>新奇</a></li>
            <li><a href="https://m.bbs.3839.com/"><i class="bbs"></i>论坛</a></li>
        </ul>
    </div>
 </div>
 <script language="javascript">
 <?php
   $npart_num=$ncount-17;
   $tpage=ceil($npart_num/5);
 ?>	
     var p=1;
	 var cscroll=1;
	 var tpage=<?=$tpage?>;
	 var npart=<?=$npart_num?>;
     $(window).scroll(function(){
            var scrollTop = $(this).scrollTop();var scrollHeight = $(document).height();var windowHeight = $(this).height();
            if(scrollTop + windowHeight > scrollHeight-300){
			     if(cscroll==1){
				     cscroll=0;
					  var s=(p-1)*5;
					  var e=s+5;
					  if(e>=npart){e=npart;}
					  $(".loadtips").show();
					  setTimeout(function(){ 
						 $(".loadtips").hide();
						 for(var kn=s;kn<e;kn++){
						  $(".npart").eq(kn).show().find("img[lz_src]").attr("src",function(){
						    var src=$(this).attr("lz_src");
							$(this).removeAttr("lz_src");
						    return src;
						  });
						 }
						  p=p+1;
					     if(p>tpage){cscroll=0;}else{cscroll=1;}
					   }, 2000); 
	
			    }
            }

        })	
$(window).scroll(function(){
    var scrollTop1 = getScrollTop();
    // 顶部浮动
    if (scrollTop1>=$('#headwp').offset().top) {
        $('#headwp>div.headArea').addClass('fixed');
    } else {
        $('#headwp>div.headArea').removeClass('fixed');
    }
    if (scrollTop1>=$(".hdlist").offset().top-400) {
          $('#gotop').show();
      } else {
         $('#gotop').hide();
     }	
});  
popData['toapp4'] = '<div class="pop" style="display:block"><a class="pclose">关闭</a>'
	+ '    <div class="ptit">更多精彩功能 前往好游快爆</div>'
	+ '    <div class="pcon">'
	+ '        <p class="pf24 grey tac">发现好玩游戏  预约抢先尝鲜<br>领取游戏礼包  体验内测资格<br>更多新鲜活动  尽在好游快爆</p>'
	+ '    </div>'
	+ '    <div class="pbtn">'
	+ '        ' + (is_ios ? '<a onclick="pop(\'ios\')" rel="external nofollow">马上下载</a>' : '<a href="//d.4399.cn/Q7">马上下载</a>')
	+ '    </div>'
	+ '</div>'; 	   
</script>
<script src="<?=C::$cdn_path?>v2/js/fastclick.js"></script>
<script src="<?=C::$cdn_path?>v2/js/swiper-4.3.5.min.js?v=22"></script>
<script>
$(function() {
    FastClick.attach(document.body);
    var swiper = new Swiper('#slide', {
      slidesPerView: 'auto',
      centeredSlides: true,
      loop:true  
    });
});
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>