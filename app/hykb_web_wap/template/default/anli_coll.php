<?php defined("APP_PATH") or die('Access denied'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>游戏合集推荐_好玩的手游合集-好游快爆app</title>
    <meta name="keywords" content="游戏单推荐,游戏合集推荐,好玩的手游合集">
    <meta name="description" content="好游快爆安利墙，汇聚了专业的游戏爱好者和开发者，为您推荐不同玩法风格的游戏合集，分享最受欢迎的游戏单。更多好玩的手游合集推荐，尽在好游快爆app。">
    <link rel="canonical" href="https://www.3839.com/anli/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="full-screen" content="yes" />
    <meta name="x5-fullscreen" content="true" />
    <link href="<?=C::$cdn_path?>v2/css/style.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
    <script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<?php include_once("baidu_js_push.php") ?>
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
<!-- banner -->
<div class="amwaybn">
    <em>安利墙</em>
    <p>发现更多好玩的游戏</p>
</div>
<div class="amwayhd">
    <div class="deta">玩家共安利<span><?=$total_num?></span>个游戏单</div>
    <div class="menu">
        <a href="<?php echo Comm::get_url('commentwall','index',array('view_ishtml'=>1));?>">单款游戏</a>
        <i>|</i>
        <a href="<?php echo Comm::get_url('commentwall','anli_coll',array('view_ishtml'=>1));?>" class="on">游戏单</a>
    </div>
</div>
<div class="amwaybd">

    <!-- 单游戏 -->
    <div class="glist">
        <?php
        foreach ($heji_list as $k=>$v){

            $kz2=$k+1;

            if($kz2<=20){
                $show='';
                $lz=' lzimg="1" lz_src ';
            }else{
                $show='none';
                $lz=' lz_src ';
            }
            $hj_url=Comm::get_url('coll','detail',array('id'=>$v['id'],'view_ishtml'=>1));
            ?>
            <div class="it" style="display:<?=$show?>">
                <div class="img"><a href="<?=$hj_url?>"><img <?=$lz?>="<?=$v['icon']?>" alt="<?=$v['title']?>"></a></div>
                <div class="con">
                    <ul class="lt">
                        <?php
                        foreach ($v['gameinfo'] as $key=>$val){
                            if($key>=5){
                                echo '<li class="num"><a href="'.$hj_url.'">'.$v['num'].'</a></li>';
                                break;
                            }
                            $game_url=Comm::get_url('game_detail','',array('id'=>$val['id'],'view_ishtml'=>1));

                            echo '<li><a href="'.$game_url.'"><img '.$lz.'="'.$val['icon'].'" alt="'.$val['title'].'下载"></a></li>';
                        }
                        ?>
                    </ul>
                    <div class="desc"><a href="<?=$hj_url?>"><?=$v['title']?></a></div>
                    <div class="info">
                        <div class="user"><img <?=$lz?>="<?=$v['userinfo']['avatar']?>" alt="<?=$v['userinfo']['nickname']?>"><?=$v['userinfo']['nickname']?></div>
                        <span class="vote"><?=$v['good']?$v['good']:''?></span>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="loadtips" style="display:none">
    <span class="ico"></span><span>正在加载中...</span>
</div>
<a id="gotop" class="gotop" style="display:none" onClick="go_to($('body'))">返回顶部</a>
<!--
<div class="loadtips">
    <span>别撩啦，到底啦~ /(//•/ω/•//)//</span>
</div>
-->
<div class="footCopy" id="footer">
    <script src="http://newsimg.5054399.com/hykb/wap/js/footer_wap.js"></script>
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
            <li><a href="<?=$xq_url?>"><i class="spec"></i>新奇</a></li>
            <li class="on"><a><i class="wall"></i>安利墙</a></li>
            <li><a href="https://m.bbs.3839.com/"><i class="bbs"></i>论坛</a></li>
        </ul>
    </div>
</div>

<script src="<?=C::$cdn_path?>v2/js/fastclick.js"></script>
<script src="<?=C::$cdn_path?>v2/js/swiper-4.3.5.min.js?v=22"></script>
<script src="<?=C::$cdn_path?>v2/js/masonry.min.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });

    $(window).scroll(function(){
        var scrollTop1 = getScrollTop();
        // 顶部浮动
        if (scrollTop1>=$('#headwp').offset().top) {
            $('#headwp>div.headArea').addClass('fixed');
        } else {
            $('#headwp>div.headArea').removeClass('fixed');
        }
        if (scrollTop1>=$(".glist .it").eq(4).offset().top) {
            $('#gotop').show();
        } else {
            $('#gotop').hide();
        }
    });

    $(".info").click(function(){ pop('toapp2');return false;});
</script>

<script language="javascript">

    function setfontsize() {
        var deviceWidth = window.document.documentElement.clientWidth;
        deviceWidth > 750 && (deviceWidth = 750);
        return (deviceWidth*.26 / 7.5)
    }

    /*瀑布流初始化设置*/
    var $grid = $('.glist').masonry({
        itemSelector : '.it',
        gutter:setfontsize()
    });

    <?php $tpage=ceil($kz2/20);?>
    var p=1;
    var cscroll=1;
    var tpage=<?=$tpage?>;
    var tnum=<?=$kz2?>;
    if(tpage>1){
        $(window).scroll(function(){

            $grid.masonry('layout');

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

                            $(".it").eq(kn).css("display","").find("img[lz_src]").attr("src",function(){
                                var src=$(this).attr("lz_src");
                                $(this).removeAttr("lz_src");
                                return src;
                            });
                        }
                        p=p+1;
                        if(p>=tpage){cscroll=0;}else{cscroll=1;}
                        $grid.masonry();
                    }, 2000);
                }
            }
        })
    }
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>