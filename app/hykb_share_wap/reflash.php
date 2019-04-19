<?php
require_once dirname(__FILE__) . '/common.php';

define('LOGIN_PASSWORD','bHS1Z@qcy8mj');
require_once ROOT_PATH . '/app/include/checkLogin.func.php';

$ac = trim(strval($_GET['ac']));
if($ac == 'reset'){
	$aids = trim($_POST['aids']);
    $vids = trim($_POST['vids']);
	if($aids){
        $aids = explode("\n", $aids);
        foreach($aids as $aid){
            $aid = intval($aid);
            if($aid){
                $mem->delete(MEM_PRE . 'arc_info_' . $aid);
            }
        }
	}
	if($vids){
        $vids = explode("\n", $vids);
        foreach($vids as $vid){
            $vid = intval($vid);
            if($vid){
                $mem->delete(MEM_PRE . 'video_detail_' . $vid);
            }
        }
    }
	echo '<script>alert("操作成功");window.location.href="reflash.php";</script>';
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="x-ua-compatible" content="IE=edge" />
<title>3839文章页和视频页清除缓存</title>
<link rel="stylesheet" href="http://newsimg.5054399.com/bootstrap/css/bootstrap.min.css" />
<script src="http://newsimg.5054399.com/bootstrap/js/jquery.min.js"></script>
<script src="http://newsimg.5054399.com/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="row" style="margin:10px auto; width:960px">
    <h3 style="text-align:center">3839文章页和视频页清除缓存</h3>
    <div class="span12">
        <form class="form-horizontal" id="myform" action="?ac=reset" method="post">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <td style="vertical-align: middle;text-align: center;">文章ID</td>
                    <td style="vertical-align: middle;"><textarea name="aids" class="span10" rows="4" id="aids"></textarea></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">视频ID</td>
                    <td style="vertical-align: middle;"><textarea name="vids" class="span10" rows="4" id="vids"></textarea></td>
                </tr>
            </table>
            <pre class="text-error">
PS：可以输入多个文章ID和视频ID，请用换行隔开！</pre>
            <p class="text-center">
                <input type="button" value="确认" id="reset" class="btn btn-primary"/>
            </p>
        </form>
    </div>
</div>
<script>
	$('#reset').click(function(){
		var aids = $('#aids').val();
		var vids = $('#vids').val();
        if(!aids && !vids){
            alert('请输入文章ID或者视频ID');
            return false;
        }

		$('#myform').submit();
		return false;
	});
</script>
</body>
</html>