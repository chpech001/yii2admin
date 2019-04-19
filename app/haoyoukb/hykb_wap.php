<?php
header('Content-Type:text/html;charset=utf-8');
require_once($_SERVER['DOCUMENT_ROOT'].'/app/haoyoukb/common.php');

$yx_id = intval($_GET['id']);//游戏ID
if ( $yx_id == '87961' || $yx_id == '87235' ) {
    die();
}

if ( $yx_id > 0 ) {
    $key = MEM_PRE.$yx_id;
    $res = get_data($key,$yx_id);
    if ( !$res ) {
        show301();
    }
}else {
	show301();
}

$show_url = $res['show_url'];
if($show_url == 1){
    show301();
}

$pcUrl = "//www.3839.com/a/".$yx_id.".htm";

// 补充信息
$buc = array();
if ($res['test_intro']){
	$buc = $res['test_intro'];
}

$star_usernum = intval($res['star_usernum']);

//预约人数、下载人数
$yuyue_tip = str_replace('已有', '', $res['num_yuyue']);
$play_tip = str_replace('下载', '', $res['num_down']);

//评分
$star = floatval($res['star']);

// 标题
$title_fen = $star ? $star.'分' : '';
$title_num = '';
if($res['status'] == 1 && $play_tip){ //下载人数
	$title_num = $play_tip."人在玩";
} else if ($res['status'] == 4 && $yuyue_tip){ //预约人数
	$title_num = $yuyue_tip;
}
$title_ext = $title_fen;
if ($title_num) $title_ext = $title_ext ? $title_ext.'，'.$title_num : $title_num;
if ($title_ext) $title_ext  = '('.$title_ext.')';

// 分享描述
$desc = $res['editor_recommend'];
if (!$desc) {
	$desc = '《'.$res['title'].'》，来自好游快爆APP强力推荐的一款超好玩游戏，快来下载体验吧！';
}

$downInfo = array(
	"kb_id" => $res['downinfo']['id'],
	"apkurl" => $res['downinfo']['apkurl'],
	"package" => $res['downinfo']['packag'],
	"appname" => $res['downinfo']['appname'],
	"icon" => reImg(replaceImg($res['downinfo']['icon'])),
	"md5" => $res['downinfo']['md5'],
);

$videoInfo = $res['videoinfo'];

function show404(){
	@header('HTTP/1.1 404 Not Found');
	@header("status: 404 Not Found");
	include ($_SERVER['DOCUMENT_ROOT'].'/404.html');
	exit;
}

function show301(){
//	@header('HTTP/1.1 301 Moved Permanently');
    @header('Location: //m.3839.com/');
	exit;
}

function replaceImg($icon){
    return preg_replace('#f\d{1,3}\.img4399\.com#','fs.img4399.com',$icon);
}

function reImg($img){
	return str_ireplace(array('https://','http://'),'//',$img);
}

$res['icon'] = reImg(replaceImg($res['icon']));
$videoInfo['icon'] = reImg(replaceImg($videoInfo['icon']));
?>
<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0, maximum-scale=1.0,user-scalable=no,minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no, email=no" name="format-detection">
<!-- 启用360浏览器的极速模式(webkit) -->
<meta name="renderer" content="webkit">
<!-- 避免IE使用兼容模式 -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
<meta name="HandheldFriendly" content="true">
<!-- 微软的老式浏览器 -->
<meta name="MobileOptimized" content="320">
<!-- uc强制竖屏 -->
<meta name="screen-orientation" content="portrait">
<!-- QQ强制竖屏 -->
<title><?=$res['title']?><?=$title_ext?>_好游快爆app-分享新鲜好游戏</title>
<link href="//newsimg.5054399.com/baodian/v3/wap/css/swiper.css" rel="stylesheet" type="text/css">
<link href="//newsimg.5054399.com/baodian/v3/wap/css/style_e4.css" rel="stylesheet" type="text/css">
<link rel="canonical" href="<?=$pcUrl?>">
<script type="text/javascript" src="//newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
<script type="text/javascript" src='//newsimg.5054399.com/haoyoukb/js/jquery_iwgcDialog.js'></script>
<?php if($star_usernum > 0){?>
<script type="text/javascript" src="//newsapp.5054399.com/cdn/comment/view_v2-ac-js-pid-1-fid-<?=$yx_id?>-p-1-page_num-1-reply_num-1-order-1.htm"></script>
<?php }?>
</head>

<body>
<div id='wx_pic' style="display:none;">
	<img src='<?=$res['icon']?>'>
</div>
<div class="b1">
    <ul class="cf">
        <li class="logo fl">
        <a href="//m.3839.com/"><img src="//newsimg.5054399.com/baodian/v3/wap/images/logo.png" alt="好游快爆">好游快爆</a>
        </li>
        <li class="load fr">
        <a href="//d.4399.cn/Q2" rel="external nofollow" class="and_download">下载APP</a>
        </li>
    </ul>
</div>
<div class="b4">
<ul>
<li>
<?php if ($videoInfo['id']){?>
	<div> 
		<center style="width:320px; height:180px;margin: 0 auto;">
	    <?php
			$vlink = $videoInfo['vlink'];
			if($vlink){
				$vlink = reImg($vlink);
	    ?>
			<video style="width:100%; height:100%;margin: 0 auto;" controls="controls" <?=$videoInfo['icon'] ? 'poster="'.$videoInfo['icon'].'"' : ''?> x5-video-player-type='h5'>
				<source src="<?=$vlink?>" type="video/mp4" />
			</video>
		<?php
			} else {
		?>  
			<img src="//newsimg.5054399.com/uploads/allimg/160225/191_1245434541.jpg" width="290" height="163">
	    <?php            
			}
	    ?>			
		</center>
	</div>  
<?php }?>
</li>
</ul>
</div>
<div class="b2">
    <div class="box">
        <ul class="c-1 cf">
           <dl class="cf fl">
                <dt class="fl"><img src="<?=$res['icon']?>" alt="<?=$res['title']?>"></dt>
                <dd class="d-1"><?=$res['title']?></dd>
                <dd class="d-2 cf">
				<?php 
				foreach($res['tags'] as $k=>$v) {
					echo '<span>'.$v['title'].'</span>';
				}
                ?>
                </dd>
                <dd class="d-4"><?php 
				if ($res['status'] == 4 && $res['num_yuyue'])
					echo '有超过<i>'.$yuyue_tip.'</i>该游戏';
				elseif ($res['status']==1 && $res['num_down'])
					echo '有超过<i>'.$play_tip.'</i>人在玩该游戏';
				?></dd>
            </dl>
			<?php if ($star) {?>
            <p class="score" id="score">
	            <em><?=$star?></em>
	            <i>评分</i>
	            <span><font class="t-1" style="width:<?=$star*10?>%"></font><font class="t-2"></font></span>
            </p>
			<?php } else {?>
			<div class="no-score">暂无评分</div>
			<?php }?>
        </ul>
		<ul class="c-8">
			<?php 
			if ($res['status']==1) {
                echo '<li class="an-1"><a href="#" class="down_btn">高速下载</a></li>';
            } else if ($res['status']==4) {
                echo '<li class="an-1"><a href="#" class="a2 down_btn">预约</a></li>';
            } else if ($res['status']==3 || $res['status']==5) {
                echo '<li class="an-1"><a href="#" class="a3" id="btn_off">敬请期待</a></li>';
            } else if ($res['status'] == 6) {
                echo '<li class="an-1"><a href="#" id="btn_off">查看详情</a></li>';
            }
			?>
			<li class="an-2">
			<span id="share_link" data-role="share">分享给朋友</span>
			</li>
        </ul>
  </div>
</div>  
 <div class="b2">
	 <ul class="c-2 cf">
		 <li id="tab_menu"><a href="#" class="on">游戏介绍</a><a href="#">评价<?php if($star_usernum > 0){?><em id="pl_num">0</em><?php }?></a></li>
	 </ul>
        
	<div id="tab_list">
	     <div class="box">
			<?php 
			if ($buc['open'] && $buc['title'] && $buc['info']) {
			?>
			<div class="prompt">
                <p class="cf"><?php if ($buc['shorttitle']) echo '<a href="#" class="fr" id="btn_tip">'.$buc['shorttitle'].' ></a>';?><?=$buc['title']?></p>
                <div class="<?php if ($buc['info2']) echo 'pro-hd'; else echo 'pro-bd';?>"><?=$buc['info']?></div>
<?php if ($buc['info2']) {?>
				<div class="pro-bd"><?php
$buc['info2'] = strtolower($buc['info2']);
if (substr_count($buc['info2'], '<a ')==substr_count($buc['info2'], '</a>')) {
echo $buc['info2'];
} else {
?>					<script>var div = document.createElement('div'); 
					div.innerHTML ='<?php echo str_replace('\'','\"',$buc['info2']);?>'; 
					document.write(div.innerHTML);</script>
<?php }?></div>
<?php }?>
            </div>
			<?php }?>

			<?php if ( $res['editor_recommend'] ) { ?>
			<div class="title tit-1">编辑推荐</div>
				<p class="jing"><?=$res['editor_recommend']?></p>
			<?php } ?>
	        <div class="swiper-container swiper-container1">
	        <div class="swiper-scrollbar"></div>
	            <div class="swiper-button-prev"></div>
	            <div class="swiper-button-next"></div>
	            <div class="swiper-wrapper">
	                    <?php
	                        $screenStr  = '';
							$screenpath = isset($res['screenpath']) ? $res['screenpath'] : array();
	                        $screenNum  = count($screenpath);
	                        foreach ($screenpath as $v) {$v = reImg(replaceImg($v));
	                            $screenStr .= '<div class="swiper-slide"><img src="" class="empty" /><img src="'.$v.'"></div>';
	                        }
	                        echo $screenStr;
	                    ?>
	            </div>
	        </div>
	     	<div class="swiper-container swiper-container2">
	     		<div class="swiper-pagination2"><span class="swiper-curr"></span>/<span class="swiper-count"></span></div>
	     		<div class="swiper-wrapper">
	     			
	     		</div>
	     	</div>
	        <div class="title tit-2">简介</div>
	        <ul class="c-3" id="appinfo">
	            <?php $appinfo = strip_tags(htmlspecialchars_decode($res['appinfo']));?>
	            <li id="appinfoli" style="display:block;padding-bottom:0px;margin-bottom:10px;height:72px;overflow:hidden;"><div id="appinfodiv"><?=$appinfo?></div></li>
	        </ul>
	        <p class="zhan" id="btn_zhan" style="display:none">展开</p>
			
			<?php if ($res['applog']) {?>
			<div class="title tit-8">更新日志</div>
            <ul class="c-3">
            <li id="applogli" style="display:block;padding-bottom:0px;margin-bottom:10px;height:72px;overflow:hidden;">
				<div id="applogdiv">
				<?=htmlspecialchars_decode($res['applog'])?>
				</div>
			</li>
            </ul>
            <p class="zhan" id="btn_zhan2" style="display:none">展开</p>
			<?php }?>
			<?php $gameinfo = $res['gameinfo'];?>
	        <div class="title tit-3">详细信息</div>
	            <ul class="c-5 cf">
					<?php if ($res['status'] != 4 && $gameinfo['size'] && $gameinfo['v']) { ?>
					<li>游戏大小：<em><?=$gameinfo['size']?></em></li>
	                <li>游戏版本：<em><?=$gameinfo['v']?></em> </li>
					<?php }?>
	                <li>系统要求：<em><?=$gameinfo['sys']?></em></li>
	                <li>更新时间：<em><?=date('Y.m.d', $gameinfo['time'])?></em></li>
	                <li>语言：<em><?=$gameinfo['lang']?></em></li>
	                <li>开发商：<em><?=$gameinfo['dev']?></em></li>
	            </ul>
	    </div>
	    <div class="box" style="display:none">
	    	<?php $iframeUrl = "//newsapp.5054399.com/comment/get/v1/comment3.html?pid=1&fid=".$yx_id;?>
	    	<script>
			var iframeUrl = '<?=$iframeUrl?>&dm=' + window.location.host;
	    	var F_FRAME_ID = "CommFrame";
	    	function F_Resize(h){
	    	document.getElementById(F_FRAME_ID).height = h;
	    	}
	    	document.write('<iframe id="'+F_FRAME_ID+'" name="'+F_FRAME_ID+'" width="100%" height="100" scrolling="no" allowtransparency="true" src="'+iframeUrl+'" frameborder="0" style="border:0px;margin-bottom:5px;"></iframe>');
	    	</script>
	    </div>
    </div>
</div>

<div class="footcon">
	<p>本公司产品适合10周岁以上玩家使用 未成年人家长监护</p>
	<p>
		<a rel="external nofollow" href="http://www.miitbeian.gov.cn/">ICP证：闽ICP备14017048号</a>
		<a rel="external nofollow" href="http://sq.ccm.gov.cn/ccnt/sczr/service/business/emark/toDetail/65df7e24611047c091053caa546be9f9">闽网文〔2018〕0806-043号</a>
	</p>
    <p>&copy;2009 - 2018 3839.com All Rights Reserved.</p>
</div>

<div class="b3">
    <div class="box" id="foot" style="display:none">
	    <ul>
	    <li class="sy-4"></li><!--当点击关闭时，foot去掉class"pad50"-->
	    <li class="sy-1"><img src="//newsimg.5054399.com/baodian/v3/wap/images/img2.png" alt="好游快爆APP"></li>
	    <li class="sy-2">
	    <p class="p-1">好游快爆 - 分享好游戏</p>
	    <p class="for_scroll">一个分享精品游戏的APP</p>
	    <p class="for_scroll" style="display:none" id="prov_num">分享好游戏，一起推爆款</p>
	    </li>
	    <li class="sy-3"><a href="//d.4399.cn/Q2" rel="external nofollow" class="and_download">免费下载</a></li>
	    
	    </ul>
    </div>
</div>

<div id="weixin_warn" style="display:none;">
<div class="bgmark"></div>
<div class="wxtips"></div>
</div>

<div class="dia_box" id="dia_off" style="display:none">
	<a href="#" class="dia_close" onclick="return $.iwgcDialog.cancel()">关闭</a>
	<div class="dia_con">
    	<div class="dia_tit">温馨提示</div>
        <p class="pt20">该游戏暂不支持预约和下载，如需了解该游戏的最新状态，可以前往快爆APP收藏该游戏哦。</p>
        <div class="dia_btn">
            <a href="#" class="a1" onclick="return $.iwgcDialog.cancel()">暂不前往</a>
            <a href="#" class="a2 btn_goto">立即前往</a>
        </div>
    </div>
</div>

<div class="dia_box" id="dia_tip" style="display:none">
	<a href="#" class="dia_close" onclick="return $.iwgcDialog.cancel()">关闭</a>
	<div class="dia_con">
    	<div class="dia_tit">请在好游快爆中打开该页面</div>
        <p class="pt20">如已安装好游快爆APP，可点击立即前往在该游戏详情页打开，如没有安装好游快爆APP，可点击立即前往下载安装好游快爆APP哦。</p>
        <div class="dia_btn">
            <a href="#" class="a1" onclick="return $.iwgcDialog.cancel()">暂不前往</a>
            <a href="#" class="a2 btn_goto">立即前往</a>
        </div>
    </div>
</div>

<div class="dia_box" id="dia_comment" style="display:none">
	<a href="#" class="dia_close" onclick="return $.iwgcDialog.cancel()">关闭</a>
	<div class="dia_con">
    	<div class="dia_tit">欢迎下载<i>好游快爆APP</i>参与评论</div>
        <p class="pt20">好游快爆APP，我们玩家自己的APP，在这里你可以和高玩一同讨论交流游戏，分享你的快乐，发表你的看法。每天还有玩家分享各类好玩新奇的游戏，这里是游戏爱好者的天堂，快来加入吧！</p>
        <div class="dia_btn">
            <a href="//m.3839.com/" id="btn_app" class="a3">下载好游快爆APP</a>
        </div>
    </div>
</div>

<?php $mem->close(); ?>
<script src="//newsimg.5054399.com/mobileStyle/v3/js/AndroidConnect.js"></script>
<script src="//newsimg.5054399.com/baodian/v3/wap/js/swiper.js"></script>
<script src="//newsimg.5054399.com/js/hykb_qd_version.js"></script>
<script>
		var ua = navigator.userAgent.toLowerCase();
		var is_ios = /iphone|ipad|ipod/.test(ua);
		var is_wechat = ua.match(/MicroMessenger/i) == 'micromessenger';
		var title_num = '<?=$title_num?>';

        var swiper = new Swiper('.swiper-container1', {
            slidesPerView:'auto',
            grabCursor: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            scrollbar: '.swiper-scrollbar',
        });

        var swiper2 = new Swiper ('.swiper-container2',{
			onSlideChangeStart:function(sw){
				$(".swiper-pagination2 .swiper-curr").text(sw.activeIndex+1);
			}
		});
        // 点击放大
        $(".swiper-container .swiper-slide").on("click",function(e){
        	// copy
        	if($(".swiper-container2 .swiper-slide").length == 0){
        		$(".swiper-container2 .swiper-wrapper").append($(".swiper-container .swiper-wrapper").html());
        	}
        	
        	var _index = $(this).index(".swiper-container .swiper-slide");
			$(".swiper-container2").show();
			swiper2.update();//更新
			swiper2.slideTo(_index,0);//定位1
			$(".swiper-pagination2 .swiper-curr").text(_index+1);//定位2
			$(".swiper-pagination2 .swiper-count").text(swiper2.slides.length);//计算总页数
        });
        // 设置高度+点击消失
		$(".swiper-container2").height($(window).height()).on("click",function(){$(this).hide()});
		$(window).resize(function(){
			$(".swiper-container2").height($(window).height());
		});

		if (!is_ios) {
			$('#foot').show();
		}

		function shuoZhan(btn,id1,id2){
			var h1 = id1.height();
			var h2 = id2.height();
			if (h2 > h1)
			{
				btn.show();

				btn.click(function(){
				 var text = $(this).text();
				 if ( text == "展开" ) {
					id1.height('auto');
					$(this).text("收起");
					$(this).addClass("shuo");
				 }else {
					id1.height(h1);
					$(this).text("展开");
					$(this).removeClass("shuo");
					$(this).addClass("zhan");
				 } 
				 });

			}
		}

		shuoZhan($('#btn_zhan2'),$('#applogli'),$('#applogdiv'));
		shuoZhan($('#btn_zhan'),$('#appinfoli'),$('#appinfodiv'));

	   if ($('#btn_off').length>0)
	   {
			$('#btn_off').click(function(){
				$.iwgcDialog({
					id:'dia_off'
				});
				return false;
			});
	   }

	   if ($('#btn_tip').length>0)
	   {
		   $('#btn_tip').click(function(){
				$.iwgcDialog({
					id:'dia_tip'
				});
				return false;
			});
	   }

	   var downInfo = <?=json_encode($downInfo)?>;

	   var downurl = 'http://vedio.5054399.com/pg/g/'+lastHykbQdVersion+'/gaosu1/'+downInfo['kb_id']+'.hykb_'+lastHykbQdVersion+'_gaosu1.apk';

	   $('#btn_app').click(function(){
			$.iwgcDialog.cancel();

			if (is_ios) {
        		window.location.href = '//m.3839.com/qd-gaosu1.html';
        		return false;
    		}

    		if (is_wechat) {
				$('#weixin_warn').show();
				return false;
    		}

			AndroidConnect.launch('hykb://openTopic?topicId=0', function(){
				document.location.href = downurl;
			});

			return false;
	   });

	   $('.btn_goto').click(function(){

			$.iwgcDialog.cancel();

			if (is_ios) {
        		window.location.href = '//m.3839.com/qd-gaosu1.html';
        		return false;
    		}

    		if (is_wechat) {
				$('#weixin_warn').show();
				return false;
    		}

<?php if ($res['status']==3 || $res['status']==5) {?>
			//downClick();
			AndroidConnect.launch('hykb://openTopic?type=gamedetail&gameId=<?=$yx_id?>', function(){
				document.location.href = downurl;
			});
<?php } else {?>
			AndroidConnect.launch('hykb://openTopic?type=gamedetail&gameId=<?=$yx_id?>', function(){
				document.location.href = downurl;
			});
<?php }	?>

            return false;
		});
        $('.down_btn').click(function () {
			if (is_ios) {
        		window.location.href = '//m.3839.com/qd-gaosu1.html';
        		return false;
    		}

    		if (is_wechat) {
				$('#weixin_warn').show();
				return false;
    		}
            
            downClick();

            return false;
        });

		function downClick(){
            var detail_downurl = downInfo['apkurl'];
            var detail_package = downInfo['package'];
            var detail_title = downInfo['appname'];
            var detail_pic = (document.location.protocol=="https:"?"https:":"http:")+downInfo['icon'];
            var detail_md5 = downInfo['md5'];
        	AndroidConnect.launch('hykb://downloadManager?url=' + detail_downurl + '&packageName=' + detail_package + '&name=' + encodeURIComponent(detail_title) + '&icon=' + encodeURIComponent(detail_pic) + '&md5=' + detail_md5 + '&uid=0&vid=0', function(){
                document.location.href = downurl;
            });
		}

        <?php if($star_usernum > 0){?>
		var pj = '';
		var pj_num = 0;

		if ( num > 9999 && num < 100000 ) {
			pj_num = num/10000;
			pj_num = Math.round(pj_num*100)/100;
			pj = pj_num.toFixed(2)+'W';
		}else if ( num > 99999 && num < 1000000 ) {
			pj_num = num/10000;
			pj_num = Math.round(pj_num*100)/100;
			
			pj = pj_num.toFixed(2) + 'W';
		}else if ( num > 999999 ) {
			pj = '100W+';
		}else {
			pj = num;
		}

        $('#pl_num').html(pj);
		<?php }?>

        $('.sy-4').click(function () {
			$('#foot').hide();
        });

		var zw = '<?=$play_num?>';
		var gameName = "<?= $res['title'] ?>";
		var share_icon = (document.location.protocol=="https:"?"https:":"http:")+<?=$res['icon']?>;
		$('#share_link').attr('data-share-title', document.title);
		$('#share_link').attr('data-share-url', window.location.href);
		$('#share_link').attr('data-share-img', share_icon);
		$('#share_link').attr('data-share-description',  '<?=$desc?>'+'如此好玩的游戏，我分享出来，你也赶快一起来玩玩~');

        function mouse_tab(list_menu, list_list, menu_item, menu_class, list_item, ac){
            var o = {
                "menu":list_menu,
                "list":list_list,
                "menu_item":menu_item,
                "menu_class":menu_class,
                "list_item":list_item,
                "event":ac
            }

            var yx_menu = $("#"+o.menu);
            var yx_list = $("#"+o.list);
            yx_menu.find(menu_item).each(function(index){
                $(this).bind(o.event,function(){
                    yx_list.find(o.list_item+":eq("+index+")").show().siblings(o.list_item).hide();
                    yx_menu.find(menu_item).removeClass(o.menu_class);
                    $(this).addClass(o.menu_class);
                    return false;
                });
            });
        } 
        mouse_tab('tab_menu', 'tab_list', 'a', 'on', '.box', 'click');

        $('.and_download').click(function () {
            if (is_ios) {
				window.location.href = '//m.3839.com/qd-gaosu1.html';
				return false;
            }
        });

        $(document).on('click','#weixin_warn', function(){
            $(this).hide();
        });
		
		function pop_comment() {
			$.iwgcDialog({
				id:'dia_comment'
			});
		}
		
		if(!ua.match(/4399_sykb/i)){
			$('#tab_list a').each(function(){
				var href = $(this).attr('href');
				if(/https?:/.test(href)){
					var reg = /https?:\/\/((?:[^/]+\.)?|[^./]+\.)(3839.com)(?:$|\/)/;
					if(!reg.test(href)){
						$(this).attr("onclick", "$.iwgcDialog({id:'dia_tip'});return false;");
					}
				}
			});
		}
 </script>
<script type="text/javascript" src="//newsimg.5054399.com/etweixin/v2/js/zepto.min.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/etweixin/v2/js/jshare.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>
