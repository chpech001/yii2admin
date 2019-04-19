<?php defined("APP_PATH") or die('Access denied'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>好游戏推荐_手机游戏评测-好游快爆app</title>
    <meta name="keywords" content="好游戏推荐,手机游戏评测,手游推荐">
    <meta name="description" content="好游快爆安利墙，汇聚了专业的游戏爱好者和开发者，为您推荐分享好游戏，提供真实客观的手机游戏评价，记录游戏的精彩瞬间，与您共建高品质游戏交流社区。">
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
    <div class="deta">共有<span><?=$return2['result']['wall_total']?></span>次安利成功上墙</div>
    <div class="menu">
        <a href="<?php echo Comm::get_url('commentwall','index',array('view_ishtml'=>1));?>" class="on">单款游戏</a>
        <i>|</i>
        <a href="<?php echo Comm::get_url('commentwall','anli_coll',array('view_ishtml'=>1));?>">游戏单</a>
    </div>
</div>
<div class="amwaybd">
    <!-- 单游戏 -->
    <div class="">
        <div class="amwayitem">
            <div class="hd">
                <a href="<?=Comm::get_url('game_detail','',array('id'=>$wall_list[0]['fid'],'view_ishtml'=>1))?>">
                    <img src="<?=$wall_list[0]['game']['icon']?>" alt="<?=$wall_list[0]['game']['title']?>">
                    <div class="">
                        <em class="name"><?=$wall_list[0]['game']['title']?></em>
                        <div class="tags">
                            <?php
                            foreach ($wall_list[0]['tags'] as $k=>$v){
                                if($k>=3){
                                   break;
                                }
                                echo '<span>'.$v['title'].'</span>';
                            }
                            ?>
                        </div>
                    </div>
                </a>
            </div>
            <div class="bd">
                <a href="http://m.3839.com/review/?pid=<?=$wall_list[0]['pid']?>&fid=<?=$wall_list[0]['fid']?>&cid=<?=$wall_list[0]['id']?>">
                <?php
                if(mb_strlen($wall_list[0]['content'],'utf-8')>200){

                    $v_content = str_replace('<br>', 'W', $wall_list[0]['content']);
                    $v_content= mb_substr($v_content, 0, 200,'utf-8');
                    $v_content = str_replace('W', '<br>', $v_content);

                    echo $v_content.'...';

                }else{

                    echo $wall_list[0]['content'];
                }
                ?>
                </a>
            </div>
            <div class="ft">
                <div class="from">
                    <div class="pro"><img src="<?=$wall_list[0]['avatar']?>" alt="<?=$wall_list[0]['username']?>"><?=$wall_list[0]['username']?></div>
                    <span class="stars"><?=$wall_list[0]['star']?>星</span><?php if($wall_list[0]['star']==4){ echo '推荐';}else if($wall_list[0]['star']==5){ echo '力荐';} ?>
                </div>
                <a class="follow " href="#">+关注</a>
            </div>
        </div>

        <div class="amwayuser">
            <div class="hd"><?=$return2['result']['users_title']?></div>
            <ul class="bd">
                <?php
                    foreach ($user_list as $k=>$v){

                        if($v['identity']==4){
                            $renz="auth";
                        }else{
                            $renz="";
                        }
                        ?>
                        <li>
                            <div class="img <?=$renz?>"><img lzimg="1" lz_src="<?=$v['avatar']?>" alt="<?=$v['username']?>"></div>
                            <em class="name"><?=$v['username']?></em>
                            <p class="info"><?=$v['identity_info']?$v['identity_info']:'游戏爱好者'?></p>
                            <a class="btn" href="#">+关注</a>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
        <?php
        foreach($wall_list as $k=>$v){

            $kz=$k+1;

            if($kz==1) continue;

            if($kz<=21){
                $show='';
                $lz=' lzimg="1" lz_src ';
            }else{
                $show='none';
                $lz=' lz_src ';
            }

            if($v['colleciton_id']){

                $tz_url=Comm::get_url('coll','detail',array('id'=>$v['fid'],'view_ishtml'=>1));
            }else{
                $tz_url=Comm::get_url('game_detail','',array('id'=>$v['fid'],'view_ishtml'=>1));
            }
            ?>
            <div class="amwayitem" style="display:<?=$show?>">
                <a href="<?=$tz_url?>">
                <div class="hd">
                    <img <?=$lz?>="<?=$v['game']['icon']?>" alt="<?=$v['game']['title']?>">
                    <div class="">
                        <em class="name"><?=$v['game']['title']?></em>
                        <div class="tags">
                            <?php
                            foreach ($v['tags'] as $key=>$val){

                                if($key>=3) break;
                                echo '<span>'.$val['title'].'</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                </a>
                <div class="bd">
                    <a href="http://m.3839.com/review/?pid=<?=$v['pid']?>&fid=<?=$v['fid']?>&cid=<?=$v['id']?>">
                    <?php
                    if(mb_strlen($v['content'],'utf-8')>200){

                        $v_content = str_replace('<br>', 'W', $v['content']);
                        $v_content= mb_substr($v_content, 0, 200,'utf-8');
                        $v_content = str_replace('W', '<br>', $v_content);

                        echo $v_content.'...';

                    }else{

                        echo $v['content'];
                    }
                    ?>
                    </a>
                </div>
                <div class="ft">
                    <div class="from">
                        <div class="pro"><img <?=$lz?>="<?=$v['avatar']?>" alt="<?=$v['username']?>"><?=$v['username']?></div>
                        <span class="stars"><?=$v['star']?>星</span><?php if($v['star']==4){ echo '推荐';}else if($v['star']==5){ echo '力荐';} ?>
                    </div>
                    <a class="follow " href="#">+关注</a>
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

<script language="javascript">
    <?php $tpage=ceil($kz/21);?>
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
                    var s=p*21;
                    var e=s+21;
                    if(e>=tnum){e=tnum;}
                    $(".loadtips").show();
                    setTimeout(function(){
                        $(".loadtips").hide();
                        for(var kn=s;kn<e;kn++){

                            $(".amwayitem").eq(kn).css("display","").find("img[lz_src]").attr("src",function(){
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
        if (scrollTop1>=$(".amwayitem").eq(3).offset().top) {
            $('#gotop').show();
        } else {
            $('#gotop').hide();
        }
    });

    $(".amwayitem .ft").click(function(){ pop('toapp2');return false;});
    $(".amwayuser ul").find("li").click(function(){ pop('toapp2');return false;});

</script>
<script src="<?=C::$cdn_path?>v2/js/fastclick.js"></script>
<script src="<?=C::$cdn_path?>v2/js/swiper-4.3.5.min.js?v=22"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>