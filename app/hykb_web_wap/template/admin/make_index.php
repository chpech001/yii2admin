
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="gbk">
    <meta http-equiv="x-ua-compatible" content="IE=Edge,chrome=1" />
    <title>后台-通用设置</title>
    <link rel="stylesheet" href="http://newsimg.5054399.com/app/aolaxing/web/third/bootstrap/css/bootstrap.min.css"/>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
    <style>
        body{16px;line-height:200%}
        </style>
</head>
<body>
<div class="row" style="margin:10px auto; width:960px ">
    <h3>生成首页</h3>
    <div>
   1、<a href="<?=$home_view_url?>" target="_blank">预览</a><br>
   2、<a href="?m=make&ac=make_index" target="_blank">生成</a><br>
    
    </div>
    <br/><br/>
    <h3>生成详情页</h3>
    1、<a href="?m=make&ac=make_all_game_detail" onclick="return confirm('确定要生成所有游戏详情页？')" target="_blank">生成所有游戏详情页</a><br><br><br>
    2、指定游戏ID生成<br>
    <form class="form-horizontal" id="myform" action="?m=make&ac=make_game_detail" method="post" target="_blank">
            <table class="table table-striped table-bordered table-hover">
                <tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">指定游戏ID生成</td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">游戏ID<br>（多个请用“,”号分隔）</td>
                    <td><textarea style="width:95%" rows="10" name="ids"></textarea></td>
                </tr>
            </table>
            <p class="text-center">
                <input type="button" value="确定" onclick="$('#myform').submit();" class="btn btn-primary"/>&nbsp;&nbsp;
            </p>
        </form>

</div>
</body>
</html>
