<?php  defined('APP_PATH') or die('Access Denied'); ?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=Edge,chrome=1" />
    <title>后台生成管理2</title>
    <link rel="stylesheet" href="http://newsimg.5054399.com/app/aolaxing/web/third/bootstrap/css/bootstrap.min.css"/>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
    <style>
        body{16px;line-height:200%}
        </style>
<body>
<div class="row" style="margin:10px auto; width:960px ">

   <h3>排行榜页面生成</h3>
    <div>
    1、<a href="<?=$top_url?>" target="_blank">排行榜预览</a><br>
    2、<a href="?m=make2&ac=make_top" target="_blank">生成排行榜页面</a><br>
    </div>
    <br/>
    <h3>开发者详情页生成</h3>
     <div>
   	   指定开发者UID生成
   	 <form class="form-horizontal" id="myform2" action="?m=make2&ac=makemanu" method="post" target="_blank">
               <table class="table table-striped table-bordered table-hover">
                   <tbody><tr class="info">
                       <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">指定开发者UID生成</td>
                   </tr>
                   <tr>
                       <td class="span2" style="vertical-align: middle;text-align: center;">开发者UID<br>（多个请用“,”号分隔）</td>
                       <td><textarea style="width:95%" rows="10" name="ids"></textarea></td>
                   </tr>
               </tbody></table>
               <p class="text-center">
                   <input value="确定" onClick="$('#myform2').submit();" class="btn btn-primary" type="button">&nbsp;&nbsp;
               </p>
           </form>
   	</div>
  </br>
    <h3>新奇页面生成</h3>
    <div>
        1、<a href="<?=$newness_url?>" target="_blank">新奇页面预览</a><br>
        2、<a href="?m=make2&ac=make_newness" target="_blank">生成新奇页面</a><br>
    </div>
    <br/>
    <h3>安利墙页面生成</h3>
    <div>
        1、<a href="<?=$wall_url?>" target="_blank">安利墙页面预览</a><br>
        2、<a href="<?=$anli_coll?>" target="_blank">安利墙页面下的游戏单预览</a><br>
        3、<a href="?m=make2&ac=make_commentwall" target="_blank">生成安利墙页面</a><br>
    </div>
    <br/>
    <h3>合辑大全页面生成</h3>
    <div>
        1、<a href="<?=$coll_url?>" target="_blank">合辑页面热门预览</a><br>
        2、<a href="?m=make2&ac=make_coll" target="_blank">生成合辑页面</a><br>
        3、<a href="?m=make2&ac=make_collall" target="_blank">生成所有分类详情页</a><br>
        4、指定合辑文章ID生成
        <form class="form-horizontal" id="myform2" action="?m=make2&ac=make_collarc" method="post" target="_blank">
            <table class="table table-striped table-bordered table-hover">
                <tbody><tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">指定文章ID生成</td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">文章ID<br>（多个请用“,”号分隔）</td>
                    <td><textarea style="width:95%" rows="10" name="ids"></textarea></td>
                </tr>
                </tbody>
            </table>
            <p class="text-center">
                <input value="确定" onClick="$('#myform2').submit();" class="btn btn-primary" type="button">&nbsp;&nbsp;
            </p>
        </form>
    </div>
    <br/>
   <h3>分类聚合页生成</h3>
    <div>
    1、<a href="<?=$category_url?>" target="_blank">分类聚合页首页预览</a><br>
    2、<a href="?m=make2&ac=make_categoryindex" target="_blank">生成分类聚合页首页</a><br>
	3、<a href="?m=make2&ac=make_categoryall" target="_blank">生成所有分类详情页</a><br>
	4、指定分类ID生成
	 <form class="form-horizontal" id="myform" action="?m=make2&ac=make_category" method="post" target="_blank">
            <table class="table table-striped table-bordered table-hover">
                <tbody><tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">指定分类ID生成</td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">分类ID<br>（多个请用“,”号分隔）</td>
                    <td><textarea style="width:95%" rows="10" name="ids"></textarea></td>
                </tr>
            </tbody></table>
            <p class="text-center">
                <input value="确定" onClick="$('#myform').submit();" class="btn btn-primary" type="button">&nbsp;&nbsp;
            </p>
        </form>
    </div>
    <br/>


</div>
</body>
</html>
