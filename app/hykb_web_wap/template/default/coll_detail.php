<?php defined("APP_PATH") or die('Access denied'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<?php if($type=='hot'){?>
    <title>热门<?=$catename?>游戏合集_热门<?=$catename?>手游推荐-好游快爆app</title>
    <meta name="keywords" content="热门<?=$catename?>游戏,热门<?=$catename?>游戏合集,热门<?=$catename?>手游推荐">
    <meta name="description" content="好游快爆游戏单为您提供热门<?=$catename?>游戏合集、向您推荐好玩的热门<?=$catename?>类手游。来好游快爆，制作属于你自己的的游戏单。">
	<?php }else{?>
	<title>最新<?=$catename?>游戏合集_最新<?=$catename?>手游推荐-好游快爆app</title>
    <meta name="keywords" content="最新<?=$catename?>游戏,最新<?=$catename?>游戏合集,最新<?=$catename?>手游推荐">
    <meta name="description" content="好游快爆游戏单为您提供最新<?=$catename?>游戏合集、向您推荐好玩的最新<?=$catename?>类手游。来好游快爆，制作属于你自己的的游戏单">
	<?php }?>
    <link rel="canonical" href="https://www.3839.com/heji/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="full-screen" content="yes" />
    <meta name="x5-fullscreen" content="true" />
    <link href="<?=C::$cdn_path?>v2/css/style.min.css" type="text/css" rel="stylesheet">
    <script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<?php include_once("baidu_js_push.php") ?>

<div class="headwp" id="headwp">
    <div class="headArea">
        <a href="//m.3839.com/wap.html"><span class="applogo">好游快爆</span></a>
        <script type="text/javascript">
            if (is_ios) {
                document.write('<a onclick="pop2(\'pop_ios\')"><span class="downtip"></span></a>')
            } else {
                document.write('<a href="//d.4399.cn/Q7" rel="external nofollow"><span class="downtip"></span></a>');
            }
        </script>
        <a class="link-sch" href="//m.3839.com/search/">搜索</a>
        <a class="btn-add-glist" href="#">添加游戏单</a>
    </div>
</div>

<ul class="breadcrumb">
    <li><a href="../wap.html">首页</a></li>
    <li><span>全部游戏单</span></li>
</ul>

<div class="glist-bn">
    <img src="<?=$head_xx[0]['icon']?>" alt="">
    <p><?=$head_xx[0]['description']?></p>
</div>

<div class="glist-hd">
    <a class="glist-sel" href="<?php echo Comm::get_url('coll','tags',array('view_ishtml'=>1,'type'=>$type));?>" target="_self"><?=$catename?></a>
    <div class="glist-sort">
        <a class="<?php if($type=='hot'){echo 'on';}?>" href="<?php echo Comm::get_url('coll','hot',array('view_ishtml'=>1,'id'=>$id));?>" target="_self">热门</a>
        <a class="<?php if($type=='recent'){echo 'on';}?>" href="<?php echo Comm::get_url('coll','recent',array('view_ishtml'=>1,'id'=>$id));?>" target="_self">近期</a>
    </div>
</div>

<div class="glist-bd">
    <div class="glist" >
        <?php

        foreach ($gamelist as $k=>$v){

            $kz2=$k+1;

            if($kz2<=20){
                $show='';
                if($kz2<=2){ $lz=' src '; }
                else{ $lz=' lzimg="1" lz_src '; }

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

<script type="text/javascript" src="//newsimg.5054399.com/hykb/wap/js/footer_wapinner.js"></script>

<div class="downArea fixed-bottom" id="bomDownDiv">
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
            document.write('<a class="btn-down" onclick="pop2(\'pop_ios\')">马上下载</a>')
        } else {
            document.write('<a class="btn-down" href="//d.4399.cn/Q7" rel="external nofollow">马上下载</a>');
        }
    </script>
</div>

<script src="<?=C::$cdn_path?>v2/js/fastclick.js"></script>
<script src="<?=C::$cdn_path?>v2/js/swiper-4.3.5.min.js?v=22"></script>
<script src="<?=C::$cdn_path?>v2/js/masonry.min.js"></script>
<script>
    $(function() {

        FastClick.attach(document.body);

        $(".info").click(function(){ pop('toapp2');return false;});

        $(".btn-add-glist").click(function(){ pop('toapp4');return false;});

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
</script>

<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>