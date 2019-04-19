
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
<form action="?m=baiduxzh&ac=old_push&type=dopush" method="post">
<table style="margin:0px auto;margin-top:5px;margin-bottom:5px;">
	<tr><th colspan="2">百度熊掌号 - 推送游戏详情历史记录</th></tr>
	<tr>
		<td>地址</td>
		<td>
		<textarea style="width:600px;height:300px" name="urls" id="urls"></textarea>
		<div style="">(一行一个地址)</div>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="点击推送" onclick="return check();"></td>
	</tr>
</table>
</form>
<script>
function check(){
	var urls = $.trim($('#urls').val());
	if (!urls){
		alert('请填写地址');
		return false;
	}
	return confirm('确定推送历史吗');
}
</script>

</body>
</html>
