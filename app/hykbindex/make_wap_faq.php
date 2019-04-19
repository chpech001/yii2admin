<?php

require_once 'common.php';
ob_start();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>常见问题-好游快爆</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="<?=$path?>css/instyle_e1.css" type="text/css" rel="stylesheet">
<link rel="canonical" href="http://www.3839.com/faq.html">
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


<div class="dlarea">
   <a href="https://m.3839.com/"><div class="dllogo">好游快爆</div></a>
    <div class="fixbtn">
        <script>
            var ua = navigator.userAgent;
            var ua_info = {
                android:ua.match(/(Android)\s+([\d.]+)/i),
                ios:ua.match(/iphone|ipad|ipod/i)
            };
            if (ua_info['android']) {
                document.write('<a class="btn btn-az" href="http://d.4399.cn/Cj">立即下载</a>');
            }
        </script>
    </div>
</div>


<div class="area">

    <div class="areatit">常见问题</div>

    <dl class="faq">
        <?php
            $str = '';
            foreach ($index_setting['wd']['da'] as $t_key => $t_val) {
                $str .= '<dt>'.($i+1).'、'.$index_setting['wd']['wen'][$t_key].'</dt><dd>答：'.$t_val.'</dd>';
            }
            echo $str;
        ?>
    </dl>

    <script>
        var ua = navigator.userAgent;
        var ua_info = {
            android:ua.match(/(Android)\s+([\d.]+)/i),
            ios:ua.match(/iphone|ipad|ipod/i)
        };
        if (ua_info['android']) {
            document.write('<a class="inbtn" href="http://d.4399.cn/Cj">好游快爆APP</a>');
        }
    </script>

</div>

<script type="text/javascript" src="<?=$path?>js/footer_wap.js"></script>
<script type="text/javascript" src="http://newsimg.5054399.com/js/mtj.js"></script>
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

        $path = $_SERVER['DOCUMENT_ROOT'] . '/faq.html';

        $dir  = dirname($path);

        if (!is_dir($dir) || (!is_file($path) && !is_writable($dir)) || (is_file($path) && !is_writable($path))) {
            die('<font color="red">请联系技术，文件没有写入权限</font>');
        }

        file_put_contents($path,$str);
        echo '<a href="http://m.3839.com/faq.html">生成成功</a>';
    }
}

?>
