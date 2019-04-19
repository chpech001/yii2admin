<?php 
defined('APP_PATH') or exit('Access Denied');
$wap_url=Comm::get_url('home','',array('view_ishtml'=>1));
?>
<div class="headwp" id="headwp">
    <div class="headArea">
    <a href="<?=$wap_url?>"><span class="applogo">好游快爆</span></a>
    <script type="text/javascript">
    if (is_ios) {
        document.write('<a onclick="pop2(\'pop_ios\')"><span class="downtip"></span></a>')
    } else {
        document.write('<a href="//d.4399.cn/Q7" rel="external nofollow"><span class="downtip"></span></a>');
    }
    </script>
    <a class="link-sch" href="<?=$GLOBALS['_search_index']?>">搜索</a>
    </div>
</div>