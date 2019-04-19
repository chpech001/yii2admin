<?php 
defined('APP_PATH') or exit('Access Denied');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$indexinfo['wap_title']?></title>
<meta name="Keywords" content="<?=$indexinfo['wap_keywords']?>"/>
<meta name="Description" content="<?=$indexinfo['wap_des']?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="canonical" href="https://www.3839.com/">
<link href="<?=C::$cdn_path?>css/style.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
<script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
<script src="//newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<div style="display:none"><img src="//newsimg.5054399.com/hykb/static/hykb_web_wap/images/applogo.png"></div>
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
<div id="mainDiv">
    <!-- 今日推荐 -->
    <div class="recoItem">
        <a href="<?=$slide['url']?>">
            <img class="img" src="<?=$slide['icon']?>" alt="<?=$slide_game['title']?>下载">
			<span class="mask"></span>
            <div class="detail">
                <em class="tit"><?=$slide['title']?></em>
                <p class="desc"><?=$slide['intro']?></p>
                <div class="gameinfo">
                    <div class="pro"><img src="<?=$slide['userinfo']['avatar']?>" alt="<?=$slide['userinfo']['name']?>"><?=$slide['userinfo']['name']?></div>
                    <div class="total">
                        <?=$slide['num_down'] && strpos($slide['num_down'],'预约')===false ? '<span class="download">'.$slide['num_down'].'</span>' : ''?>
                        <span class="review"><?=$slide['num_comment']?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php if ($nav) {?>
    <!-- 快捷菜单 -->
    <!-- <div class="quickNav">
        <ul>
            <?php foreach($nav as $v){?>
                <li><a href="<?=$v['url']?>"><span class="img"><img src="<?=$v['icon']?>" alt="<?=$v['title']?>"><?=$v['dot']?'<i class="dot"></i>':''?></span><?=$v['title']?></a></li>
            <?php }?>
        </ul>
    </div> -->
    <?php }?>
    <?php if ($new_game) {?>
    <!-- 特色入口 -->
    <!-- <div class="specEnter">
        <a href="<?=$new_game['url']?>">
            <img class="img" src="<?=$new_game['icon']?>" alt="<?=$new_game['tit_1']?>">
            <div class="con">
                <p><?=$new_game['tit_1']?></p>
                <p><?=$new_game['tit_2']?></span>
            </div>
            <span class="arrow"></span>
        </a>
    </div> -->
    <?php }?>
    <?php if ($custom && $custom['url']) {?>
    <div class="item">
        <a href="<?=$custom['url']?>">
            <div class="tit"><?=$custom['title']?></div>
            <div class="img">
                <img src="<?=$custom['icon']?>" alt="<?=$custom['title']?>">
            </div>
            <!-- <div class="desc">快来看看有哪些和足球有关的游戏吧~</div> -->
        </a>
    </div>
    <?php }?>
    <!-- item 合作 -->
    <div id="promgameDiv"></div>
    <script>
    var prom_game_url = '/app/hykb_web_wap/api/home_prom_game.php';
    $.post(prom_game_url,{},function(data){
        if (data) {
            $('#promgameDiv').html(data).show();
        } else {
            $('#promgameDiv').remove();
        }
    });
    </script>

    <!-- item 游戏 -->
    <div id="itemDiv">
    <?php 
    foreach ($itemsHtmls as $html) {
        echo $html;
    }
    ?>
    </div>

</div>

<div class="loadtips" id="loadtips">
    <span class="ico"></span><span>正在加载中...</span>
</div>
<div class="friLink" id="friLink">
    <dt>友情链接</dt>
<?php 
if ($indexinfo['links']) {
foreach($indexinfo['links'] as $k=>$v) {
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
            <li class="on"><a href="<?=$home_url?>"><i class="reco"></i>游戏推荐</a> </li>
            <li><a href="<?=$pai_url?>"><i class="rank"></i>排行榜</a></li>
            <li><a href="<?=$xq_url?>"><i class="spec"></i>新奇</a></li>
            <li><a href="https://m.bbs.3839.com/"><i class="bbs"></i>论坛</a></li>	
		</ul>
	</div>
</div>
<a id="gotop" class="gotop" style="display:none" onClick="go_to($('body'))">返回顶部</a>
<script src="<?=C::$cdn_path?>js/swiper-4.3.5.min.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/clipboard.min.js"></script>
<script src="<?=C::$cdn_path?>js/wxshare.js" type="text/javascript"></script>
<script type="text/javascript">
var share_title = '<?=$indexinfo['wap_title']?>',
    share_icon = (document.location.protocol=="https:"?"https:":"http:")+'//newsimg.5054399.com/hykb/static/hykb_web_wap/images/applogo.png',
    share_desc = '<?=$indexinfo['wap_des']?>';
var scrollTop = getScrollTop(),
    clientHeight = getClientHeight();

// 加载更多
var itemEnd = false;
var loadding = false;
function loadMore() {
    if(scrollTop + clientHeight > $('#loadtips').offset().top&&!itemEnd && !loadding) {     
        loadding = true;
        setTimeout(function(){
            $('#itemDiv').children('div').filter(':hidden').slice(0,10).show().find('img[lz_src]').attr('src',function(){return $(this).attr('lz_src')}).removeAttr('lz_src');
            if ($('#itemDiv').children('div').filter(':hidden').length==0) {
                itemEnd = true;
                $('#loadtips').hide();
            }
            loadding=false
        },1000)            
    }
}

$(window).scroll(function(){
    scrollTop = getScrollTop();
    // 顶部浮动
    if (scrollTop>=$('#headwp').offset().top) {
        $('#headwp>div.headArea').addClass('fixed');
    } else {
        $('#headwp>div.headArea').removeClass('fixed');
    }

    // 返回顶部按钮
    if (scrollTop>clientHeight) {
        $('#gotop').show();
    } else {
        $('#gotop').hide();
    }
    
    loadMore();
    
});



(function(){
    
    if (is_ios){
        loadIosPop();
    }

    // 换一换
    var hh_index = 0;
    var hh_length = $('#hh_hd').children('.item-game').length;
    $('#hh_btn').click(function(){
        hh_index++;
        if (hh_index == hh_length) hh_index = 0;
        $('#hh_hd').children('.item-game').hide().eq(hh_index).show().find('img[lz_src]').attr('src',function(){return $(this).attr('lz_src')}).removeAttr('lz_src');
        $('#hh_list').children().hide().eq(hh_index).show().find('img[lz_src]').attr('src',function(){return $(this).attr('lz_src')}).removeAttr('lz_src');
        return false;
    });

    // 外链弹窗
    $('#mainDiv a').click(function(){
        var href = $(this).attr('href');
        if(href && href.indexOf('//')!=-1){
            if ((href.indexOf('3839.com')==-1 && href.indexOf('onebiji.com')==-1) || href.indexOf('onebiji.com/hykb/card/')>-1) {
                toAppPop();
                return false;
            }
        }
    });

    $(document).click(function(e){
        var $target = $(e.target);
        if (!$target.closest('span.menu').length) {
            $('a.link').hide();
        }
    });

    // 分享
    wshare(share_title, share_desc, share_icon, window.location.href);

    // 滑动效果
    var swiper1 = new Swiper('.reco-hot', {
        slidesPerView: 'auto',
        freeMode: true
    });
    var swiper2 = new Swiper('.reco-update', {
        slidesPerView: 'auto',
        freeMode: true
    });
    var swiper3 = new Swiper('.reco-heji', {
        slidesPerView: 'auto',
        freeMode: true
    });
})();
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>