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
<link href="<?=$path?>v2/css/style_e2.css?1" type="text/css" rel="stylesheet">
<script type="text/javascript" src="http://newsimg.5054399.com/etweixin/v2/js/zepto.min.js"></script>

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
<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_URL, 'http://news.4399.com/html/single_hykb_wap_index.html?r='.time());
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$content = curl_exec($ch);
curl_close($ch);
$content = iconv("GBK", "UTF-8//IGNORE", $content);
// $content = file_get_contents("./single_hykb_wap.html");

$content = str_replace(array('{log_version_num}', '{update_year}'),array($log_last['version_num'], $log_last['update_year'].'.'.$upt),$content);

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
    <script type="text/javascript" src="<?=$path?>js/footer_wap.js"></script>
</div>

<div class="dlarea out" style="display:none">
    <div class="dllogo">
        <img src="http://newsimg.5054399.com/uploads/allimg/171010/397_1048593372.png" alt="好游快爆APP" />
        <em>好游快爆 - 分享好游戏</em>
        <p>一个分享新鲜精品游戏的APP</p>
    </div>
    
    <div class="fixbtn">
        <script>
            var ua = navigator.userAgent;
            var ua_info = {
                android:ua.match(/(Android)\s+([\d.]+)/i),
                ios:ua.match(/iphone|ipad|ipod/i)
            };
            if (!ua_info['ios']) {
                document.write('<a class="btn btn-az" href="http://d.4399.cn/Cj" rel="external nofollow">立即下载</a>');
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
