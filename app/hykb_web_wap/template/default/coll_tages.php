<?php defined("APP_PATH") or die('Access denied'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<?php if($type=='hot'){?>
    <title>热门游戏合集大全_热门游戏合集分类-好游快爆app</title>
    <meta name="keywords" content="热门游戏合集,热门游戏合集大全,热门游戏合集分类">
    <meta name="description" content="好游快爆游戏单为您提供热门游戏合集大全，包括动作游戏合集、生存游戏合集、沙盒游戏合集，抖音游戏合集等各种类型的热门游戏单。来好游快爆，制作属于你自己的的游戏单。">
	<?php }else{?>
    <title>最新游戏合集大全_最新游戏合集分类-好游快爆app</title>
    <meta name="keywords" content="最新游戏合集,最新游戏合集大全,最新游戏合集分类">
    <meta name="description" content="好游快爆游戏单为您提供最新游戏合集大全，包括动作游戏合集、生存游戏合集、沙盒游戏合集，抖音游戏合集等各种类型的最新游戏单。来好游快爆，制作属于你自己的的游戏单">
	<?php }?>
    <link rel="canonical" href="https://www.3839.com/heji/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="full-screen" content="yes" />
    <meta name="x5-fullscreen" content="true" />

    <link href="<?=C::$cdn_path?>v2/css/style.min.css" type="text/css" rel="stylesheet">
    <script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
    <base target="_self" />
</head>
<body>
<?php include_once("baidu_js_push.php") ?>

<div class="headArea">
    <a class="link-back"  href="javascript:history.back(-1)"></a>
    <span class="class">选择标签</span>
</div>

<div class="glist-tag-all">
    <a href="<?php echo Comm::get_url('coll',$type,array('view_ishtml'=>1));?>">全部游戏单</a>
</div>
<?php
    foreach ($tags_list as $k=>$v){
        ?>

        <div class="glist-tag-it">
            <table class="out" cellpadding="0" cellspacing="0"  width="100%">
                <tr>
                    <td width="24%">
                        <div class="class">
                            <img lzimg="1" lz_src="<?=$v['icon']?>" alt="<?=$v['title']?>"><?=$v['title']?>
                        </div>
                    </td>
                    <td>
                        <table class="in" cellpadding="0" cellspacing="0"  width="100%">
                            <tr>
                            <?php
                                $tag_num=count($v['list']);
                                foreach ($v['list'] as $key2=>$val2){

                                    if($key2%3==0 && $key2>0){ echo '</tr><tr>';}

                                    $heji_url=Comm::get_url('coll',$type,array('view_ishtml'=>1,'id'=>$val2['id']));
                                   //先用预览地址
                                    //$heji_url=Comm::get_view_url('coll','coll_detail',array('type'=>$type,'id'=>$val2['id']));

                                    echo '<td><a '.($val2['hot']=="1"?'class="hot"':'').' href="'.$heji_url.'">'.$val2['title'].'</a></td>';

                                    if($key2%3==0 && $key2==$tag_num-1){ echo '<td></td><td></td>';}
                                    if($key2%3==1 && $key2==$tag_num-1){ echo '<td></td>';}
                                }
                            ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }
?>
<script src="<?=C::$cdn_path?>v2/js/fastclick.js"></script>


<script>
    $(function() {
        FastClick.attach(document.body);

    });
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/jq/lzimg.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>

