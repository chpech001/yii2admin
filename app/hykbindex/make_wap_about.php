<?php

require_once 'common.php';
ob_start();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>关于我们-好游快爆</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="<?=$path?>css/instyle_e1.css" type="text/css" rel="stylesheet">
<link rel="canonical" href="http://www.3839.com/about.html">
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
    <div class="areatit">关于我们</div>
    <div class="areabd">
	  好游快爆，隶属于厦门纯游互动科技有限公司，搭建广大开发者和千万游戏爱好者沟通交流的桥梁。<br/>
     我们一起品鉴精品好游，抢先体验内测新游，发现好玩、新奇、魔性、二次元手游，关注排行榜掌握手游市场动向。<br/>
     发表游戏评价，共建高品质游戏交流社区，与千万游戏爱好者交流心得，与开发者直接沟通、反馈游戏建议BUG。<br/>
    这里还有一手新游爆料信息、体验服提醒、实用攻略、游戏工具、有趣视频，助您走向游戏发烧友之路。	 			
	</div>
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

        $path = $_SERVER['DOCUMENT_ROOT'] . '/about.html';

        $dir  = dirname($path);

        if (!is_dir($dir) || (!is_file($path) && !is_writable($dir)) || (is_file($path) && !is_writable($path))) {
            die('<font color="red">请联系技术，文件没有写入权限</font>');
        }

        file_put_contents($path,$str);
        echo '<a href="http://m.3839.com/about.html">生成成功</a>';
    }
}

?>

