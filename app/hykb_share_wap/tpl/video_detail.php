<?php defined('ROOT_PATH') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$videoInfo['title']?>-好游快爆APP</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="<?=$wapUrl?>css/share.min.css" type="text/css" rel="stylesheet">
<link href="<?=$wapUrl?>css/comment.min.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="//newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<div class="headwp">
    <div class="headArea fixed">
        <a href="//m.3839.com/wap.html"><span class="applogo">好游快爆</span></a>
        <script type="text/javascript">
            var ua = navigator.userAgent,
                is_ios = ua.match(/iphone|ipad|ipod/i);
            if (is_ios) {
                document.write('<a onclick="pop2(\'pop_ios\')"><span class="downtip"></span></a>')
            } else {
                document.write('<a href="//d.4399.cn/Q7" rel="external nofollow"><span class="downtip"></span></a>');
            }
        </script>
        <a class="link-sch" href="//m.3839.com/search/">搜索</a>
    </div>
</div>
<?php if($teseMenuList){?>
<div class="srcMenuWp">
    <div class="srcMenu" id="srcMenu">
        <ul>
            <li class="on"><a href="<?=$zq_url?>">专区首页</a></li>
            <?php foreach($teseMenuList as $v){?>
                <li><a href="<?=$v['url']?>"><?=$v['is_red'] ? '<font color="red">' . $v['name'] . '</font>' : $v['name']?></a></li>
            <?php }?>
        </ul>
    </div>
    <span class="srcMenuBtn" id="srcMenuBtn1"></span>
    <div class="allMenu" id="allMenu">
        <span class="srcMenuBtn" id="srcMenuBtn2"></span>
        <div class="hd">专区首页</div>
        <ul>
            <?php foreach($teseMenuList as $v){?>
                <li><a href="<?=$v['url']?>"><?=$v['is_red'] ? '<font color="red">' . $v['name'] . '</font>' : $v['name']?></a></li>
            <?php }?>
        </ul>
    </div>
</div>
<?php }?>
<div class="gameItem">
    <div class="game-info cf">
        <img src="<?=F::dealImg($gameInfo['icon'])?>" alt="<?=$gameInfo['title']?>下载">
        <div class="con">
            <em<?=!$gameInfo['tags'] ? ' class="line2"' : ''?>><?=$gameInfo['title']?></em>
            <?php
            $html = '';
            if($gameInfo['tags']){
                $html .= '<p class="tag">';
                $gameInfo['tags'] = array_slice($gameInfo['tags'],0,3);
                foreach($gameInfo['tags'] as $k => $v) {
                    $html .= '<span>' . $v['title'] . '</span>';
                }
                $html .= '</p>';
            }
            echo $html;
            ?>
            <p><?php
                if ($gameInfo['status'] == 4 && $num_yuyue)
                    echo '有超过<span>' . $num_yuyue . '</span>人预约该游戏';
                elseif ($gameInfo['status'] == 1 && $num_down)
                    echo '有超过<span>' . $num_down . '</span>人在玩该游戏';
                ?></p>
        </div>
        <?php if($star){?>
            <div class="vote">
                <span class="sp1">快爆 评分</span>
                <span class="score"><?=$gameInfo['star']?></span>
                <div class="star">
                    <span style="width: <?=$star * 10?>%"></span>
                </div>
                <span class="sp2"><?=$gameInfo['star_usernum']?>人</span>
            </div>
        <?php } else {?>
            <div class="vote novote">
                <span class="sp1">快爆 评分</span>
                <div class="star"></div>
                <span class="sp2">暂无评分</span>
            </div>
        <?php }?>
    </div>
    <div class="dwonBtn cf">
        <a class="btn btn1 fl" href="<?=$zq_url?>">
            <i></i>高速下载
        </a>
        <?php if($wap_gsxz_tj && $wap_gsxz_tj['type']){?>
            <a class="btn <?=$wap_gsxz_tj['type'] == 1 ? 'btn3' : 'btn5'?> fr" href="<?=$wap_gsxz_tj['url']?>" id="rytj">
                <i></i><?=$wap_gsxz_tj['name']?>
                <p><?=F::cn_substr($wap_gsxz_tj['desc'], 12)?></p>
            </a>
        <?php } else {?>
            <a class="btn btn4 fr" href="#" id="rytj">
                <i></i>热游推荐
            </a>
        <?php }?>
    </div>
</div>
<div class="vidCon">
    <div class="vidName"><?=$videoInfo['title']?></div>
    <div class="vidPlay">
        <video controls="controls" poster="<?=F::reLink($videoInfo['icon'])?>" x5-video-player-type="h5">
            <source src="<?=F::reLink($videoInfo['vurl'])?>" type="video/mp4">
        </video>
    </div>
    <div class="vidDesc">
        <em>小编有话说</em><?=$videoInfo['desc']?>
    </div>
    <div class="vidInfo">
        <div class="up"><img src="//newsimg.5054399.com/uploads/userup/1812/0G51S023M.jpg" alt="<?=$videoInfo['author']?>"><?=$videoInfo['author']?></div>
        <span class="date"><?=date('Y-m-d', $videoInfo['time'])?></span>
    </div>
</div>
<?php if($videoDetail['more']){?>
<div class="area">
    <div class="hd">
        <em class="vidMore">更多精彩视频</em>
    </div>
    <ul class="vidOther">
        <?php foreach($videoDetail['more'] as $v){?>
        <li>
            <a href="<?=F::getVideoDetailUrl($v['id'])?>">
                <div class="img"><img lzimg="1" lz_src="<?=F::reLink($v['icon'])?>" alt="<?=$v['title']?>"></div>
                <div class="con">
                    <p><?=$v['title']?></p>
                    <span class="date"><?=date('m-d', $v['time'])?></span>
                </div>
            </a>
        </li>
        <?php }?>
    </ul>
</div>
<?php }?>
<?php if($gameInfo['discover']){?>
<div class="area">
    <div class="hd">
        <em>每日新发现</em>
    </div>
    <div class="bd">
        <ul class="glist">
            <?php foreach($gameInfo['discover'] as $v){?>
                <li><a href="//m.3839.com/a/<?=$v['id']?>.htm"><img lzimg="1" lz_src="<?=F::dealImg($v['icon'])?>" alt="<?=$v['title']?>下载"><?=$v['title']?></a></li>
            <?php }?>
        </ul>
    </div>
</div>
<?php }?>
<div id="commentComm"></div>
<script>
    var artId = <?=$id?>;
    var artType = 'vid';
    var comInit = {
        //下载弹窗提示
        downTips: function() {
            pop("comment");
        },
        setComTotal: function(val) {
        }
    }
</script>
<?php if($rankTop){?>
<div class="area">
    <div class="hd">
        <em>手游人气榜</em>
    </div>
    <div class="bd">
        <ul class="glist">
            <?php foreach($rankTop as $v){?>
                <li><a href="//m.3839.com/a/<?=$v['id']?>.htm"><img lzimg="1" lz_src="<?=F::dealImg($v['icon'])?>" alt="<?=$v['title']?>下载"><?=$v['title']?></a></li>
            <?php }?>
        </ul>
    </div>
</div>
<?php }?>
<div class="footCopy">
    <p>本公司产品适合10周岁以上玩家使用<a href="//m.3839.com/contact.html" rel="external nofollow">未成年人家长监护</a></p>
    <p><a rel="external nofollow" href="http://www.miitbeian.gov.cn/">ICP证：闽B2-20180297号</a><a rel="external nofollow" href="http://sq.ccm.gov.cn/ccnt/sczr/service/business/emark/toDetail/65df7e24611047c091053caa546be9f9"><img lzimg="1" lz_src="<?=$wapUrl?>images/wen.png" alt="">闽网文[2018] 0806-043号</a></p>
    <p>&copy; 2009-<?=date('Y')?>  3839.com All Rights Reserved.</p>
</div>
<div class="downArea fixed-bottom">
    <span class="btn-hide" onclick="$(this).parent().hide();return false;">关闭</span>
    <img class="img" src="<?=$wapUrl?>images/applogo.png" alt="">
    <div class="con">
        <em>好游快爆 - 分享好游戏</em>
        <span>一个分享精品游戏的APP</span>
    </div>
    <a class="btn-down" href="//d.4399.cn/Q7" rel="external nofollow">马上下载</a>
</div>
<a class="gotop" id="gotop" style="display:none" href="#" onclick="go_to($('body'));return false;">返回顶部</a>
<script type="text/javascript" src="<?=$wapUrl?>js/bscroll.min.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/mobileStyle/v3/js/AndroidConnect.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/hykb_qd_version.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/clipboard.min.js"></script>
<script>
    var downInfo = <?=json_encode($downInfo)?>;
    var wap_gsxz_tj = <?=json_encode($wap_gsxz_tj)?>;
</script>
<script type="text/javascript" src="<?=$wapUrl?>js/wap_share.js?<?=VERSION?>"></script>
<script type="text/javascript" src="<?=$wapUrl?>js/share_chunk-vendors.js"></script>
<script type="text/javascript" src="<?=$wapUrl?>js/share_app.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/kbtj.js"></script>
</body>
</html>