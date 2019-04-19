<?php
header('Content-Type:text/html;charset=utf-8');

require_once($_SERVER['DOCUMENT_ROOT'].'/app/haoyoukb/common.php');

$mobileUrl = "http://www.3839.com/a/mobile/".$yx_id.".htm";
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-transform" />
<title><?=$res['appname']?>_<?=$res['appname']?>下载_好游快爆-分享新鲜好游戏</title>
<meta name="description" content="<?=htmlspecialchars($res['appinfo'])?>">
<meta name="keywords" content="<?=$res['appname'].','.$res['appname'].'下载'.','.$res['appname'].'免费下载'?>">
<link href="http://newsimg.5054399.com/css/shouyou/shouji_new_head_style_e1.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://newsimg.5054399.com/haoyoukb/css/style.css">
<link rel="alternate" media="only screen and(max-width: 640px)" href="<?=$mobileUrl?>" >
<script type="text/javascript" src="http://newsimg.5054399.com/js/checkMobile.js"></script>
<script>var __mobileurl='<?=$mobileUrl?>';check_mobile(__mobileurl,__mobileurl,'')</script>
<script type="text/javascript" src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
<script type="text/javascript" src="http://newsapp.5054399.com/comment/view.php?ac=js&pid=1&fid=<?=$yx_id?>"></script>
<base target="_blank">
</head>
<body>
<!--topbar-->
<div class="b1">
    <ul class="cf">
		<li class="k-1 fl"><a href="http://www.3839.com/">好游快爆</a></li>
        <li class="k-2 fr"><a href="http://www.3839.com/">免费下载好游快爆</a></li>
    </ul>
</div>
<div class="b2">
    <div class="bo-fr">
        <div class="title tit-6">
        扫描二维码  下载好游快爆
        </div>
        <dl class="wei cf">
            <dt><img src="http://newsimg.5054399.com/uploads/soft/170426/238_1623231241.png"></dt>
            <dd>每天推荐精选好游</dd>
            <dd>全网最强攻略库</dd>
            <dd>多款实用辅助工具</dd>
        </dl>
        <div class="title tit-7">
            手游人气榜
        </div>
        <ul class="c-4"></ul>
    </div>
    <div class="box">
        <ul class="c-1 cf">
           <dl class="cf fl">
                <dt class="fl"><img src="<?=$res['icopath']?>" alt="<?=$res['appname']?>"></dt>
                <dd class="d-1"><?=$res['appname']?></dd>
                <dd class="d-2">
                <?php 
                    $key_tag = 'haoyoukb_xiangqing_tag_name';
                    $allTags = getHaoyouTags($key_tag);
                    $tagsArr = explode(",", $res['tags']);                     
                    $tags_name = array();
                    foreach ($tagsArr as $k => $v) {
                        $tags_name[] = $allTags[$v]['typename'];
                    }
                    foreach ($tags_name as $v) {
                        $tagStr .= "<span>".$v."</span>";
                    }
                    echo $tagStr;
                ?>
                </dd>
                <dd class="d-3"><a href="#">安装</a></dd>
                <dd class="d-4">有超过<i><?=$res['num_download_box']+$res['num_download_kuaibao']?></i>人在玩该游戏</dd>
            </dl>
            <p class="score" id="score"><!--8分左右class为p-8,7分左右class为p-7-->
                <em></em>
                <i>评分</i>
            </p>
            <div class="share">
                  <p>分享给朋友</p>
                  <div class="bdsharebuttonbox bdshare-button-style0-16" id="bdshare" data-tag="share_1" data-bd-bind="1442891681860"> <a href="#" class="bds_sqq sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_qzone qz" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tsina wb" data-cmd="tsina" title="分享到新浪微博"></a></div>
                  
            </div>
            
        </ul>
        <div id="gamedes">
            <?php if ( $res['appdescription'] ) { ?>
            <div class="title tit-1">
            编辑推荐
            </div>
            <p class="jing"><?=$res['appdescription']?></p>
            <?php } ?>
            <div class="m_picthumb">
                <!--ks_slide-->
                <div class="ks_slide">
                    <div class="ks_slide_box" id="j-picthumb">
                        <ul class="ks_slide_list ks_slide_hor" id="j-slide-thumb" style="width: 2724px; margin-left: 0px;">
                            <?php
                                $screenStr  = '';
                                $screenPath = unserialize($res['screenpath']);
                                $screenNum  = count($screenPath);
                                foreach ($screenPath as $k => $v) {
                                    $screenStr .= '<li class="fancybox cur" data-index="'.($k + 1).'" id="slide'.$k.'">';
                                    $screenStr .= '<a href="'.$v.'" onclick="return false;" rel="group" class="prew" data-fancybox-group="gallery">';
                                    $screenStr .= '<img src="'.$v.'">';
                                    $screenStr .= '</a>';
                                    $screenStr .= '</li>';
                                }
                                echo $screenStr;
                            ?>
                        </ul>
                    </div>
                    <span class="ks_slide_left" id="j-thumb-left">
                    </span>
                    <span class="ks_slide_right" id="j-thumb-right">
                    </span>
                </div>
                <!--/ks_slide-->
            </div>
            <div class="title tit-2">
            简介
            </div>
            <ul class="c-3">
            <?php
                $desShow = mb_substr($res['appinfo'], 0, 153,'utf-8');
                $desHide = mb_substr($res['appinfo'], 153, 2000,'utf-8');
            ?>                                              
            <li style="display:block"><?=$desShow?><span style="display: none;"><?=$desHide?></span></li>
            </ul>
            <?php if ( $desHide ): ?>
                <p class="zhan">展开</p><!--展开之后想收起来，添加class为shuo-->
            <?php endif; ?>
            <div class="title tit-3">
            详细信息
            </div>
            <ul class="c-5 cf">
                <li class="y-1">游戏大小：<em><?= round($res['size_byte']/1048576,2) ?>M</em></li>
                <li class="y-2">游戏版本：<em><?=$res['version']?></em> </li>
                <li class="y-1">游戏类型：<em><?=$_kind[$res['kind_id']]?></em></li>
                <li class="y-2">开发商：<em><?php $name = unserialize($res['dev']);echo $name['name'];?></em></li>
            </ul>
        </div>
    </div>
</div>
<!--footer-->

<div class="phone_footer">
    <div class="phone_wrapper">
    <style type="text/css">
    .phone_product .ico_yh{ background:url(http://newsimg.5054399.com/css/shouyou/images/phone_universal_e2.png) no-repeat 0 -420px;width:16px; height:16px; float:left;}
    .phone_product dd{ color:#333; float:left;height:16px; font-size:12px; margin:2px 0 0 0;background:url(http://newsimg.5054399.com/css/shouyou/images/phone_universal_e2.png) no-repeat right -231px;padding:0 8px;font-family:"simsun";line-height:16px;}
    .phone_product dd i{ margin:0 5px 0 0; _margin:0 2px 0 0;}
    </style>
        <div class="phone_copyright">
            <p>
                <a rel="external nofollow" href="http://www.miitbeian.gov.cn/" target="_blank">ICP证：闽B2-20040099</a>
                <a rel="external nofollow" href="http://net.china.cn/chinese/index.htm" target="_blank" >不良信息举报中心</a>
                <a rel="external nofollow" >闽网文[2015]1021-0003号</a>
            </p>
            <p>Copyright &copy; 2009 - <?=date('Y')?> 3839.com All Rights Reserved. 厦门纯游互动科技有限公司 版权所有 </p>
        </div>
    </div>
</div>


<script type="text/javascript">
    var gameName  = "<?= $res['appname'] ?>";
    var shareTile = "好游推荐―《"+gameName+"》，赶快使用#好游快爆APP#下载该游戏，还有更多好玩游戏等着你。";
    var shareImg  = "<?=$res['icopath']?>";
    var screenNum = "<?= $screenNum ?>" - 1;
    var imgArray  = <?php echo json_encode($screenPath); ?>;
    var fid     = <?=$yx_id?>;
    var appname = "<?=$res['appname']?>";
</script>
<script src='http://newsimg.5054399.com/haoyoukb/js/index.js'></script> 
<script>
    document.write('<script src="http://newsimg.5054399.com/haoyoukb/shouyou_top.js?v='+Math.random()+'" type="text/javascript"><\/script>');
</script>
<script type="text/javascript" src="http://news.4399.com/js/mtj.js"></script>
</body>
</html>