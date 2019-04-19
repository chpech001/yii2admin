<?php
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once(ROOT_PATH."/app/include/config.php");

$mem = new memcache;
$mem->connect(MEM_HOST,MEM_PORT);

if (is_dir('/www/t.news.4399.com/')) {
	$mem_pre = 'haoyoukb_xiangqing_ot_v1_';
} elseif (ROOT_PATH == '/www/ot.www.3839.com') {
	$mem_pre = 'haoyoukb_xiangqing_ot_v1_';
} else {
	$mem_pre = 'haoyoukb_xiangqing_v1_';
}

$ac = strval($_GET['ac']);
if($ac == 'reset'){
	$gameID = trim($_POST['gameID']);
	if(!$gameID){
		die('please enter gameID');
	}
	
	$gameID = explode("\n", $gameID);
	foreach($gameID as $gid){
		$gid = intval($gid);
		if($gid){
			$key = $mem_pre.$gid;
			$mem->delete($key);
		}
	}
	
	echo '<script>alert("操作成功");window.location.href="resetmem.php";</script>';
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="x-ua-compatible" content="IE=edge" />
<title>好游快爆游戏详情数据重置</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/2.3.2/css/bootstrap.min.css" />
<script src="http://cdn.bootcss.com/jquery/1.11.0/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="row" style="margin:10px auto; width:960px">
    <h3 style="text-align:center">好游快爆游戏详情数据重置</h3>
    <div class="span12">
        <form class="form-horizontal" id="myform" action="?ac=reset" method="post">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <td style="vertical-align: middle;text-align: center;">游戏ID</td>
                    <td style="vertical-align: middle;"><textarea name="gameID" class="span10" rows="4" id="gameID"></textarea></td>
                </tr>
            </table>
            <p class="text-center">
                <input type="button" value="重置" id="reset" class="btn btn-primary"/>
            </p>
        </form>
		<pre class="text-error">
PS：可以输入多个游戏ID，请用换行隔开！</pre>
    </div>
</div>
<script>
	$('#reset').click(function(){
		var gameID = $('#gameID').val();
		if(!gameID){
			alert('请输入游戏ID');
			return false;
		}
		
		$('#myform').submit();
		return false;
	});
</script>
</body>
</html>