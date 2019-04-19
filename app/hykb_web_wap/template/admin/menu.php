
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>菜单</title>
  <link rel="stylesheet" href="http://t.admin.newsapp.5054399.com/static/bootcss/bootstrap.min.css" />
  <script src="http://admin.newsapp.5054399.com/static/bootcss/jquery.min.js"></script>
  <script src="http://admin.newsapp.5054399.com/static/bootcss/bootstrap.min.js"></script>
  <style type="text/css">
      /*Navigation*/
.sidebar-nav {
  width: 250px;
  position: absolute;
  float: left;
  border: 1px solid #c8c8cb;
  padding-bottom:300px;
}
.sidebar-nav-hide {
  display:none;
}
.sidebar-nav .nav-header {
  border-top: 1px solid #ffffff;
  border-bottom: 1px solid #c8c8cb;
  border-left: none;
  color: #333;
  display: block;
  background: #efeff0;
  background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #efeff0), color-stop(1, #ffffff));
  background: -ms-linear-gradient(bottom, #efeff0, #ffffff);
  background: -moz-linear-gradient(center bottom, #efeff0 0%, #ffffff 100%);
  background: -o-linear-gradient(bottom, #efeff0, #ffffff);
  filter: progid:dximagetransform.microsoft.gradient(startColorStr='#4d5b76', EndColorStr='#6c7a95');
  -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#ffffff',EndColorStr='#efeff0')";
  font-weight: normal;
  font-size: 1em;
  line-height: 2.5em;
  padding: 0em .25em;
  margin-bottom: 0px;
  text-shadow: none;
  text-transform: none;
  /*Change the arrow direction if the item is collapsed*/

}
.sidebar-nav .nav-header .label {
  float: right;
  margin-top: .5em;
  margin-right: .25em;
  line-height: 1.5em;
}
.sidebar-nav .nav-header:hover {
  background: #efeff0;
  background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #efeff0), color-stop(1, #ffffff));
  background: -ms-linear-gradient(bottom, #efeff0, #ffffff);
  background: -moz-linear-gradient(center bottom, #efeff0 0%, #ffffff 100%);
  background: -o-linear-gradient(bottom, #efeff0, #ffffff);
  filter: progid:dximagetransform.microsoft.gradient(startColorStr='#4d5b76', EndColorStr='#6c7a95');
  -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#ffffff',EndColorStr='#efeff0')";
}

.sidebar-nav .nav-header .icon-chevron-up{
  float: right;
  margin-top: .65em;
}
.icon-chevron-down {
  float: right;
  margin-top: .65em;
}
.sidebar-nav .nav-header .label {
  float: right;
  margin-top: .7em;
  line-height: 1.5em;
}
.sidebar-nav .nav-header i[class^="icon-"] {
  margin-right: .75em;
}
.sidebar-nav .nav-list {
  margin: 0px;
  border: 0px;
  background: #f6f6f6;
}
.sidebar-nav .nav-list  > li > a:hover {
  background: #e0e0e8;
}
.sidebar-nav .nav-list  > .active > a,
.sidebar-nav .nav-list  > .active > a:hover {
  background: #d2d2dd;
  color: #555;
  text-shadow: none;
}
.sidebar-nav .nav-list  > .active > a:hover {
  background: #c3c3d2;
}
.sidebar-nav .nav-list  > li > a {
  color: #444;
  padding: .5em 1em;
}
.sidebar-nav .nav-list.collapse.in {
  border-bottom: 1px solid #ccc;
}
</style>
</head>
<body>


<div id="sidebar-nav" class="sidebar-nav"> 
    <a href="#sidebar_menu_1" class="nav-header" data-toggle="collapse"><i class="icon-th"></i>生成管理<i class="icon-chevron-down"></i></a>
    <ul id="sidebar_menu_1" class="nav nav-list collapse in">
        <li><a href="?m=make" target="rightFrame">生成管理</a></li>
		<li><a href="?m=make2" target="rightFrame">二级页面生成管理</a></li>
    </ul>
    <a href="#sidebar_menu_2" class="nav-header collapsed" data-toggle="collapse"><i class="icon-th"></i>系统设置<i class="icon-chevron-down"></i></a>
    <ul id="sidebar_menu_2" class="nav nav-list collapse in">
        <li><a href="?m=sysinfo&ac=indexinfo" target="rightFrame">首页设置</a></li>
		<li><a href="?m=gameseo&ac=list" target="rightFrame">SEO定制</a></li>
        <li><a href="?m=sysinfo&ac=gamelink_list" target="rightFrame">游戏详情链接设置</a></li>
    </ul>
    <a href="#sidebar_menu_3" class="nav-header collapsed" data-toggle="collapse"><i class="icon-th"></i>熊掌号推送<i class="icon-chevron-down"></i></a>
    <ul id="sidebar_menu_3" class="nav nav-list collapse in">
        <li><a href="?m=baiduxzh&ac=push_history" target="rightFrame">推送记录</a></li>
        <li><a href="?m=baiduxzh&ac=old_push" target="rightFrame">历史手动推送</a></li>
		<li><a href="?m=baiduxzh&ac=set" target="rightFrame">熊掌号展示设置</a></li>
    </ul>
</div>
<script type="text/javascript">
    
    $('.nav-header').click(function(){
        if($(this).hasClass('collapsed')){
            $(this).children('.icon-chevron-up').attr('class','icon-chevron-down');
        }else{
            $(this).children('.icon-chevron-down').attr('class','icon-chevron-up');
        }
    })
</script>
</body>
</html>