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
    <meta name="description" content="<?=mb_substr($appinfo,0,50,'utf-8')?>..."/>
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
        <span class="cls"<?=$q?'':' style="display:none"'?>></span>
    </div>
    <a class="schbtn" onclick="$('#searchForm').submit()">搜索</a>
    </form>
    <script>searchForm($('#searchForm'),'请输入想要查找的游戏')</script>
</div>

<div class="so-wrap">
    <div class="hd">
        <em>热门搜索</em>
    </div>
    <ol class="so-hot cf">
        <?php 
        foreach($game_keys as $k=>$v) {
            echo '<li><i>'.($k+1).'</i><a href="?m=search&ac=search_result&q='.urlencode($v).'">'.$v.'</a></li>';
        }
        ?>
    </ol>
</div>

<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>