
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=Edge,chrome=1" />
    <title>后台-通用设置</title>
    <link rel="stylesheet" href="http://newsimg.5054399.com/app/aolaxing/web/third/bootstrap/css/bootstrap.min.css"/>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<div class="row" style="margin:10px auto; width:960px ">
    <div class="span12">
        <form class="form-horizontal" id="myform" action="?m=gameseo&ac=edit" method="post">
            <table class="table table-striped table-bordered table-hover">
                <tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">游戏详情seo设置</td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">游戏ID</td>
                    <td class="span10"><input class="span4" type="text" name="gameid"  value="<?=$rs['gameid']?>" id="gameid"/><span id="tip"></span></td>
                </tr>

                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">游戏名称</td>
                    <td class="span10"><input class="span4" type="text" name="gamename"  value="<?=$rs['gamename']?>" id="gamename"/></td>
                </tr>


                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">页面标题</td>
                    <td class="span10"><input class="span4" type="text" name="title"  value="<?=$rs['title']?>" id="title"/></td>
                </tr>

                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">关键字</td>
                    <td class="span10"><input class="span4" type="text" name="keyword"  value="<?=$rs['keyword']?>" id="keyword"/></td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">页面描述</td>
                    <td class="span10"><input class="span4" type="text" name="desc"  value="<?=$rs['desc1']?>" id="desc"/></td>
                </tr>


            </table>

            <p class="text-center">
                <input type="button" value="返回列表" onClick="window.location.href='?m=gameseo&ac=list'" class="btn"/>&nbsp;&nbsp;
                <input type="button" value="确定" onClick="checkform();return false;" class="btn btn-primary"/>&nbsp;&nbsp;
            </p>
        </form>
    </div>
</div>
<script language="javascript">
 function checkform(){
   var gameid=$("#gameid").val();
   var gamename=$("#gamename").val();
   var title=$("#title").val();
   var keyword=$("#keyword").val();
   var desc=$("#desc").val();
   var patter=/\d+/;
   var patter1=/script|select|join|union|where|insert|delete|update|like|drop|create|modify|rename|alter|cas|load_file|outfile|truncate|declare|>|#|<|\&|css|\/|\"|\'|\(|\)|prompt|=|%/;
   
   if(!patter.test(gameid)){
    alert("请填写正确的游戏ID");return false;
   }
   if(gamename=='' || title=='' || keyword=='' || desc==''){
    alert("请填写完整信息");return false;
   }
   if(patter1.test(gamename)){
     alert("游戏名称含有特殊字符串,请从新输入");return false;
   }
    if(patter1.test(title)){
     alert("页面标题含有特殊字符串,请从新输入");return false;
   }
   if(patter1.test(keyword)){
     alert("关键字含有特殊字符串,请从新输入");return false;
   }
   if(patter1.test(desc)){
     alert("页面描述称含有特殊字符串,请从新输入");return false;
   }
   $("#myform").submit();
 }
</script>
</body>
</html>
