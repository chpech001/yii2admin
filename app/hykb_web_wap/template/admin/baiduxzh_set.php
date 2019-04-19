
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=Edge,chrome=1" />
    <title>sem设置-通用设置</title>
    <link rel="stylesheet" href="http://newsimg.5054399.com/app/aolaxing/web/third/bootstrap/css/bootstrap.min.css"/>
    <script src="http://newsimg.5054399.com/js/jquery/1.8/jquery.js"></script>
</head>
<body>
<div class="row" style="margin:10px auto; width:960px ">
    <div class="span12">
        <form class="form-horizontal" id="myform" action="?m=baiduxzh&ac=setcity" method="post">
            <table class="table table-striped table-bordered table-hover">

                <tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">sem监管区域设置</td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">监管区域列表</td>
                    <td class="span10">
					<div id="clist">
					<?php foreach($arr['city'] as $k=>$v){?>
                    <p class="link" style="white-space:nowrap">
                        市区&nbsp;<input class="span3" type="text" name="city[]" value="<?=$v?>"/>
                        <a class="btn btn-danger btn-del-info" href="#" >删除</a>
                    </p>
					<?php }?>
					</div>
					 <a class="btn btn-inverse btn-clone" href="#" data-tmpl="link">添加</a>
                    </td>
                </tr>

            </table>
            <p class="text-center">
                <input type="button" value="确定" onClick="$('#myform').submit();" class="btn btn-primary"/>&nbsp;&nbsp;
            </p>
        </form>
    </div>
</div>

<div class="row" style="margin:10px auto; width:960px ">
    <div class="span12">
        <form class="form-horizontal" id="myform1" action="?m=baiduxzh&ac=setshow" method="post">
            <table class="table table-striped table-bordered table-hover">

                <tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">sem展示设置</td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">监管区域设置</td>
                    <td class="span10" style="line-height:40px">
					    普通下载按钮显示设置：
                        <input type="radio" value="1" name="showbtn" <?php if($arr['show']['showbtn']==1){echo 'checked';}?>/>显示 
						<input type="radio" value="0" name="showbtn" <?php if($arr['show']['showbtn']==0){echo 'checked';}?>/>隐藏
						<br/>   					
                        普通下载弹窗显示设置：
						<input type="radio" value="1" name="showwin" <?php if($arr['show']['showwin']==1){echo 'checked';}?>/>显示   
						<input type="radio" value="0" name="showwin" <?php if($arr['show']['showwin']==0){echo 'checked';}?>/>隐藏,下载链接为apk下载链接
						<input type="radio" value="2" name="showwin" <?php if($arr['show']['showwin']==2){echo 'checked';}?>/>隐藏,下载功能同高速下载
						<br/>
					    订阅资讯按钮样式选择：
						<input type="radio" value="1" name="showyz" <?php if($arr['show']['showyz']==1){echo 'checked';}?>/>有弹窗(预约抢先玩按钮)   
						<input type="radio" value="0" name="showyz" <?php if($arr['show']['showyz']==0){echo 'checked';}?>/>有弹窗(有取消按钮)
						<input type="radio" value="2" name="showyz" <?php if($arr['show']['showyz']==2){echo 'checked';}?>/>无弹窗(功能同预约抢先玩)    
                    </td>
                </tr>
				
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">非监管区域设置</td>
                    <td class="span10" style="line-height:40px">
                      	普通下载按钮显示设置：
                        <input type="radio" value="1" name="showbtn1" <?php if($arr['show']['showbtn1']==1){echo 'checked';}?> />显示 
						<input type="radio" value="0" name="showbtn1" <?php if($arr['show']['showbtn1']==0){echo 'checked';}?>/>隐藏
						<br/>   					
                        普通下载弹窗显示设置：
						<input type="radio" value="1" name="showwin1" <?php if($arr['show']['showwin1']==1){echo 'checked';}?>/>显示   
						<input type="radio" value="0" name="showwin1" <?php if($arr['show']['showwin1']==0){echo 'checked';}?>/>隐藏,下载链接为apk下载链接
						<input type="radio" value="2" name="showwin1" <?php if($arr['show']['showwin1']==2){echo 'checked';}?>/>隐藏,下载功能同高速下载
						<br/>
					    订阅资讯按钮样式选择：
						<input type="radio" value="1" name="showyz1" <?php if($arr['show']['showyz1']==1){echo 'checked';}?>/>有弹窗(预约抢先玩按钮)   
						<input type="radio" value="0" name="showyz1" <?php if($arr['show']['showyz1']==0){echo 'checked';}?>/>有弹窗(有取消按钮)
						<input type="radio" value="2" name="showyz1" <?php if($arr['show']['showyz1']==2){echo 'checked';}?>/>无弹窗(功能同预约抢先玩）
                    </td>
                </tr>				
                 <tr>
                    <td colspan="2">
					  预约弹窗文案：<input  type="text" name="ycontent" value="<?=$arr['show']['ycontent']?>" style="width:800px"/>
					</td>
                </tr>
            </table>
            <p class="text-center">
                <input type="button" value="确定" onClick="$('#myform1').submit();" class="btn btn-primary"/>&nbsp;&nbsp;
            </p>
        </form>
    </div>
</div>




<script type="text/javascript">
    $(document).on('click', '.btn-del-info', function() {
        $(this).parent().remove();
        return false;
    });
    $(document).on('click','.btn-clone',function(){
	  var clist='<p class="link" style="white-space:nowrap">'
	            +' 市区&nbsp;<input class="span3" type="text" name="city[]" value=""/>'
				+' <a class="btn btn-danger btn-del-info" href="#" >删除</a>'
				+'</p>';
	   $("#clist").append(clist);
	});
</script>
</body>
</html>