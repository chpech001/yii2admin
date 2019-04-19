
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
<div class="row" style="margin:0 auto; width:960px;">
    <div class="span12">
        <form id="s_form" method="post" action="?m=sysinfo&ac=gamelink_list">
            <div style="margin:10px 0;">
                <a class="btn" id="btn_makesel">生成选定的游戏</a>
                <a class="btn btn-info" href="?m=sysinfo&ac=gamelink_edit">新增</a>
                <a class="btn btn-success" href="?m=sysinfo&ac=comm_gamelink">全局设置</a>
				<a class="btn btn-success" href="?m=friendlink&ac=edit&type=1">排行榜友链</a>
				<a class="btn btn-success" href="?m=friendlink&ac=edit&type=2">新奇友链</a>
				<a class="btn btn-success" href="?m=friendlink&ac=edit&type=3">分类友链</a>
                <div class="pull-right">
                    <input type="text" id="keyword" name="keyword" value="<?=$keyword?>" style="margin-bottom:0;"/>
                    <a class="btn" href="#" onClick="$('#s_form').submit();return false;">搜索</a>
                    <a class="btn" href="?m=sysinfo&ac=gamelink_list">全部</a>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered table-hover" style="width:100%;">
        <tr>
        <th class="span1" style="text-align:center;"><input type="checkbox" value="1" id="ck_all"></th>    
        <th class="span2" style="text-align:center;">游戏ID</th>
            <th style="text-align:center;">游戏名称</th>
            <th class="span3" style="text-align:center;">操作</th>
        </tr>
        <?php foreach($list as $v){?>
        <tr>
            <td style="text-align:center;vertical-align:middle;"><input type="checkbox" name="gameid[]" value="<?=$v['gameid']?>"></td>        
            <td style="text-align:center;vertical-align:middle;"><?=$v['gameid']?></td>
                <td style="text-align:center;vertical-align:middle;"><?=$v['gamename']?></td>
                <td style="text-align:center;vertical-align:middle;">
                    <a href="?m=sysinfo&ac=gamelink_edit&gameid=<?=$v['gameid']?>" class="btn btn-primary">修改</a>
                    <a href="?m=sysinfo&ac=gamelink_del&gameid=<?=$v['gameid']?>" class="btn btn-danger" onClick="return confirm('确定要删除吗？')">删除</a>
                    <a href="?m=make&ac=make_game_detail&ids=<?=$v['gameid']?>" target="_blank" class="btn btn-primary">生成</a>
                </td>
            </tr>
        <?php }?>
        </table>
        <?php 
        if ($count>$pagesize) {
            $pager = new Pager($count,$pagesize,"page");
            $pager->show();
        }
        ?>
</div>

<script type="text/javascript">
    $('#ck_all').click(function(){
        if ($(this).attr('checked')) {
            $('input[name="gameid[]"]').attr('checked',true);
        } else {
            $('input[name="gameid[]"]').attr('checked',false);
        }
    })
    $('input[name="gameid[]"]').click(function(){
        if ($('input[name="gameid[]"]:checked').length==0) {
            $('#ck_all').attr('checked',false);
        }
    })
    $('#btn_makesel').click(function(){
        var sel_gameid = [];
        $('input[name="gameid[]"]:checked').each(function(){
            sel_gameid.push($(this).val());
        })
        if (sel_gameid.length==0) {
            alert('请钩选要生成的游戏');
            return false;
        }
        window.open('?m=make&ac=make_game_detail&ids='+sel_gameid.join(','));
    });
</script>
</body>
</html>
