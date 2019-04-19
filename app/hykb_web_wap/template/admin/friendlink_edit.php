
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
        <form class="form-horizontal" id="myform" action="?m=friendlink&ac=edit" method="post">
            <table class="table table-striped table-bordered table-hover">
                <tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;"><?=$typename?></td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">友链</td>
                    <td class="span10">
                    <?php
                    $i = 0;
					if(!empty($links)){
                    foreach($links as $k=>$v) {
                    ?>
                     <p class="link" style="white-space:nowrap">
                        标题&nbsp;<input class="span3" type="text" name="links[<?=$i?>][title]" value="<?=$v['title']?>"/>
                        链接&nbsp;<input class="span6" type="text" name="links[<?=$i?>][url]" value="<?=$v['url']?>"/>
                        <a class="btn btn-danger btn-del-info" href="#" >删除</a>
                    </p>
                    <?php $i++; }}?>
                    <a class="btn btn-inverse btn-clone" href="#" data-tmpl="link">添加一个友链</a>
                    </td>
                </tr>

            </table>

            <p class="text-center">
			    <input type="hidden" name="type" value="<?=$type?>"/>
                <input type="button" value="返回列表" onClick="window.location.href='?m=sysinfo&ac=gamelink_list'" class="btn"/>&nbsp;&nbsp;
                <input type="button" value="确定" onClick="$('#myform').submit();" class="btn btn-primary"/>&nbsp;&nbsp;
            </p>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#myform').submit(function(){
        var link_flag = false;
        $('p.link').each(function(i){
            var link_tit = $.trim($(this).find('input:text').eq(0));
            var link_url = $.trim($(this).find('input:text').eq(1));
            if (link_tit || link_url) {
                link_flag = true;
                return false;
            }
        });
        if (!link_flag) {
            alert('请填写链接信息');
            return false;
        }
    });
	var linknum=<?=$i?>;
    $(document).on('click', '.btn-del-info', function() {
	    linknum=linknum-1;
        $(this).parent().remove();
        return false;
    });
    $(document).on('click', '.btn-clone', function(){
        linknum=linknum+1;
		var str='<p class="link" style="white-space:nowrap">'
		       +'标题&nbsp;<input class="span3" type="text" name="links['+linknum+'][title]" value=""/>'
			   +'链接&nbsp;<input class="span6" type="text" name="links['+linknum+'][url]" value=""/>'
			   +'<a class="btn btn-danger btn-del-info" href="#" >删除</a>'
			   +'</p>';
	    $(this).before(str);
        return false;
    });
</script>
</body>
</html>
