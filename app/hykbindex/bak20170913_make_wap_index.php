<?php

require_once 'common.php';

$upt = str_replace('-','.',$log_last['update_month']);

ob_start();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title><?=$index_setting['waptitle']?></title>
<meta name="description" content="<?=$index_setting['wapdes']?>">
<meta name="keywords" content="<?=$index_setting['wapkeywords']?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="<?=$path?>css/style.css?v1" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
<link rel="canonical" href="http://www.3839.com/">

<script>
    setfontsize();
    window.onresize=function(){setfontsize()};
    function setfontsize(){
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 750){
            deviceWidth = 750;
        }
        document.documentElement.style.fontSize = (deviceWidth / 7.5).toFixed(2) + "px";
    }
</script>



<div class="pt1">
    <div class="pt1it1"></div>

    <div class="f40">分享好游戏 一起推爆款</div>
    <script>
        var version = "<?=$log_last['version_num']?>";
        var uptime  = "<?=$log_last['update_year'].'.'.$upt?>";
        var ua = navigator.userAgent;
        var ua_info = {
            android:ua.match(/(Android)\s+([\d.]+)/i),
            ios:ua.match(/iphone|ipad|ipod/i)
        };
        if (!ua_info['ios']) {
            document.write('<div class="dlbtn"><a class="btn btn-az" href="http://d.4399.cn/Cj">好游快爆安卓版下载</a></div><div class="dltip">版本：V'+version+' | 更新时间：'+uptime+'</div>');
        } else {
            document.write('<div class="dlbtn"><span class="btn btn-ip" >敬请期待</span></div><div class="dltip">暂无IOS版下载，可用安卓手机下载体验</div>');
            $('.dlbtn,.dltip').click(function(){
                alert('暂无IOS版下载，可用安卓手机下载体验');
                return false;
            });
        }
    </script>
    <img class="pt1img" src="<?=$path?>images/pt1img.png?v1" alt="好游快爆" />
</div>
<div class="pt2">
    <div class="f56">每天推荐精选好游</div>
    <div class="f40">新奇  好玩  魔性  狂赞</div>
</div>
<div class="pt3">
    <div class="f56">全网最强手游攻略库</div>
    <div class="f40">原创  精品  秘籍  成神</div>
</div>
<div class="pt4">
    <div class="f56">头条资讯  精彩视频</div>
    <div class="f40">有趣 独家  快讯   专栏</div>
</div>
<div class="pt5">
    <div class="f56">几十款实用辅助工具</div>
    <div class="f40">方便  好用  高效  靠谱</div>
</div>


<div class="ftarea">
    <div class="friwp">
        <?php
            $str = '';
            foreach ($index_setting['wapyl']['title'] as $t_key => $t_val) {
                $str .= '<a href="'.$index_setting['wapyl']['links'][$t_key].'" target="_blank">'.$t_val.'</a>| ';
            }
            $str = rtrim(trim($str),'|');
            echo $str;
        ?>
    </div>
    <script type="text/javascript" src="<?=$path?>js/footer_wap.js"></script>
</div>

<div class="dlarea out" style="display:none">
    <div class="dllogo">
        <img src="<?=$path?>images/logo.png" alt="好游快爆APP" />
        <em>好游快爆 - 分享好游戏</em>
        <p>一个分享精品游戏的APP</p>
    </div>
    <div class="fixbtn">
        <script>
            var ua = navigator.userAgent;
            var ua_info = {
                android:ua.match(/(Android)\s+([\d.]+)/i),
                ios:ua.match(/iphone|ipad|ipod/i)
            };
            if (!ua_info['ios']) {
                document.write('<a class="btn btn-az" href="http://d.4399.cn/Cj">立即下载</a>');
            } else {
                document.write('<a class="btn btn-ip">敬请期待</a>');
            }
        </script>
    </div>
</div>

<script type="text/javascript" src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
<script type="text/javascript">
    (function(){
        var ua = navigator.userAgent,
            is_ios = ua.match(/iphone|ipad|ipod/i);
        if (!is_ios) {
            var $dlarea = $('.dlarea');
            $dlarea.show();
            $(window).on("scroll", function () {
                var srcheight = $(this).scrollTop(),
                    itheight = $('.pt1').height()/2;
                srcheight < itheight ? $dlarea.addClass("out") : $dlarea.removeClass("out");
            });
        } else {
            $('body').css('padding-bottom','0');
        }
    })();
</script>
<script type="text/javascript" src="http://newsimg.5054399.com/js/mtj.js"></script>
<?php
$sc = intval($_GET['sc']);

if ( $sc == 1 ) {
    $str = ob_get_contents();
    ob_clean();
    if (strlen($str) > 500) {

        $path = $_SERVER['DOCUMENT_ROOT'] . '/index.html';

        $dir  = dirname($path);

        if (!is_dir($dir) || (!is_file($path) && !is_writable($dir)) || (is_file($path) && !is_writable($path))) {
            die('<font color="red">请联系技术，文件没有写入权限</font>');
        }

        file_put_contents($path,$str);
        echo '<a href="http://m.3839.com">生成成功</a>';
    }
}

?>