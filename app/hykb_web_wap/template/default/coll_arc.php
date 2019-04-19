<?php defined("APP_PATH") or die('Access denied'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$arc_list['title']?>_好游快爆-分享新鲜好游戏</title>
    <meta name="keywords" content="">
    <meta name="description" content="<?=$arc_list['title']?>游戏单，是玩家制作的游戏单，分享游戏乐趣。赶快来好游快爆，制作属于你的游戏单">
    <link rel="canonical" href="https://www.3839.com/heji/<?=$id?>.html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="full-screen" content="yes" />
    <meta name="x5-fullscreen" content="true" />
    <link href="<?=C::$cdn_path?>v2/css/novel.min.css" type="text/css" rel="stylesheet">
    <link href="<?=C::$cdn_path?>v2/css/comment.min.css" type="text/css" rel="stylesheet">
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
    <li><a href="<?php echo Comm::get_url('coll','hot',array('view_ishtml'=>1));?>">全部游戏单</a></li>
    <li><span><?=$arc_list['title']?></span></li>
</ul>

<div class="novel-hd">
    <div class="cover" style="background-image:url(<?=$arc_list['icon']?>)">
        <div class="cover-mask"></div>
    </div>
    <div class="inner">
        <div class="view">
            <div class="img">
                <img src="<?=$arc_list['icon']?>" alt="<?=$arc_list['title']?>">
            </div>
            <div class="con">
                <p class="tit"><?=$arc_list['description']?></p>
                <div class="user2">
                    <div class="pro">
                        <img src="<?=$arc_list['userinfo']['avatar']?>" alt="<?=$arc_list['userinfo']['name']?>"><?=$arc_list['userinfo']['name']?>
                    </div>
                    <a class="feed" href="#">+关注</a>
                </div>
            </div>
        </div>
        <div class="deta">
            <li><a id="share_link" data-role="share"><img src="<?=C::$cdn_path?>v2/images/illus/glist-in-it1.png" alt="" >分享</a></li>
            <li><img src="<?=C::$cdn_path?>v2/images/illus/glist-in-it2.png" alt="">收藏</li>
            <li onClick="go_to2($('.glist-comment'));return false;"><img src="<?=C::$cdn_path?>v2/images/illus/glist-in-it3.png" alt=""><span id="pl_num">评价</span></li>
            <li><img src="<?=C::$cdn_path?>v2/images/illus/glist-in-it4.png" alt=""><?=$arc_list['good']?$arc_list['good']:'点赞'?></li>
        </div>
    </div>
</div>

<div class="novel-list">
    <ul class="cf">
        <?php
        foreach ($arc_list['data'] as $k=>$v){

            $game_url=Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
            ?>
            <li>
                <div class="cf">
                    <a href="<?=$game_url?>">
                        <img class="img" lzimg=1 lz_src="<?=$v['icon']?>" alt="<?=$v['title']?>">
                        <div class="con">
                            <em class="name"><?=$v['title']?></em>
                            <div class="star">
                                <div class="starbar">
                                    <span style="width: <?=$v['star']*10?>%"></span>
                                </div>
                                <span class="score"><?=$v['star']>0?$v['star'].'分':'暂无评分'?></span>
                            </div>
                            <p class="info"><?=$v['num_size_lang']?></p>
                        </div>
                    </a>
                   <?php
                        if ($v['downinfo']['status']==1) {
                            echo '<a class="btn green" href="'.$game_url.'">下载</a>';
                        } else if ($v['downinfo']['status']==4) {
                            echo '<a class="btn yellow" href="'.$game_url.'">预约</a>';
                        } else if ($v['downinfo']['status']==3 || $v['downinfo']['status']==5) {
                            echo '<a class="btn green" href="'.$game_url.'">敬请期待</a>';
                        } else if ($v['downinfo']['status'] == 6) {
                            echo '<a class="btn green" href="'.$game_url.'">查看详情</a>';
                        }
                   ?>
                </div>
                <?php
                if($v['remarks']) {

                    echo '<p class="desc"><span class="own">作者说</span>'.$v['remarks'].'</p>';

                }else if($v['desc']){

                    echo '<p class="desc">'.$v['desc'].'</p>';
                }
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
</div>


<!-- comments -->
<div class="glist-comment">
    <div id="commentComm"></div>
</div>


<script>// 评论技术配置
    var pid = 2;//项目ID
    var fid = <?=$id?>;//内容ID
    var fscore = '8.0';//文章评分
    var uid=<?=$arc_list['userinfo']['id']?>;
    var apiStr="//newsapp.5054399.com/cdn/comment/view_v2-ac-json-pid-{pid}-fid-{fid}-p-{pages}-page_num-{numpage}-reply_num-{numreply}-order-{order}-htmlsafe-1-urltype-1-audit-1.htm";
    var comInit = {
        //下载弹窗提示
        downTips: function () {
           // alert("请下载好游快爆")
            //pop('toapp2');
            pop('comment');
        },
        //设置评论数
        comTotal: function (num) {
            //console.log(num);

            $("#pl_num").html(num);
        },

        //通用评论
        comComm: function () {
            comComm.$mount("#commentComm");
        }
    }
     var tempTime;
     function load(){
       if(window.comComm){
         clearInterval(tempTime);
         comInit.comComm();
       }else{
         tempTime=setInterval(load, 500);
       }
     }
     load();
</script>

<!--
<div class="loadtips">
    <span class="ico"></span><span>正在加载中...</span>
</div>
<div class="loadtips">
    <span>别撩啦，到底啦~ /(//•/ω/•//)//</span>
</div>
     -->

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

<script src="<?=C::$cdn_path?>js/detail.js" type="text/javascript"></script>

<script src="<?=C::$cdn_path?>v2/js/chunk-vendors.js?v=<?=CDN_V?>"></script>
<script src="<?=C::$cdn_path?>v2/js/app.js?v=<?=CDN_V?>"></script>
<script src="<?=C::$cdn_path?>v2/js/fastclick.js"></script>
<script src="<?=C::$cdn_path?>v2/js/swiper-4.3.5.min.js?v=22"></script>
<script>
    $(function() {
        FastClick.attach(document.body);

        $(".user2").click(function(){ pop('toapp2');return false;});
        $(".deta li").eq(1).click(function(){ pop('toapp4');return false;});
        $(".deta li").eq(3).click(function(){ pop('toapp2');return false;});
        $(".btn-add-glist").click(function(){ pop('toapp4');return false;});
    });

    var share_title = '<?=$arc_list['share_info']['title']?>',
        share_icon = (document.location.protocol=="https:"?"https:":"http:")+'<?=Comm::reLink($arc_list['share_info']['icon'])?>',
        share_desc = '<?=$arc_list['share_info']['desc']?>';
</script>
<script src="<?=C::$cdn_path?>js/wxshare.js" type="text/javascript"></script>

<script>
    (function () {

        // 分享
        wshare(share_title, share_desc, share_icon, window.location.href);

        $('#share_link').attr('data-share-title', share_title);
        $('#share_link').attr('data-share-url', window.location.href);
        $('#share_link').attr('data-share-img', share_icon);
        $('#share_link').attr('data-share-description',  share_desc);
        document.write('<script type="text/javascript" src="//newsimg.5054399.com/etweixin/v2/js/zepto.min.js"><\/script>');
        document.write('<script type="text/javascript" src="//newsimg.5054399.com/etweixin/v2/js/jshare.js"><\/script>');

    })();
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>