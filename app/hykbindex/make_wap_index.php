<?php
require_once 'common.php';
$upt = str_replace('-','.',$log_last['update_month']);
ob_start();
?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$index_setting['waptitle']?></title>
    <meta name="description" content="<?=$index_setting['wapdes']?>">
    <meta name="keywords" content="<?=$index_setting['wapkeywords']?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta content="false" id="twcClient" name="twcClient" />
    <link rel="stylesheet" type="text/css" href="http://newsimg.5054399.com/hykb/wap/v3/css/style_e1.css?v1">
    <link rel="canonical" href="http://www.3839.com/">
    <script type="text/javascript">
        function init_viewport() {
            var dpr = window.devicePixelRatio;
            var deviceWidth = document.documentElement.clientWidth;
            document.documentElement.style.fontSize = deviceWidth / 7.5 + "px";
            if(deviceWidth > 750){
                deviceWidth = 750;
            }
            document.documentElement.style.fontSize = (deviceWidth / 7.5).toFixed(2) + "px";
        }
        init_viewport();
        window.onresize=init_viewport;
    </script>
</head>
<body>
<div class="tp-video" style="display:none;">
    <video src="http://video.5054399.com/video/sjyx/app_gonglue/kuaibao/haoyou/20181108hykb.mp4" controls="controls" id="media">
        您的浏览器不支持 video 标签。
    </video>
    <a class="v-close"></a>
    <script type="text/javascript">
        (function() {
            var ua = navigator.userAgent,
                is_ios = ua.match(/iphone|ipad|ipod/i);
            if(!is_ios){
                document.write('<a class="v-load" href="http://d.4399.cn/Cj" rel="external nofollow">立即下载<\/a>');
            }
        })();
    </script>
</div>
<div class="fixed cf out" style="display:none">
    <a href="###" class="fix-ico"></a>
    <a href="http://d.4399.cn/Cj" class="fix-down" rel="external nofollow">马上下载</a>
    <div class="fix-info">
        <img src="http://newsimg.5054399.com/hykb/wap/v3/images/fix-logo.png" alt="好游快爆">
        <p>好游快爆 - 分享好游戏</p>
        <em>一个分享精品游戏的APP</em>
    </div>
</div>
<?php
$content = curl_get('http://news.4399.com/html/single_hykb_wap_index_v2.html?r='.time());
$content = iconv("GBK", "UTF-8//IGNORE", $content);
$content = str_replace(array('{log_version_num}', '{update_year}'), array($log_last['version_num'], $log_last['update_year'].'.'.$upt), $content);
echo $content;
?>
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
    <script type="text/javascript" src="//newsimg.5054399.com/hykb/wap/js/footer_wap.js"></script>
</div>
<script type="text/javascript" src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
<script type="text/javascript">
    (function(){
        var ua = navigator.userAgent,
            is_ios = ua.match(/iphone|ipad|ipod/i);
        if (!is_ios) {
            var fixed = $('.fixed');
            fixed.show();
            var is_close_ad = 0;
            $(window).on("scroll", function () {
                if(!is_close_ad){
                    var srcheight = $(this).scrollTop(),
                        itheight = ($('.info').height() + $('.step').height())/2;
                    srcheight < itheight ? fixed.addClass("out") : fixed.removeClass("out");
                }
            });
            $('.fix-ico').click(function(){
                is_close_ad = 1;
                fixed.addClass("out");
                $('body').css('padding-bottom', '0px');
                return false;
            });
        } else {
            document.write('<script type="text/javascript" src="http://newsimg.5054399.com/etweixin/v2/js/zepto.min.js"><\/script>');
            document.write('<script type="text/javascript" src="http://newsimg.5054399.com/etweixin/v2/js/jshare.js"><\/script>');
            document.write('<script type="text/javascript" src="http://newsimg.5054399.com/haoyoukb/js/jquery_iwgcDialog.js"><\/script>');
            $('body').css('padding-bottom','0');
            var clipboard = new Clipboard('.ppbtn');
            clipboard.on('success', function(e) {
                if (e.text) {
                    $('.copyinfo').show();
                    cShow();
                }
            });
            clipboard.on('error', function(e) {
                var text = e.text;
                if (text) {
                    window.prompt("你的浏览器不支持此复制功能,请直接长按进行复制", text);
                }
            });
            $('.btns-ios').click(function(){
                $.iwgcDialog({id:'ios_dia',close_id:'ios_dia_close'});
                return false;
            });
        }
        var Media = document.getElementById("media");
        var h=null;
        $(".i-video").click(function(){
            $(".tp-video").show();
            h=-parseInt($(".tp-video video").height()/2)+"px";
            $(".tp-video video").css("margin-top",h);
            Media.play();
            return false;
        });

        $(".v-close").click(function(){
            $(".tp-video").hide();
            Media.pause();
            return false;
        });
        function cShow(){
            cClear();
            $('.copyinfo').show();
            setTimeout(function(){
                $(".copyinfo").hide();
            },2000);
        }
        function cClear(){
            clearTimeout(cShow)
        }
    })();
</script>
<script src="//newsimg.5054399.com/hykb/static/hykb_web_wap/js/wxshare.js?v1" type="text/javascript"></script>
<script type="text/javascript">
var share_title = '<?=$index_setting['waptitle']?>',
    share_desc = '<?=$index_setting['wapdes']?>',
    share_icon = (document.location.protocol=="https:"?"https:":"http:")+'//newsimg.5054399.com/hykb/wap/v3/images/share_img.jpg';
    wshare(share_title, share_desc, share_icon, window.location.href);
</script>
<script type="text/javascript" src="http://newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>
<?php
$html = ob_get_contents();
ob_clean();

$html = convertHttps($html);
echo $html;

$sc = intval($_GET['sc']);
if ( $sc == 1 ) {
    $str = ob_get_contents();
    ob_clean();
    if (strlen($str) > 500) {
        header('content-type:text/html;charset=utf-8');
        $path = $_SERVER['DOCUMENT_ROOT'] . '/index.html';

        $dir  = dirname($path);
        if (!is_dir($dir) || (!is_file($path) && !is_writable($dir)) || (is_file($path) && !is_writable($path))) {
            die('<font color="red">请联系技术，文件没有写入权限</font>');
        }

        file_put_contents($path,$str);
        echo '<a href="/">生成成功</a>';
    }
}
?>
