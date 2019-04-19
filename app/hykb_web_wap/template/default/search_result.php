<?php 
defined('APP_PATH') or exit('Access Denied');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>搜索</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link href="<?=C::$cdn_path?>css/search.min.css" type="text/css" rel="stylesheet">
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
    <script src="<?=C::$cdn_path?>js/common.js"></script>
</head>
<body>
<div class="headArea">
    <a class="link-back" onclick="history.go(-1)">返回</a>
    <form id="searchForm" action="<?=$GLOBALS['_search_index']?>">
    <div class="so-area">
        <input type="hidden" name="ac" value="search_result">
        <input type="text" placeholder="请输入想要查找的游戏" name="q" value="<?=$q?>" autocomplete="off">
        <span class="cls"<?=$q!=''?'':' style="display:none"'?>></span>
    </div>
    <a class="schbtn" onclick="$('#searchForm').submit()">搜索</a>
    </form>
    <script>searchForm($('#searchForm'),'请输入想要查找的游戏')</script>
</div>
<?php
if ($data) {
?>
<!-- 游戏列表 -->
<div class="game-list">
    <ul class="cf" id="game_list">       
        <?=$str?>
    </ul>
</div>
    <?php if (!$result['nextpage']) {?>
    <div class="loadtips" id="loadtips">
        我是有底线的~~~
    </div>
    <?php } elseif ($result['nextpage']) {?>
    <div class="loadtips" id="loadtips">
        <span class="ico"></span><span>正在加载中...</span>
    </div>
    <script src="<?=C::$cdn_path?>js/dragLoad.js"></script>
    <script>
    // 往下拉，加载更多
    function packageDom(data){
        return data;
        // var dom = "";
        // for (n in data) {
        // }
        // return dom;
    }
    function formatData(data){
        return data;
    }
    function noMoreHandle(){
        $('#loadtips').html("我是有底线的~~~");
    }

    var list_ul = $('#game_list');
    list_ul.dragLoad({'url':'?m=search&ac=search_result&is_ajax=1','loadingDom':$('#loadtips'),'searchWord':'<?=$q?>','callbackFun':{'packageDom':packageDom,'formatData':formatData,'noMoreHandle':noMoreHandle}});
    </script>
    <?php }?>

<?php
} else {
?>
<div class="nodata">
    <div class="img">
        <img src="<?=C::$cdn_path?>images/illus/nodata.png" alt="">
    </div>
    <?php if ($q1!=''){?>
    <p class="txt">未搜索到与“<span><?=$q1?></span>”相关游戏</p>
    <?php } else {?>
    <p class="txt">请输入想要查找的游戏</p>
    <?php }?>
</div>
<?php
}
?>
<script src="<?=C::$cdn_path?>js/fastclick.js"></script>
<script>
$(function() {
    FastClick.attach(document.body);
});
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>