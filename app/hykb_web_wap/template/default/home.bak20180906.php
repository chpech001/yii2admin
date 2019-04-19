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
<meta name="full-screen" content="yes" />
<meta name="x5-fullscreen" content="true" />
<link href="<?=C::$cdn_path?>css/style.min.css" type="text/css" rel="stylesheet">
<script src="<?=C::$cdn_path?>js/common.js"></script>
<script src="//newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<div class="downArea" id="downArea">
    <span class="btn-hide" onclick="$(this).parent().hide()">关闭</span>
    <a href="<?=$GLOBALS['_index_gw']?>"><img class="img" src="<?=C::$cdn_path?>images/applogo.png" alt="好游快爆"></a>
    <div class="con">
        <a href="<?=$GLOBALS['_index_gw']?>">
        <em>好游快爆</em>
        <span>一个分享精品游戏的APP</span>
        </a>
    </div>
    <script type="text/javascript">
    if (is_ios) {
        document.write('<a class="btn-down" onclick="pop2(\'pop_ios\')">马上下载</a>');
    } else {
        document.write('<a class="btn-down" href="//d.4399.cn/Cj" rel="external nofollow">马上下载</a>');
    }
    </script>
</div>

<?php include 'common/header.php';?>
<div id="mainDiv">
    <!-- 今日推荐 -->
    <div class="recoItem">
        <a href="<?=$slide['url']?>">
            <img class="img" src="<?=$slide['icon']?>" alt="<?=$slide['title']?>">
            <span class="mask"></span>
            <span class="tag"><?=$slide['tag']?></span>
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

<div class="moregame" id="moregame">
    <img src="<?=C::$cdn_path?>images/more-game.png" alt="">
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
    <p>本公司产品适合10周岁以上玩家使用 <a href="//m.3839.com/contact.html" rel="external nofollow">未成年人家长监护</a></p>
    <p><a rel="external nofollow" href="http://www.miitbeian.gov.cn/">ICP证：闽ICP14017048号</a>  <a rel="external nofollow" href="http://sq.ccm.gov.cn/ccnt/sczr/service/business/emark/toDetail/65df7e24611047c091053caa546be9f9">闽网文[2018] 0806-043号</a></p>
    <p>&copy; 2009-2018  3839.com All Rights Reserved.</p>
</div>
<a id="gotop" class="gotop" style="display:none" onclick="go_to($('body'))">返回顶部</a>
<script src="<?=C::$cdn_path?>js/swiper-4.3.5.min.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/clipboard.min.js"></script>
<script type="text/javascript">
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