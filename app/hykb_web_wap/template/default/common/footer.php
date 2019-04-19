<?php 
defined('APP_PATH') or exit('Access Denied');
?>
<div class="footCopy" id="footer">
    <p>本公司产品适合10周岁以上玩家使用 <a href="//m.3839.com/jzjh.html" rel="external nofollow">未成年人家长监护</a></p>
    <p><a rel="external nofollow" href="http://www.miitbeian.gov.cn/">ICP证：闽B2-20180297</a>  <a rel="external nofollow" href="http://sq.ccm.gov.cn/ccnt/sczr/service/business/emark/toDetail/65df7e24611047c091053caa546be9f9">闽网文[2018] 0806-043号</a></p>
    <p>&copy; 2009-2019  3839.com All Rights Reserved.</p>
</div>

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