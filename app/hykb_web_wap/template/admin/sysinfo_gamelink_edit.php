
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
        <form class="form-horizontal" id="myform" action="?m=sysinfo&ac=gamelink_save" method="post">
            <table class="table table-striped table-bordered table-hover">
                <tr class="info">
                    <td colspan="2" style="text-align: center;font-weight: bold;font-size:18px;">游戏详情页底部友链</td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">游戏ID</td>
                    <td class="span10"><input class="span4" type="text" name="gameid" id="gameid" value="<?=$rs['gameid']?>"/> <input type="button" value="点击获取游戏名称" id="btn_getname"></td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">游戏名称</td>
                    <td class="span10"><input class="span4" type="text" name="gamename" id="gamename" value="<?=$rs['gamename']?>"/><span id="tip"></span></td>
                </tr>
                <tr>
                    <td class="span2" style="vertical-align: middle;text-align: center;">友链</td>
                    <td class="span10">
                    <?php
                    $i = 0;
                    foreach($links as $k=>$v) {
                    ?>
                    <p class="link" style="white-space:nowrap">
                        标题&nbsp;<input class="span3" type="text" name="links[<?=$i?>][title]" value="<?=$v['title']?>"/>
                        链接&nbsp;<input class="span6" type="text" name="links[<?=$i?>][url]" value="<?=$v['url']?>"/>
                        <a class="btn btn-danger btn-del-info" href="#" >删除</a>
                    </p>
                    <?php $i++; }?>
                    <a class="btn btn-inverse btn-clone" href="#" data-tmpl="link">添加一个友链</a>
                    </td>
                </tr>

            </table>

            <p class="text-center">
                <input type="button" value="返回列表" onclick="window.location.href='?m=sysinfo&ac=gamelink_list'" class="btn"/>&nbsp;&nbsp;
                <input type="button" value="确定" onclick="$('#myform').submit();" class="btn btn-primary"/>&nbsp;&nbsp;
            </p>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#btn_getname').click(function(){
        var gameid = $.trim($('#gameid').val());
        if (gameid) {
            $.post('?m=sysinfo&ac=gamelink_getname',{gameid:gameid},function(data){
                if (data.status==1) {
                    $('#gamename').val(data.title);
                } else {
                    alert(data.msg);
                }
            },'json');
        } else {
            alert('请填写游戏ID');
        }
        return false;
    });
    $('#myform').submit(function(){
        var gameid = $.trim($('#gameid').val());
        var gamename = $.trim($('#gamename').val());
        if (!gameid) {
            alert('请填写游戏ID');
            $('#gameid').focus();
            return false;
        }
        if (!gamename) {
            alert('游戏名称不能为空');
            $('#gamename').focus();
            return false;
        }
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
    $(document).on('click', '.btn-del-info', function() {
        $(this).parent().remove();
        return false;
    });
    $(document).on('click', '.btn-clone', function(){
        var $this = $(this),
            $tr = $this.closest('tr'),
            tmpl_class = $this.data('tmpl'),
            $tmpls = $tr.find('.'+tmpl_class);
        var cur_idx = $this.data('cur-idx');
        if (cur_idx == undefined) {
            cur_idx = $tmpls.length;
        }
        $this.data('cur-idx',cur_idx+1);
        var $tmpl = $tmpls.eq(0).clone();
        $tmpl.find("input,select").each(function(){
            var $this = $(this), name = $this.attr('name');
            if ($this.is('input')) {
                if ($this.attr('type') == 'text') {
                    if ($this.data('default-val') != undefined) {
                        $this.val($this.data('default-val'));
                    } else {
                        $this.val('');
                    }
                }
            } else if ($this.is('select')) {
                $this.find('option').eq(0).attr('selected','selected');
            }
            if (name) {
                name = name.replace(/\[[\d]+\]/,"["+cur_idx+"]");
                $this.attr('name',name);
            }
        });
        $('.'+tmpl_class+':last').after($tmpl);
        return false;
    });
</script>
</body>
</html>
