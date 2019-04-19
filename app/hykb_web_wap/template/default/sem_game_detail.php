<?php 
defined('APP_PATH') or exit('Access Denied');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<?php if(!empty($seogame)){?>
	<title><?=$seogame['title']?></title>
    <meta name="keywords" content="<?=$seogame['keyword']?>"/>
    <meta name="description" content="<?=$seogame['desc1']?>"/>
	<?php }else{?>
    <title><?=$data['title']?>下载_<?=$data['title']?>安卓版-好游快爆APP</title>
    <meta name="keywords" content="<?=$data['title']?>,<?=$data['title']?>下载,<?=$data['title']?>安卓版,<?=$data['title']?>免费下载"/>
    <meta name="description" content="<?=mb_substr(strip_tags(htmlspecialchars_decode($data['appinfo'])),0,50,'utf-8')?>..."/>
	<?php }?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="canonical" href="https://www.3839.com/a/<?=$id?>.htm">
    <link href="//newsimg.5054399.com/baodian/v3/wap/css/swiper.css" rel="stylesheet" type="text/css">
    <link href="<?=C::$cdn_path?>css/game.min_v5.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
    <link href="<?=C::$cdn_path?>css/comment.min.css?v=<?=CDN_V?>" type="text/css" rel="stylesheet">
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
    <script src="<?=C::$cdn_path?>js/common.js?v=<?=CDN_V?>"></script>
    <script type="text/javascript" src="//newsapp.5054399.com/cdn/comment/view_v2-ac-js-pid-1-fid-<?=$data['id']?>-p-1-page_num-1-reply_num-1-order-1.htm"></script>
    <script src="//msite.baidu.com/sdk/c.js?appid=1604934640021042"></script>
</head>
<body>
<?php include 'common/header.php';?>
<?php
$downInfo['apkurl']=str_replace('http:','',$downInfo['apkurl']);
$wap_url=Comm::get_url('home','',array('view_ishtml'=>1));
?>
<ul class="breadcrumb">
    <li><a href="<?=$wap_url?>">首页</a></li>
    <?php if ($data['tags'][0]) {
	 $curl=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$data['tags'][0]['id'],'type'=>'hot'));
	 ?><li><a href="<?=$curl?>"><?=$data['tags'][0]['title']?></a></li><?php }?>
    <li><span><?=$data['title']?></span></li>
</ul>
<?php if ($data['videoinfo']['id']) {?>
<div class="game-img">
    <?php if ($video_link) {?>
        <video style="width:100%; height:100%;margin: 0 auto;" controls="controls" <?=$video_img ? 'poster="'.$video_img.'"' : ''?> x5-video-player-type='h5'>
            <source src="<?=$video_link?>" type="video/mp4" />
        </video>
    <?php } else {?>
        <img src="//newsimg.5054399.com/uploads/allimg/160225/191_1245434541.jpg">
    <?php }?>
</div>
<?php }?>
<div class="game-main">
    <div class="inner">
        <div class="game-info cf">
            <img src="<?=$data['icon']?>" alt="<?=$data['title']?>下载">
            <div class="con">
                <h1><?=$data['title']?></h1>
                <p class="tag">
                    <?php 
                    $data['tags'] = array_slice($data['tags'],0,3);
                    foreach($data['tags'] as $k=>$v) {
					    $curl=Comm::get_url('category','detail',array('view_ishtml'=>1,'id'=>$v['id'],'type'=>'hot'));
                        echo '<span><a href="'.$curl.'">'.$v['title'].'</a></span>';
                    }
                    ?>
                </p>
                <p><?php 
				if ($data['status'] == 4 && $num_yuyue)
					echo '有超过<span>'.$num_yuyue.'</span>人预约该游戏';
				elseif ($data['status']==1 && $num_down)
					echo '有超过<span>'.$num_down.'</span>人在玩该游戏';
				?></p>
            </div>
            <?php if ($star) {?>
            <div class="vote">
                <span class="sp1">快爆评分</span>
                <span class="score"><?=$data['star']?></span>
                <div class="star">
                    <span style="width: <?=$star*10?>%"></span>
                </div>
                <span class="sp2"><?=$data['star_usernum']?>人</span>
            </div>
            <?php } else {?>
            <div class="vote novote">
                <span class="sp1">快爆评分</span>
                <div class="star"></div>
                <span class="sp2">暂无评分</span>
            </div>
            <?php }?>
        </div>
        <?php
        if ($data['status']==1) {
            echo '<div class="game-down spec line-two"></div><div class="down-tip" onclick="pop2(\'downtips1\');">用好游快爆下载能5倍提速，保障安装包正确不被<a>劫持</a></div>';
        } else if ($data['status']==4) {
            echo '<div class="game-down yzbtn spec line-two"></div><div class="down-tip">用好游快爆预约抢先玩到新游戏，大量游戏主播都在用</div>';
        } else if ($data['status']==3 || $data['status']==5) {
            echo '<div class="game-down"><a class="fast grey down_btn" href="#" rel="collect">敬请期待</a></div>';
        } else if ($data['status'] == 6) {
			echo '<div class="game-down"><a class="fast green down_btn" href="#" rel="collect">查看详情</a></div>';
        }
        ?>
		 <ul class="game-otbtn">
            <li><a class="game-share" id="share_link" data-role="share">分享给好友</a></li>            
        </ul>
		 <a class="slotApp" href="//m.3839.com/slot.html">
            <img src="<?=C::$cdn_path?>images/applogo.png" alt="好游快爆">
            <div>
                <em>好游快爆-抢先玩新鲜好玩游戏</em>
                <p>我们游戏爱好者自己的APP，了解更多</p>
            </div>
          </a>
    </div>
    <ul class="game-tab" id="tabMenu1">
        <li class="on">详情</li>
		<?php if(empty($topic_id)){$showz='none';}else{$showz='';}?>
		<li style="display:<?=$showz?>">专区</li>
        <li>评价<?php if (intval($data['star_usernum']>0)) echo '<span id="pl_num">0</span>';?></li>
    </ul>
</div>

<div id="tabList1">
    <!-- 详情 -->
    <div>
        <?php 
        $buc = $data['test_intro'];
        if ($buc['open'] && $buc['title'] && $buc['info']) {
        ?>
        <div class="game-con filter_a">
            <div class="game-hint">
                <div class="hd">
                    <em><?=$buc['title']?></em>
                    <?php 
                    if ($buc['shorttitle']) {
                        $url = Comm::getUrlByInterface($buc['interface_type'],$buc['interface_id'],$buc['url']);
                        echo '<a class="lk-gift pop_btn" href="'.$buc['url'].'">'.$buc['shorttitle'].'</a>';
                    }
                    ?>
                </div>
                <div class="bd">
                    <p><?=$buc['info']?></p>
                </div>
                <?php if ($buc['info2']) {
                    $buc['info2'] = strtolower($buc['info2']);
                    if (substr_count($buc['info2'], '<a ') == substr_count($buc['info2'], '</a>')) {
                        echo $buc['info2'];
                    } else {
                        echo '<script>var div = document.createElement(\'div\');div.innerHTML =\''.str_replace('\'','\"',$buc['info2']).'\';document.write(div.innerHTML);</script>';
                    }
                }
                ?>
            </div>
        </div>
        <?php }?>
        <?php if ( $data['editor_recommend'] ) { ?>
        <div class="area gameIntro filter_a">
            <div class="hd">
                <em>编辑推荐</em>
            </div>
            <div class="game-desc"><p><?=$data['editor_recommend']?></p></div>
        </div>
        <?php } ?>
        <div class="game-pic">
            <ul class="swiper-wrapper cf" id="game_pic">
                <?php
                $screenStr  = '';
                $screenpath = isset($data['screenpath']) ? $data['screenpath'] : array();
                // if ($data['video_more']) {
                //     foreach($data['video_more'] as $v) {
                //         $video_link = Comm::reLink($v['vlink']);
                //         $video_img = Comm::reLink(Comm::replaceImg($v['icon']));
                //         $screenStr .= '<li><video style="width:100%; height:100%;margin: 0 auto;" controls="controls" '.($video_img ? 'poster="'.$video_img.'"' : '').' x5-video-player-type=\'h5\'><source src="'.$video_link.'" type="video/mp4" /></video></li>';
                //     }
                // }
                foreach ($screenpath as $k => $v) {
                    // list( $width ,  $height ,  $type ,  $attr ) = @getimagesize($v);
                    // if (!$width || !$height) continue;
                    // $addClass = ' ';//默认横图
                    // if ($width>$height) {
                    //     $addClass = ' horizontal';//不加样式为竖图
                    // }
                    $v = Comm::reLink($v);
                    $screenStr .= '<li class="swiper-slide"><div class="img'.$addClass.'"><img src="'.$v.'" alt="'.$data['title'].'截图'.($k+1).'"></div></li>';
                }
                echo $screenStr;
                ?>
            </ul>
            
        </div>
        <?php if ($data['writer_uid']) {?>     
        <div class="game-pro">
            <img src="<?=$data['writer_avatar']?>" alt="<?=$data['writer']?>">该游戏由<span><?=$data['writer']?></span>提供
        </div>
        <?php }?>
        <div class="area gameIntro filter_a">
            <div class="hd">
                <em>游戏简介</em>
            </div>
            <div class="game-desc over" id="appinfowp"><div id="appinfodiv"><?=strip_tags(htmlspecialchars_decode($data['appinfo']),'<br>')?></div></div>
            <div class="ft">
                <ul class="gamesup">
                    <?php
                    if ($data['marketinfo']['a']) {
                        echo '<li><span class="img"><img src="'.C::$cdn_path.'images/sup/sup2.png" alt=""></span>需要网络</li>';
                    }
                    if ($data['marketinfo']['b']) {
                        echo '<li><span class="img"><img src="'.C::$cdn_path.'images/sup/sup3.png" alt=""></span>免费</li>';
                    }
                    if ($data['marketinfo']['c']) {
                        echo '<li><span class="img"><img src="'.C::$cdn_path.'images/sup/sup1.png" alt=""></span>无需谷歌市场</li>';
                    }
                    ?>
                </ul>
                <span class="showmore" id="btn_zhan" style="display:none"><em></em></span>
            </div>
        </div>
        <?php if ($data['applog']) {?>
        <div class="area filter_a">
            <div class="hd">
                <em>更新日志</em>
            </div>
            <div class="game-desc over" id="applogwp"><div id="applogdiv"><?=htmlspecialchars_decode($data['applog'])?></div></div>
            <div class="ft" style="display:none">
                <span class="showmore" id="btn_zhan2"><em></em></span>
            </div>
        </div>
        <?php }?>
        <div class="area filter_a">
            <div class="hd">
                <em>游戏信息</em>
            </div>
            <?php $gameinfo = $data['gameinfo'];?>
            <ul class="game-data">
                <?php if ($data['status'] != 4 && $gameinfo['v']) { ?><li>游戏版本：<?=$gameinfo['v']?></li><?php }?>
                <li>更新时间：<?=date('Y.m.d', $gameinfo['time'])?></li>       
                <?php if ($data['status'] != 4 && $gameinfo['size']) { ?><li>游戏大小：<?=$gameinfo['size']?></li><?php }?>
                <?php if ($gameinfo['lang']) {?><li>语言：<?=$gameinfo['lang']?></li><?php }?>
                <?php if ($gameinfo['sys']) {?><li>系统要求：<?=$gameinfo['sys']?></li><?php }?>
                <li>开发商：<?php if ($gameinfo['kbuid']) { 
				$manu_url=Comm::get_url('manu','detail',array('view_ishtml'=>1,'id'=>$gameinfo['kbuid']));
				echo '<a href="'.$manu_url.'">'.$gameinfo['dev'].'</a>';}else{ echo $gameinfo['dev'];}?></li>
            </ul>
        </div>
        
        <!-- 推荐评论 -->
        <div id="commentReco"></div>

        <?php if ($data['recommend_game']) {?>
        <div class="area">
            <div class="hd">
                <em>相关游戏推荐</em>
            </div>
            <div class="bd">
                <ul class="glist">
                    <?php foreach($data['recommend_game'] as $v) {
                    $url = Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
                    ?>
                    <li><a href="<?=$url?>"><img src="<?=$v['icon']?>" alt="<?=$v['title']?>下载"><?=$v['title']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <?php }?>
        <?php if ($data['more_develop_games']) {?>
        <div class="area">
            <div class="hd">
                <em>该开发者其他游戏</em>
                <!-- <a class="more" href="#">显示全部</a> -->
            </div>
            <div class="bd">
                <ul class="glist">
                    <?php foreach($data['more_develop_games'] as $v) {
                        $url = Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
                    ?>
                    <li><a href="<?=$url?>"><img src="<?=$v['icon']?>" alt="<?=$v['title']?>下载"><?=$v['title']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <?php }?>
        <?php if ($data['discover']) {?>
        <div class="area">
            <div class="hd">
                <em>每日新发现</em>
                <!-- <a class="more" href="#">显示全部</a> -->
            </div>
            <div class="bd">
                <ul class="glist">
                    <?php foreach($data['discover'] as $v) {
                        $url = Comm::get_url('game_detail','',array('id'=>$v['id'],'view_ishtml'=>1));
                    ?>
                    <li><a href="<?=$url?>"><img src="<?=$v['icon']?>" alt="<?=$v['title']?>下载"><?=$v['title']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <?php }?>
    </div>

    <!-- 评论 -->
    <div class="hide" id="commentList"></div>
</div>
<div id="zhuanqu" class="hide"></div>
<div id="weixin_warn" style="display:none;">
    <div class="bgmark"></div>
    <div class="wxtips"></div>
</div>
<div class="swiper-container swiper-container2" id="swiper-container2">
    <div class="swiper-pagination2" id="swiper-pagination2"><span class="swiper-curr"></span>/<span class="swiper-count"></span></div>
    <ul class="swiper-wrapper">
    <?php
    $screenStr  = '';
    $screenpath = isset($data['screenpath']) ? $data['screenpath'] : array();
    foreach ($screenpath as $k => $v) {
        // list( $width ,  $height ,  $type ,  $attr ) = @getimagesize($v);
        // if (!$width || !$height) continue;
        // $addClass = ' ';//默认横图
        // if ($width>$height) {
        //     $addClass = ' horizontal';//不加样式为竖图
        // }
        $v = Comm::reLink($v);
        $screenStr .= '<li class="swiper-slide"><img src="" class="empty" /><img src="'.$v.'" alt="'.$data['title'].'截图'.($k+1).'"></li>';
    }
    echo $screenStr;
    ?>
    </ul>
</div>
<a id="gotop" class="gotop" style="display:none" onClick="go_to($('body'))">返回顶部</a>
<?php if ($gamelinks){
    echo '<div class="friLink" id="friLink"><dt>友情链接</dt>';
    foreach($gamelinks as $k=>$v) {
        echo '<dd><a href="'.$v['url'].'">'.$v['title'].'</a></dd>';
    }
    echo '</div>';
}?>
<?php include 'common/footer.php';?>

<!-- 手机预约 -->

<div class="pop pop-spec" style="display: none;" id="yzw">
    <div class="state">
	    <a class="pclose" href="#">关闭</a>
        <i><img src="<?=C::$cdn_path?>images/icon-reminding.png"></i>
        <p>订阅资讯仅通过<span style="color:#FFAF0F">短信</span>通知</p>
    </div> 
    <div class="pcon">
        <p class="pf28" id="ycontent"></p>
        <div class="mbNum">
            <input type="number" placeholder="请输入你的手机号码" id="mobile">
        </div>
        
        <div class="mbNum checkcode">
            <input type="number" placeholder="请输入你的验证码" id="yzm">
            <span class="getcode yzcbtn">获取验证码</span>
			<span class="getcode geting jssnbtn" style="display:none">重新发送(<i id="jsn">60</i>)S</span>
        </div>
    </div>
    <div class="pbtn">
	    <div class="ystyle">
        <a href="#"  class="fast down_btn" style="color:#23C268">预约抢先玩</a>
        <a href="#" class="yybtn" style="color:#999999">订阅资讯</a>
		</div>
		<div class="ystyle" style="display:none">
        <a href="#" style="color:#999999" onClick="pop_hide();return false;">取消</a>
        <a href="#" class="yybtn" style="color:#23C268">订阅资讯</a>
		</div>	
    </div>
</div>
<!-- 预约成功 -->
<div class="pop pop-spec" style="display: none;" id="yzs">
    <div class="state">
        <i><img src="<?=C::$cdn_path?>images/icon-succeed.png"></i>
        <p>订阅成功</p>
    </div>    
    <div class="pcon">
        <p class="pf28 tip">游戏上线后，将第一时间通过<span>免费短信</span>通知你</p>
        <p class="pf28">下载好游快爆APP，查看更多游戏一手资讯爆料</p>
    </div>
    <div class="pbtn">
        <a href="#" onClick="pop_hide();return false;">关闭</a>
        <a href="#" class="game-down green down_btn">立即下载</a>
    </div>
</div>
<!-- 预约成功 -->
<div class="pop pop-spec" style="display: none;" id="yymore" >
    <div class="state">
        <i><img src="<?=C::$cdn_path?>images/icon-reminding.png"></i>
        <p>订阅次数过多啦</p>
    </div>    
    <div class="pcon">
        <p class="pf28 tip" style="text-align:center">您今天的订阅次数过多了</p>
        <p class="pf28">下载好游快爆APP，可订阅更多游戏，抢新游激活码</p>
    </div>
    <div class="pbtn">
        <a href="#" onClick="pop_hide();return false;">关闭</a>
        <a href="#" class="game-down green down_btn">立即下载</a>
    </div>
</div>
<div class="pop" style="display:none" id="ptxz"><a class="pclose" href="#">关闭</a>
    <div class="ptit"></div>
    <div class="pcon">
        <p class="pf24 pd15">普通下载速度较慢且可能被劫持下载到<span class="green">错的安装包</span>。<br>建议使用好游快爆高速下载。</p>
    </div>
    <div class="downbtn">
        <a class="fast down_btn" href="#">高速下载</a>
        <a class="slow" href="<?=$downInfo['apkurl']?>">普通下载</a>
    </div>
</div>

<div class="pop" style="display:none" id="downtips1"><a class="pclose" href="#">关闭</a>
    <div class="ptit"></div>
    <div class="pcon">
        <p class="pf24 pd15" style="line-height:0.3rem">
		  Q：什么是劫持？
		  <br/><br/>
		  A：劫持是指在游戏下载过程中，一些中小网络运营商将正确的游戏安装包替换成广告包的行为。<br/>
		  使用好游快爆APP下载游戏，将大幅减少被劫持情况。
		</p>
    </div>
    <div class="downbtn">
        <a onClick="pop_hide();return false;">确定</a>
    </div>
</div>
<script src="//newsimg.5054399.com/mobileStyle/v3/js/AndroidConnect.js"></script>
<script src="//newsimg.5054399.com/js/hykb_qd_version.js"></script>
<script src="<?=C::$cdn_path?>js/swiper-4.3.5.min.js"></script>
<script type="text/javascript" src="//newsimg.5054399.com/js/clipboard.min.js"></script>
<script>
var downInfo = <?=json_encode($downInfo)?>,
    downurl = 'https://d.3839app.com/pg/g/'+lastHykbQdVersion+'/gaosu3/'+downInfo['kb_id']+'.hykb_'+lastHykbQdVersion+'_gaosu3.apk';
var is_wechat = ua.match(/MicroMessenger/i) == 'micromessenger';
var gameId =<?=$data['id']?>;
var share_title = '<?=$share_title?>',
    share_icon = (document.location.protocol=="https:"?"https:":"http:")+'<?=Comm::reLink($data['icon'])?>',
    share_desc = '<?=$share_desc?>';
var gstatus='<?=$data['status']?>';
if(gstatus==1 || gstatus==4){
	  $.ajax({
		url:"https://m.3839.com/app/hykb_web_wap/index.php?m=game_detail&ac=iplocation",
		//url:"http://t.m.3839.com/app/hykb_web_wap/index.php?m=game_detail&ac=iplocation",
		type:"post",
		dataType:"json",
		success:function(msg){
		  setsem(msg.show_nor_down,msg.show_nor_down_win,msg.ybtn_style,msg.ycontent);  
		}
	  });
}

 function setsem(show_nor_down,show_nor_down_win,ybtn_style,ycontent){
		  if(gstatus==1){
			  if(show_nor_down==1){
				 if(show_nor_down_win==1){
				   var str='<a class="fast down_btn" href="#"><p><span class="ico-down"></span>高速下载</p><p>(需安装好游快爆)</p></a><a class="slow" href="" onclick="pop2(\'ptxz\');return false;">普通下载</a>'; 
				 }else{
				  if(show_nor_down_win==0){
	              var str='<a class="fast down_btn" href="#"><p><span class="ico-down"></span>高速下载</p><p>(需安装好游快爆)</p></a><a class="slow" href="'+downInfo['apkurl']+'">普通下载</a>';}
				  
				  if(show_nor_down_win==2){
	               var str='<a class="fast down_btn" href="#"><p><span class="ico-down"></span>高速下载</p><p>(需安装好游快爆)</p></a><a class="slow down_btn">普通下载</a>';
				  }
				 }
			  }else{
				$(".game-down").removeClass("spec line-two");
				var str=' <a class="down_btn" href="#"><span class="ico-down"></span>通过好游快爆高速下载</a>'; 
			  }
			 $(".game-down").html(str);
		  }else{
		    if(ybtn_style==2){
			   var str='<a class="fast yellow down_btn" href="#"><p>预约抢先玩</p><p>(需安装好游快爆)</p></a><a class="slow down_btn" href="#">订阅资讯</a>';
			   $(".yzbtn").html(str);
			}else{
			var str='<a class="fast yellow down_btn" href="#"><p>预约抢先玩</p><p>(需安装好游快爆)</p></a><a class="slow" href="#" " onclick="pop2(\'yzw\');return false;">订阅资讯</a>';
				$(".yzbtn").html(str);
				$("#ycontent").html(ycontent);
				$(".ystyle").hide();
				if(ybtn_style==1){$(".ystyle").eq(0).show();}
				if(ybtn_style==0){$(".ystyle").eq(1).show();}
		    }
		  }
  }
</script>
<script src="<?=C::$cdn_path?>js/detail.js" type="text/javascript"></script>
<script type="text/javascript">
(function () {

    $('#headwp>div.headArea').addClass('fixed');

    // 评论数
    pjnumFormate(num);
    $('#pl_num').html(pjnumFormate(num));

    // IOS，隐藏底部浮动
    if (!is_ios) {
        $('#bomDownDiv').show();
    } 

    // 微信提示点击隐藏
    $('#weixin_warn').click(function(){
        $(this).hide();
    })

    // 滚动
    var scrollTop = getScrollTop(),
        clientHeight = getClientHeight();

    $(window).scroll(function(){
        scrollTop = getScrollTop();

        // 返回顶部按钮
        if (scrollTop>clientHeight) {
            $('#gotop').show();
        } else {
            $('#gotop').hide();
        }

    });
    
$('#tabMenu1>li').click(function(){
        var i=$(this).index();
        tab2(i);
 });
var showiframe=0;
var ntype=<?=(int) $_REQUEST['ntype']?>;	
function tab2(i) {
	var li = $('#tabMenu1>li').eq(i);
	if (li.attr('rel')) {
		pop($(this).attr('rel'));
		return false;
	} else {
		li.addClass('on').siblings().removeClass('on');
		$("#zhuanqu").addClass('hide');
		$('#tabList1>div').addClass('hide')
		if(i==0 || i==2){
		  $(".friLink").show();
		  if(i==0){var tabi=0;}
		  if(i==2){var tabi=1;} 
		 $('#tabList1>div').eq(tabi).removeClass('hide').find('img[lz_src]').attr('src', function () { return $(this).attr('lz_src') }).removeAttr('lz_src');
		}
		if (i == 2 && !li.attr('commented')) {
			li.attr('commented',1);
			comInit.comPanel();
		}
		if(i==1){
		 $(".friLink").hide();
		 var str='<iframe id="zq" width="100%"  scrolling="no" allowtransparency="true" frameborder="0" style="border:0px;margin-bottom:5px;min-height:500px;margin-top:-5px" src="<?=$zurl?>"></iframe>';
		 if(showiframe==0){
		   showiframe=1;
		   $("#zhuanqu").html(str);
		 }
		 $("#zhuanqu").removeClass('hide');
		}
		return false;
	}
}
    if (is_ios){
        loadIosPop();
    }
    
    if ($('#btn_zhan2').length) shuoZhan($('#btn_zhan2'),'applogwp','applogdiv');
    shuoZhan($('#btn_zhan'),'appinfowp','appinfodiv');

    var swiper1 = new Swiper('.game-pic', {
        slidesPerView: 'auto',
        freeMode: true
    });

    // 截图切换
    var swiper2 = new Swiper ('#swiper-container2',{
        on: {
        slideChangeTransitionStart: function(){
            $("#swiper-pagination2 .swiper-curr").text(this.activeIndex+1);
        }}
    });
    // 点击放大
    $("#game_pic .swiper-slide").on("click",function(e){
        if ($('#swiper-container2 .swiper-slide').length==0) {
            $('#swiper-container2>ul').html($('#game_pic').html());
        }
        var _index = $(this).index("#game_pic .swiper-slide");
        $("#swiper-container2").show();
        swiper2.update();//更新
        swiper2.slideTo(_index,0);//定位1
        $("#swiper-pagination2 .swiper-curr").text(_index+1);//定位2
        $("#swiper-pagination2 .swiper-count").text(swiper2.slides.length);//计算总页数
    });
    // 设置高度+点击消失
    $("#swiper-container2").height($(window).height()).on("click",function(){$(this).hide()});
    $(window).resize(function(){
        $("#swiper-container2").height($(window).height());
    });
	
})();

    //倒计时
	var tt;
	var can_send_sms=1;
	function daojishi(){
	  var jsn=parseInt($("#jsn").html());
	  jsn=jsn-1;
	  if(jsn<=0){
	    clearTimeout(tt);
		$("#jsn").html(60);
		$(".jssnbtn").hide();
		$(".yzcbtn").show();
		can_send_sms=1;
	  }else{
	    $("#jsn").html(jsn);
		tt=setTimeout("daojishi()",1000);
	  }
	}
	//预约发送验证码
	$(".yzcbtn").click(function(){
	  if(can_send_sms==0){return false;}
	  var mobile=$("#mobile").val();
	  if(mobile==''){_alert('请输入手机号码',function(){pop2('yzw');return false;});can_send_sms=1;return false;}
	  var partter=/^1[34578]\d{9}$/;
	  if(!partter.test(mobile)){_alert('请输入正确的手机号码',function(){pop2('yzw');return false;});can_send_sms=1;return false;}
	  can_send_sms=0;
	  $.ajax({
	    url:"https://m.3839.com/app/hykb_web_wap/index.php?m=game_detail&ac=sendsms",
		//url:"http://t.m.3839.com/app/hykb_web_wap/index.php?m=game_detail&ac=sendsms",
		data:{mobile:mobile},
		type:"post",
		dataType:"json",
		success:function(msg){
		 if(msg.code=='OK'){
		   	 $("#jsn").html(60);
	         $(".jssnbtn").show();
	         $(".yzcbtn").hide();
	         daojishi();
		 }else{
		    _alert(msg.msg,function(){pop2('yzw');return false;});
			can_send_sms=1;
		 }   
		}
	  });
	});
	//开始预约
	$(".yybtn").click(function(){
	  var mobile=$("#mobile").val();
	  var yzm=$("#yzm").val();
	  var game_id=<?=$data['id']?>;
	  if(mobile==''){_alert('请输入手机号码',function(){pop2('yzw');return false;});can_send_sms=1;return false;}
	  if(yzm==''){_alert('请输入验证码',function(){pop2('yzw');return false;});can_send_sms=1;return false;}
	  var partter=/^1[34578]\d{9}$/;
	  if(!partter.test(mobile)){_alert('请输入正确的手机号码',function(){pop2('yzw');can_send_sms=1;return false;});return false;}
	  $.ajax({
	    url:"https://m.3839.com/app/hykb_web_wap/index.php?m=game_detail&ac=yygame",
		//url:"http://t.m.3839.com/app/hykb_web_wap/index.php?m=game_detail&ac=yygame",
		data:{mobile:mobile,yzm:yzm,game_id:game_id},
		type:"post",
		dataType:"json",
		success:function(msg){
		 can_send_sms=1;
		 if(msg.code==100){
           pop2('yzs');return false;
		 }else{
		    if(msg.code=='error1'){
			 pop2('yymore');return false;
			}else{
			 if(msg.code=='error'){
		      _alert(msg.msg,function(){pop2('yzw');return false;});
			 }else{
			  _alert(msg.msg,function(){pop_hide();return false;});
			 }
			}
		 }   
		}
	  });
	  return false;
	});

(function () {
    // 下载
    function downClick(){
        var detail_downurl = downInfo['apkurl'];
        var detail_package = downInfo['package'];
        var detail_title = downInfo['appname'];
        var detail_pic = (document.location.protocol=="https:"?"https:":"http:")+downInfo['icon'];
        var detail_md5 = downInfo['md5'];
        AndroidConnect.launch('hykb://downloadManager?url=' + detail_downurl + '&packageName=' + detail_package + '&name=' + encodeURIComponent(detail_title) + '&icon=' + encodeURIComponent(detail_pic) + '&md5=' + detail_md5 + '&uid=0&vid=0', function(){
            document.location.href = downurl;
        });
    }

    $(document).on('click','a.down_btn',function(){
        if (is_ios) {
            pop2('pop_ios');
            // window.location.href = '//m.3839.com/qd-gaosu3.html';
            return false;
        }
        if (is_wechat) {
            $('#weixin_warn').show();
            return false;
        }
        
        downClick();
        return false;
    });

    // 联动打开游戏详情页
    $(document).on('click','a.btn_goto',function(){
        pop_hide();
        if (is_ios) {
            pop2('pop_ios');
            // window.location.href = '//m.3839.com/qd-gaosu3.html';
            return false;
        }
        if (is_wechat) {
            $('#weixin_warn').show();
            return false;
        }
        AndroidConnect.launch('hykb://openTopic?type=gamedetail&gameId='+gameId, function(){
            document.location.href = downurl;
        });
        return false;
    });
    // 联动打开快爆首页
    $(document).on('click','a.btn_app',function(){
        pop_hide();
        if (is_ios) {
            pop2('pop_ios');
            // window.location.href = '//m.3839.com/qd-gaosu3.html';
            return false;
        }
        if (is_wechat) {
            $('#weixin_warn').show();
            return false;
        }
        AndroidConnect.launch('hykb://openTopic?topicId=0', function(){
            document.location.href = downurl;
        });
        return false;
    });
    // 弹窗
    $(document).on('click','a.pop_btn',function(){
        if ($(this).attr('rel')) {
            pop($(this).attr('rel'));
            return false;
        }
    });

    // 外链弹窗
	 $('.filter_a a').click(function(){
            var href = $(this).attr('href');
            if(href && href.indexOf('//')!=-1){
                if (href.indexOf('3839.com')==-1) {
                   	    pop('detail');
                    return false;
                }else{
				  return true;
				}
            }
        });
})();
function jump_url(url){
  top.location.href=url;
}

function set_iframe_h(h){
  $("#zq").css("height",h+"px");
}

function showDialog(id, text){
  if(!id){return false;}
  _alert(text);
   return false;
}
</script>
<script src="<?=C::$cdn_path?>js/wxshare.js" type="text/javascript"></script>
<script type="text/javascript">
(function () {
    // 分享
    wshare(share_title, share_desc, share_icon, window.location.href);

    $('#share_link').attr('data-share-title', share_title);
    $('#share_link').attr('data-share-url', window.location.href);
    $('#share_link').attr('data-share-img', share_icon);
    $('#share_link').attr('data-share-description',  share_desc);
    document.write('<script type="text/javascript" src="//newsimg.5054399.com/etweixin/v2/js/zepto.min.js"><\/script>');
    document.write('<script type="text/javascript" src="//newsimg.5054399.com/etweixin/v2/js/jshare.js"><\/script>');
    
})();

(function () {
    $('#game_pic .img').each(function(index,element){
        that=$(this);
        thisImg=$(this).find('img').attr('src');
        imgReady(index,thisImg, function () {
            var i=index;
            if(this.width/this.height>1){
                $('#game_pic .img').eq(i).addClass("horizontal")
            }   
        });    
    })
})();


    // 评论技术配置
    var pid=null;//项目ID
    var fid=<?=$data['id']?>;//内容ID
    var fscore='<?=$data['star']?>';//文章评分
	var fscore=parseFloat(fscore);
    //var apiStr="//newsapp.5054399.com/cdn/comment/view_v2-ac-json-pid-{pid}-fid-{fid}-p-{pages}-page_num-{numpage}-reply_num-{numreply}-order-{order}-htmlsafe-1-urltype-1.htm";
var apiStr="//newsapp.5054399.com/cdn/comment/view_v2-ac-json-pid-{pid}-fid-{fid}-p-{pages}-page_num-{numpage}-reply_num-{numreply}-order-{order}-htmlsafe-1-urltype-1-audit-1.htm";
    window.comlist = '';
    var comInit={
        //下载弹窗提示
        downTips:function(){
            pop('comment');
        },
        comPanel:function(){
            comlist.$mount("#commentList");
        }
    }
</script>
<script src="<?=C::$cdn_path?>js/chunk-vendors.js?v=<?=CDN_V?>"></script>
<script src="<?=C::$cdn_path?>js/app.js?v=<?=CDN_V?>"></script>
<script type="application/ld+json">
{
	"@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
	"@id": "<?=$gameurl?>",
	"appid": "1604934640021042",
	"title": "<?=$data['title']?>下载_安卓版-好游快爆APP",
	"images": ["<?=str_replace('http://','https://',preg_replace('#f\d{1,3}\.img4399\.com#','fs.img4399.com',$data['icon']))?>"],
	"description": "<?=mb_substr(strip_tags(htmlspecialchars_decode($data['appinfo'])),0,50,'utf-8')?>...",
	"pubDate": "<?=str_replace(' ','T',date('Y-m-d H:i:s', $pubDate))?>",
	"upDate": "<?=str_replace(' ','T',date('Y-m-d H:i:s', $upDate))?>",
	"data": {
		"WebPage":{}
	}
}
</script>
<script type="text/javascript" src="//newsimg.5054399.com/js/mtj.js"></script>
</body>
</html>